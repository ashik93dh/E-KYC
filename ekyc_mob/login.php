<?php require 'layout/head.php';?>
<?php
if(isset($_SESSION['user'])){
session_unset();
session_destroy();


}
if (isset($_POST['submit'])){
    $name=strtoupper($_POST['user_name']);
    $pass=$_POST['password'];
    if(checkUser('online_user','Admin123','dbhons1',$name,$pass)){
        session_start();
        $_SESSION['user']=$name;
        header('Location:index.php');
    }
    else if($name=='ADMIN' && $pass=='admin1234'){
        session_start();
        $_SESSION['user']=$name;
        $_SESSION['pass']=$pass;
        header('Location:admin.php');
    }
    else{
        echo "<script> alert('Short name or password incorrect')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-3 bg-muted">
                <form class="form-signin" method="post" action="login.php" autocomplete="off">
                    <label for="inputEmail" class="sr-only">Short Name</label>
                    <input  id="inputEmail" class="form-control"  required="" autofocus="" name="user_name">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="inputPassword" class="form-control"  required="" name="password">
                    <input type="submit" value="Log In" class="btn btn-md btn-success" name="submit" style="margin-top:1em;">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php require 'layout/footer.php';?> 