<?php require 'layout/head.php';?>
<?php require 'session_mn.php';?>
<?php
manageSession();
$img=$_SESSION['user_img'];
$nid=$_SESSION['nid'];
$name=$_SESSION['name'];
$dob=$_SESSION['dob'];
$api_fname=$_SESSION['fname'];
$api_mname=$_SESSION['mname'];
$api_sname=$_SESSION['sname'];
$api_paddress=$_SESSION['paddress'];
$api_praddress=$_SESSION['praddress'];
$api_photo=$_SESSION['photo'];
$api_ekyc=$_SESSION['ekyc'];
$api_percentage=$_SESSION['percentage'];
$ses_id=$_SESSION['session_id'];
$ekyc_id=$_SESSION['ekyc_id'];

if (isset($_GET['logout'])) {
  header("Location:http://192.107.2.13:8080/ords/f?p=100:8:$ses_id:P_EKYC_ID:$ekyc_id");
  
}
?>

<body class="bg-light">
<div id="loader"></div>
<div class="animate__animated animate__zoomIn page-content">
  <div class="container">
  <div class="row justify-content-center text-white bg-success">
      <div class="col-sm-auto">
            <h5>Result Summary</h5>
      </div>
  </div>
  <div class="row bg-transparent">
    <div class="col-sm-auto">
      <div class="d-inline-flex p-2  justify-content-center">
          <div class="d-flex ">
            <div class="p-3 bd-highlight"><h6><dt>Name</dt> <dd><?php echo (isset($name)) ? $name: ''?></dd></h6></div>
            <div class="p-3"><h6><dt>NID</dt> <?php echo (isset($nid)) ? $nid: ''?></h6></div>
            <div class="p-3"><h6><dt>Date of Birth</dt> <?php echo (isset($dob)) ? $dob: ''?></h6></div>
          </div>
          <div class="d-flex ">
            <div class="p-3"><h6><dt>Result</dt> <?php echo (isset($api_result)) ? $api_result: ''?></h6></div>
            <div class="p-3"><h6><dt>Percentage</dt> <?php echo (isset($api_percentage)) ? $api_percentage: ''?>%</h6></div>
            <div class="p-3"><h6><dt>E-KYC PASSED</dt> <?php echo (isset($api_ekyc)) ? $api_ekyc: ''?></h6></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center text-white bg-success">
      <div class="col-sm-auto">
            <h5>Other Relevant Information</h5>
      </div>
    </div>
    <div class="row bg-transparent mt-1">
      <div class="col-sm-8 ">
        <div class="d-inline-flex p-2 flex-wrap">
          <div class="d-flex ">
            <div class="p-3"><h6><dt>Father's Name</dt> <?php echo (isset($api_fname)) ? $api_fname: ''?></h6></div>
            <div class="p-3"><h6><dt>Mother's Name</dt><?php echo (isset($api_mname)) ? $api_mname: ''?></h6></div>
            <div class="p-3"><h6><dt>Spouse's Name</dt> <?php echo (isset($api_sname)) ? $api_sname: ''?></h6></div>
          </div>
          <div class="d-flex flex-column">
            <div class="p-3"><h6><dt>Permanent Address</dt> <?php echo (isset($api_paddress)) ? $api_paddress: ''?></h6></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
    <div class="col-sm-auto" style="margin-top:1em;">
          <a class="btn btn-submit " href="?logout" role="button"  id="logout">Finish</a>
      </div>
    </div>
  </div>
  </div>
</div>
</body>