<?php require 'config/config.php';?>
<?php require 'session_mn.php';?>
<?php
if(isset($_POST['submit']))
{ 
  manageSession();
  checkSession();
  if($_POST['name']!=null and $_POST['nid']!=null and $_POST['dob']!=null){
    $_SESSION['cust_name']=$_POST['name'];
    $_SESSION['cust_id']=$_POST['nid'];
    $_SESSION['cust_dob']=$_POST['dob'];
  }
  $imagePath = getImagePath('online_user','Admin123','dbhons1');
  $uniquesavename=trim(getImageId('online_user','Admin123','dbhons1'));
  $filename = $_FILES["image"]["tmp_name"];
  $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
  $destFile = $imagePath . $uniquesavename . '.'.$ext;
  list($width, $height) = getimagesize( $filename );       
  if(move_uploaded_file($filename,  $destFile)){
      $_SESSION['nid_img_back']=$destFile;
      $_SESSION['nid_img_back_name']=$uniquesavename.'.'.$ext;
      
      header('Location:user_third.php');
  }
  else{
      header('Location:index.php');
  }

}

?>