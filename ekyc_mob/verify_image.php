<?php require 'session_mn.php';?>
<?php require 'config/config.php';?>
<?php
if(isset($_POST["submit"])) {
  error_reporting(0);
  manageSession();
  checkSession();
  $imagePath = getImagePath('online_user','Admin123','dbhons1');
  $uniquesavename=trim(getImageId('online_user','Admin123','dbhons1'));
  $filename = $_FILES["image"]["tmp_name"];
  $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
  $destFile = $imagePath . $uniquesavename . '.'.$ext;
  list($width, $height) = getimagesize( $filename );
  if (move_uploaded_file($_FILES["image"]["tmp_name"], $destFile)) {
    $path = $destFile;
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $_SESSION['base64'] = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $nid_img=$_SESSION['nid_img'];
    $_SESSION['user_img_name']=$uniquesavename.'.'.$ext;
    $_SESSION['output']=$output;
    $_SESSION['user_img']=$destFile;
    $nid=preg_replace("/\s+/", "", $_SESSION['cust_id']);
    $dob=formatDate($_SESSION['cust_dob']);
    if(newCustomer($nid,'online_user','Admin123','dbhons1')){
      if(!checkInvalidData($nid,$_SESSION['cust_name'],'online_user','Admin123','dbhons1')){
        $output=json_decode(shell_exec("python api_scripts/porichoy_facematch_api.py $destFile $nid $dob"),true);
        if($output==null){
          $conn = oci_connect('online_user','Admin123','dbhons1');
          $locked='Y';
          if($conn){
              $sql_1 = oci_parse($conn, 'INSERT INTO online_user.ekyc_fail_log(CUST_NM,CUST_NID,CUST_DOB,ENTRY_BY,IMG_LOC,LOCKED) VALUES(:cust_nm,:cust_nid,:cust_dob,:entry_by,:img_loc,:locked)');
              oci_bind_by_name($sql_1, ":cust_nm", $_SESSION['cust_name']);
              oci_bind_by_name($sql_1, ":cust_nid", $nid);
              oci_bind_by_name($sql_1, ":cust_dob", $_SESSION['cust_dob']);
              oci_bind_by_name($sql_1, ":entry_by", $_SESSION['user']);
              oci_bind_by_name($sql_1, ":img_loc", $nid_img);
              oci_bind_by_name($sql_1, ":locked", $locked);
              $r = oci_execute($sql_1, OCI_NO_AUTO_COMMIT);
              if (!$r) {    
                  $e = oci_error($sql_1);
                  oci_rollback($conn);  // rollback changes to both tables
                  trigger_error(htmlentities($e['message']), E_USER_ERROR);
              }
              $q = oci_commit($conn);
              if (!$q) {
                  $e = oci_error($conn);
                  
              }
          }
          header('Location:index.php?api_check=API error');
        }
        else{
            
            $_SESSION['name']=$output['Name'];
            $_SESSION['cust_dob']=$output['Dob'];
            $_SESSION['fname']=$output['FName'];
            $_SESSION['mname']=$output['MName'];
            $_SESSION['sname']=$output['Spouse'];
            $_SESSION['paddress']=$output['PAddress'];
            $_SESSION['praddress']=$output['PrAddress'];
            $_SESSION['photo']=$output['Photo'];
            $_SESSION['ekyc']=$output['Ekyc'];
            $_SESSION['percentage']=$output['Percentage'];
            $_SESSION['result']=$output['Result'];
            
            header('Location:user_final.php');
        }
      }
      else{
        header('Location:index.php?invalid_check=customer');
      }
        
    }
    else{
      header('Location:index.php?cust_check=customer');
      
    }
  }
  else{
    
  }
}
?>
<script type="text/javascript" src="resources/js/main.js"></script>
<script type="text/javascript" src="resources/js/sweetalert.js"></script>