<?php require 'session_mn.php';?>
<?php require 'layout/head.php';?>
<?php manageSession(); checkSession(); ?>
<body onload="submitSuccess(event);" class="bg-light">
<div class="animate__animated animate__zoomIn page-content">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-auto">
            <h5>Select Back Side of NID</h5>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-sm-auto">
            <img id="output" class="prevImg img-fluid" src="resources/img/ph.jpg" />
      </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-auto ">
            <form method="post" action="nid_second_upload.php" enctype="multipart/form-data" id="pageForm">
              <div class="form-group">
                <label class="form-label" for="image" style="cursor: pointer;"><img src="resources/img/index.png" width="40" height="40"/> Choose a Picture</label>
                <input type="file"  name="image" id="image" style="display: none;" accept="image/*;capture=camera" onchange="loadFile(event)" class="form-control">
                <?php 
                    echo'<br>';
                    echo '<input type="text" class="form-control" name="name" id="name" placeholder="Name" value="'.$_SESSION['cust_name'].'" required>';
                    echo '<input type="text" name="nid" id="nid" placeholder="NID" value="'.$_SESSION['cust_id'].'"  required>';
                    echo '<input type="text" name="dob" id="dob" placeholder="DOB(Format:10 Jan 2000)" value="'.$_SESSION['cust_dob'].'"  required>';
                    
                 ?>
                <div id="submit"><input type="submit" value="Next"  name="submit"  class="btn btn-submit" onclick="loadEvent(event)"></div>
              </div>
            </form>
        </div>
    </div>
  </div>
</div>
</body>
<?php require 'layout/footer.php';?>