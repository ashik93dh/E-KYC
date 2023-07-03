<?php require 'session_mn.php';?>
<?php require 'fetch_customer_id.php';?>
<?php
session_start();
checkSession();
?>
<?php require 'layout/head.php';?>
<body onload="configure();" class="bg-light">
<div id="loader"></div>
<div class="animate__animated animate__zoomIn page-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-sm-auto">
            <h5 >Capture Front Side of NID</h5>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-sm-auto">
        <div id="cam-title"></div>      
        <div id="my_camera"></div>
      </div>
      <div class="col-sm-auto">
        <form id="myform" method="post" action="first_upload.php">
            <input id="mydata" type="hidden" name="mydata" value=""/>
        </form>
        <div id="results-title"></div>
        <div id="results"  ></div>
      </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-auto">
              <input type=button value="Take Photo" onClick="take_snapshot()" class="btn btn-submit" id="take_snap">
        </div>
        <div class="col-sm-auto">
              <input type=button value="Next" onClick="saveSnap(); loadEvent(event);" style="display: none;" id="save" class="btn btn-submit">
        </div>
    </div>
  </div>
</div>
</body>
<?php require 'layout/footer.php';?>    
<?php 

if(isset($_GET['u_data'])||isset($_GET['api_check'])){
  if(isset($_GET['u_data'])){
    if($_GET['u_data']=='invalid'){
      echo "<script> alert('Not a NID Picture')</script>";
    }
    elseif($_GET['u_data']=='exists'){
      echo "<script> alert('User Exists')</script>";
    }
    else{
      
    }
  }
  if(isset($_GET['api_check'])){
    echo "<script> alert('Verification Unsuccessful')</script>";
  }
}
?>