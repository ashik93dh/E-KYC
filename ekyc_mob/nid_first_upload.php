<?php require 'config/config.php';?>
<?php require 'session_mn.php';?>
<?php
if(isset($_POST['submit']))
{ 
  manageSession();
  checkSession();
  $imagePath = getImagePath('online_user','Admin123','dbhons1');
  $uniquesavename=trim(getImageId('online_user','Admin123','dbhons1'));
  $filename = $_FILES["image"]["tmp_name"];
  $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
  $destFile = $imagePath . $uniquesavename . '.'.$ext;
  list($width, $height) = getimagesize( $filename );       
  if(move_uploaded_file($filename,  $destFile)){
      $_SESSION['nid_img']=$destFile;
      $_SESSION['nid_img_front_name']=$uniquesavename.'.'.$ext;
      $output=json_decode(shell_exec("python api_scripts/script_ocr_api.py $destFile"),true);
      if($output==null){
	      //unlink($destFile);
        //header('Location:index.php?u_data=invalid');

        $_SESSION['cust_name']=$output['Name'];
        $_SESSION['cust_id']=$output['Nid'];
        $_SESSION['cust_dob']=$output['Dob'];
        header('Location:user_second.php');
      }
      else{
        if($output['Nid']==null){
	        unlink($destFile);
          header('Location:index.php?data_check=invalid');
        }
        if($output['Dob']==null){
          unlink($destFile);
          header('Location:index.php?data_check=invalid');
        }
        $_SESSION['cust_name']=$output['Name'];
        $output['Nid']=preg_replace('/\s+/', '', $output['Nid']);
        $_SESSION['cust_id']=$output['Nid'];
        $_SESSION['cust_dob']=$output['Dob'];
        header('Location:user_second.php');
      }
  }
  else{
      echo 'Error uploading image';
  }

}

?>