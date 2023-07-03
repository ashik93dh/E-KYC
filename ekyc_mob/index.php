<?php require 'session_mn.php';?>
<?php require 'layout/head.php';?>
<?php manageSession();checkSession();?>
<body class="bg-light">
<div id="loader"></div>
<div class="animate__animated animate__zoomIn page-content">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-auto">
            <h5>Select Front Side of NID</h5>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-sm-auto">
            <img id="output" class="prevImg img-fluid" src="resources/img/ph.jpg" id="cropped_img" />
      </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-5 offset-sm-3">
            <form method="post" action="nid_first_upload.php" enctype="multipart/form-data" id="pageForm">
              <div class="form-group" id="choosePic">
                <label class="form-label" for="image" style="cursor: pointer;"><img src="resources/img/index.png" width="50" height="50"/> Choose a Picture</label>
                <input type="file"  name="image" id="image" style="display: none;" accept="image/*;capture=camera" onchange="loadFile(event);" class="form-control">
                <div id="submit"><input type="submit" value="Next"  name="submit"  class="btn btn-submit" onclick="loadEvent(event);startTimer();"></div>
              </div>
            </form>
        </div>
    </div>
  </div>
</div>
</body>
<?php 
if(isset($_GET['u_data'])||isset($_GET['api_check'])||isset($_GET['cust_check'])||isset($_GET['data_check'])||isset($_GET['invalid_check'])){
  if(isset($_GET['u_data'])){
    echo "<script> alert('Not a NID Picture')</script>";
  }
  if(isset($_GET['api_check'])){
    echo "<script> alert('Verification Unsuccessful')</script>";
  }
  if(isset($_GET['cust_check'])){
    echo "<script> alert('Customer already registered')</script>";
  }
  if(isset($_GET['data_check'])){
    echo "<script> alert('Cannot detect NID or Date of Birth')</script>";
  }
  if(isset($_GET['invalid_check'])){
    echo "<script> alert('EKYC of this person is now blocked.Please contact IT for further instruction ')</script>";
  }
}
?>
<?php require 'layout/footer.php';?>    
