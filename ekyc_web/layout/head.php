<?php
if (isset($_GET['logout'])) {
  session_start();
  endSession();
  header('Location:login.php');
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>eKYC</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/style.css">
    <link rel="stylesheet" href="resources/css/animate.min.css">
    <link rel="stylesheet" href="resources/css/sweetalert.css">
  </head>
  <nav class="navbar navbar-expand-sm bg-transparent justify-content-center">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#"><img src="resources/img/dbh_logo.png" class="logoImg" height="30" width="30"></a>
      </li>
    </ul>
  </nav>
 

