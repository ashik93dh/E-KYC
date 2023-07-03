<?php  require 'layout/head.php';?>
<?php  require 'session_mn.php';?>
<?php session_start();checkSession();?>
<?php
if (isset($_GET['home'])) {
    
    header('Location:index.php');
  }
?>
<body class="bg-light">
    <div id="loader"></div>
    <div class="animate__animated animate__zoomIn page-content">
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-auto">
                <h5>Process Complete</h5>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-auto">
                <img src="resources/img/success.png" alt="">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-auto" style="margin-top:1em;">
            <a class="btn btn-submit " href="?home" role="button"  id="logout">Back to Home</a>
        </div>
    </div>
    </div>
    </div>
    </div>
</body>
<?php require 'layout/footer.php';?>