<?php require 'session_mn.php';?>
<?php require 'config/config.php';?>
<?php
if(isset($_POST['mydata'])){
session_start();
$encoded_data = $_POST['mydata'];
$binary_data = base64_decode( $encoded_data );
$file_path=getImagePath('online_user','Admin123','dbhons1');
$file_id=trim(getImageId('online_user','Admin123','dbhons1'));
$file_name = $file_id. '.jpg';
$file=$file_path.$file_name;
$result = file_put_contents( $file, $binary_data );
if (!$result) die("Could not save image!  Check file permissions.");
$nid=preg_replace("/\s+/", "", $_SESSION['cust_id']);
$dob=formatDate($_SESSION['cust_dob']);
if (strlen($nid)==13){
    $nid=processNID($nid,$dob);
  }
if($file!=null && $nid!=null){
    if(newCustomer($nid,'online_user','Admin123','dbhons1')){
        $output=json_decode(shell_exec("python api_scripts/porichoy_facematch_api.py $file $nid $dob"),true);
        if($output==null){
            $conn = oci_connect('online_user','Admin123','dbhons1');
            if($conn){
                $sql_1 = oci_parse($conn, 'INSERT INTO online_user.ekyc_fail_log(CUST_NM,CUST_NID,CUST_DOB,ENTRY_BY,IMG_LOC) VALUES(:cust_nm,:cust_nid,:cust_dob,:entry_by,:img_loc)');
                oci_bind_by_name($sql_1, ":cust_nm", $_SESSION['cust_name']);
                oci_bind_by_name($sql_1, ":cust_nid", $_SESSION['cust_id']);
                oci_bind_by_name($sql_1, ":cust_dob", $_SESSION['cust_dob']);
                oci_bind_by_name($sql_1, ":entry_by", $_SESSION['user']);
                oci_bind_by_name($sql_1, ":img_loc", $destFile);
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
            header('Location:index.php?api_check=Api credit limit reached');
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
            $_SESSION['user_img_name']=$file_name;
            $_SESSION['user_img']=$file;
            file_put_contents( 'upload/'.$file_name, $binary_data );
            header('Location:user_final.php');
            }
        }
        else{
            header('Location:index.php?u_data=exists');
        }

    }

}

?>