<?php require 'session_mn.php';?>
<?php session_start();checkSession();?>
<?php require 'fetch_customer_id.php';?>
<?php require 'layout/head.php';?>
<body onload="configure();" class="bg-light">
<div id="loader"></div>
<div class="animate__animated animate__zoomIn page-content">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-auto">
            <h5>Capture Your Image</h5>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-sm-auto">
        <div id="cam-title"></div>      
        <div id="my_camera"></div>
      </div>
      <div class="col-sm-auto">
      <form id="myform" method="post" action="verify_image.php">
            <input id="mydata" type="hidden" name="mydata" value=""/>
        </form>
        <div id="results-title"  ></div>
        <div id="results"  ></div>
      </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-auto">
              <input type=button value="Take Photo" onClick="take_snapshot()" class="btn btn-submit" id="take_snap">
        </div>
        <div class="col-sm-auto">
              <input type=button value="Next" onClick="saveSnap();loadEvent();" style="display: none;" id="save" class="btn btn-submit">
        </div>
    </div>
    <div class="row ">
      <div class="col-sm-auto mt-2">
      <p> <?php if($_SESSION['cust_name']!=null){echo '<strong>Name </strong>'. $_SESSION['cust_name'];} ?>  <strong>NID</strong> <?php echo $_SESSION['cust_id']; ?>  <strong>Date of Birth</strong> <?php echo $_SESSION['cust_dob']; ?></p>
      </div>
    </div>
  </div>
</div>
</body>
<?php require 'layout/footer.php';?>    
