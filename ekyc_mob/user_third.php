<?php require 'session_mn.php';?>
<?php require 'layout/head.php';?>
<body onload="submitSuccess(event);">
<?php manageSession(); checkSession();?>
<div id="loader"></div>
<div class="animate__animated animate__zoomIn page-content">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-auto">
            <h5>Select Your Image</h5>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-sm-auto">
            <img id="output" class="userImg img-fluid" src="resources/img/ph.jpg" />
      </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-5 offset-sm-3">
            <form method="post" action="verify_image.php" enctype="multipart/form-data" id="pageForm">
              <div class="form-group">
                <label class="form-label" for="image" style="cursor: pointer;"><img src="resources/img/index.png" width="40" height="40" /> Choose a Picture</label>
                <input type="file"  name="image" id="image" style="display: none;" accept="image/*;capture=camera" onchange="loadFile(event)" class="form-control">
                <div id="submit"><input type="submit" value="Next"  name="submit"  class="btn btn-submit" onclick="loadEvent(event)"></div>
              </div>
            </form>
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