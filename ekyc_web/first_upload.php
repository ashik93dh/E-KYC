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
$output=json_decode(shell_exec("python api_scripts/script_ocr_api.py $file"),true);
if($output==null){
    unlink($destFile);
    header('Location:index.php?u_data=invalid');
  }
  else{
    $_SESSION['cust_name']=$output['Name'];
    $_SESSION['cust_id']=$output['Nid'];
    $_SESSION['cust_dob']=$output['Dob'];
    $_SESSION['nid_front']=$file;
    $_SESSION['nid_img_front_name']=$file_name;
    
    header('Location:user_second.php');
  }
}
?>