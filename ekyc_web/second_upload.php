<?php require 'session_mn.php';?>
<?php require 'config/config.php';?>
<?php
if(isset($_POST['mydata'])){
session_start();
checkSession();
$encoded_data = $_POST['mydata'];
$binary_data = base64_decode( $encoded_data );
$file_path=getImagePath('online_user','Admin123','dbhons1');
$file_id=trim(getImageId('online_user','Admin123','dbhons1'));
$file_name = $file_id. '.jpg';
$file=$file_path.$file_name;
$result = file_put_contents( $file, $binary_data );
if (!$result) die("Could not save image!  Check file permissions.");
$_SESSION['nid_back']=$file;
$_SESSION['nid_img_back_name']=$file_name;
header('Location:user_third.php');
}
?>