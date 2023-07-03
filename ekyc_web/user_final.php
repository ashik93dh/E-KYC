<?php require 'layout/head.php';?>
<?php require 'session_mn.php';?>
<?php require 'config/config.php';?>
<?php session_start();checkSession();?>
<?php
$usr_id=$_SESSION['customer_req_id'];
$user=$_SESSION['user'];
$name=$_SESSION['name'];
$nid=preg_replace("/\s+/", "", $_SESSION['cust_id']);
$dob=$_SESSION['cust_dob'];
$p_add='Permanent';
$pr_add='Present';
$img=$_SESSION['user_img'];
$api_name=$_SESSION['name'];
$api_fname=$_SESSION['fname'];
$api_mname=$_SESSION['mname'];
$api_sname=$_SESSION['sname'];
$api_paddress=$_SESSION['paddress'];
$api_praddress=$_SESSION['praddress'];
$api_photo=$_SESSION['photo'];
$api_ekyc=$_SESSION['ekyc'];
$api_percentage=$_SESSION['percentage'];

if($_SESSION['result']){
  $api_result='Matched';
}
else{
  $api_result='Did Not Match';
}
$nid_front=$_SESSION['nid_img_front_name'];
$nid_front_typ='NID Front';
$nid_front_val='1';

$nid_back=$_SESSION['nid_img_back_name'];
$nid_back_typ='NID Back';
$nid_back_val='2';

$user_img_typ='User Image';
$user_img_val='3';
$user_img=$_SESSION['user_img_name'];

$api_photo=base64_decode($api_photo);
$api_photo_local='upload/'.$nid.'.jpg';
file_put_contents($api_photo_local,$api_photo);
$user_img_local='upload/'.$user_img;



$usr_id=$_SESSION['customer_req_id'];
$ekyc_id=getekycId('online_user','Admin123','dbhons1');
if(isset($_POST['save'])){
  $conn = oci_connect('online_user','Admin123','dbhons1');
  if($conn){
    $sql_1 = oci_parse($conn, 'INSERT INTO online_user.ekyc_img (EKYC_ID,SN,IMG_TYP,IMG_NM) VALUES(:ekyc_id,:sn,:img_typ,:img_nm)');
    oci_bind_by_name($sql_1, ":ekyc_id", $ekyc_id);
    oci_bind_by_name($sql_1, ":sn", $nid_front_val);
    oci_bind_by_name($sql_1, ":img_typ", $nid_front_typ);
    oci_bind_by_name($sql_1, ":img_nm", $nid_front);
    $r = oci_execute($sql_1, OCI_NO_AUTO_COMMIT);
    if (!$r) {    
        $e = oci_error($sql_1);
        oci_rollback($conn);  // rollback changes to both tables
        trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    $sql_2 = oci_parse($conn, 'INSERT INTO online_user.ekyc_img(EKYC_ID,SN,IMG_TYP,IMG_NM) VALUES(:ekyc_id,:sn,:img_typ,:img_nm)');
    oci_bind_by_name($sql_2, ":ekyc_id", $ekyc_id);
    oci_bind_by_name($sql_2, ":sn", $nid_back_val);
    oci_bind_by_name($sql_2, ":img_typ", $nid_back_typ);
    oci_bind_by_name($sql_2, ":img_nm", $nid_back);
    $m = oci_execute($sql_2, OCI_NO_AUTO_COMMIT);
    if (!$m) {    
        $e = oci_error($sql_2);
        oci_rollback($conn);  // rollback changes to both tables
        trigger_error(htmlentities($e['message']), E_USER_ERROR);

    }
    $sql_3 = oci_parse($conn, 'INSERT INTO online_user.ekyc_img (EKYC_ID,SN,IMG_TYP,IMG_NM) VALUES(:ekyc_id,:sn,:img_typ,:img_nm)');
    oci_bind_by_name($sql_3, ":ekyc_id", $ekyc_id);
    oci_bind_by_name($sql_3, ":sn", $user_img_val);
    oci_bind_by_name($sql_3, ":img_typ", $user_img_typ);
    oci_bind_by_name($sql_3, ":img_nm", $user_img);
    $f = oci_execute($sql_3, OCI_NO_AUTO_COMMIT);
    if (!$f) {    
        $e = oci_error($sql_3);
        oci_rollback($conn);  // rollback changes to both tables
        trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    if (strlen($nid)==10){
      $sql_4 = oci_parse($conn, "INSERT INTO online_user.ekys_cust_mast(EKYC_ID,CUST_NM,CUST_SM_ID,CUST_DOB,CUST_F_NAME,CUST_M_NAME,CUST_SPOUSE,MATCH_PER,EKYC_BY) 
                                                                  VALUES(:EKYC_ID,:CUST_NM,:CUST_NID,to_date(:CUST_DOB,'mm/dd/yyyy'),:CUST_F_NAME,:CUST_M_NAME,:CUST_SPOUSE,:MATCH_PER,:EKYC_BY)");
      oci_bind_by_name($sql_4, ":EKYC_ID", $ekyc_id);
      oci_bind_by_name($sql_4, ":CUST_NM", $api_name);
      oci_bind_by_name($sql_4, ":CUST_NID", $nid);
      oci_bind_by_name($sql_4, ":CUST_DOB", $dob);
      oci_bind_by_name($sql_4, ":CUST_F_NAME", $api_fname);
      oci_bind_by_name($sql_4, ":CUST_M_NAME", $api_mname);
      oci_bind_by_name($sql_4, ":CUST_SPOUSE", $api_sname);
      oci_bind_by_name($sql_4, ":MATCH_PER", $api_percentage);
      oci_bind_by_name($sql_4, ":EKYC_BY", $user);
    }
    else{
      $sql_4 = oci_parse($conn, "INSERT INTO online_user.ekys_cust_mast(EKYC_ID,CUST_NM,CUST_NID,CUST_DOB,CUST_F_NAME,CUST_M_NAME,CUST_SPOUSE,MATCH_PER,EKYC_BY) 
                                                                  VALUES(:EKYC_ID,:CUST_NM,:CUST_NID,to_date(:CUST_DOB,'mm/dd/yyyy'),:CUST_F_NAME,:CUST_M_NAME,:CUST_SPOUSE,:MATCH_PER,:EKYC_BY)");
      oci_bind_by_name($sql_4, ":EKYC_ID", $ekyc_id);
      oci_bind_by_name($sql_4, ":CUST_NM", $api_name);
      oci_bind_by_name($sql_4, ":CUST_NID", $nid);
      oci_bind_by_name($sql_4, ":CUST_DOB", $dob);
      oci_bind_by_name($sql_4, ":CUST_F_NAME", $api_fname);
      oci_bind_by_name($sql_4, ":CUST_M_NAME", $api_mname);
      oci_bind_by_name($sql_4, ":CUST_SPOUSE", $api_sname);
      oci_bind_by_name($sql_4, ":MATCH_PER", $api_percentage);
      oci_bind_by_name($sql_4, ":EKYC_BY", $user);
    }
    $t = oci_execute($sql_4, OCI_NO_AUTO_COMMIT);
    if (!$t) {    
      $e = oci_error($sql_4);
      oci_rollback($conn);  // rollback changes to both tables
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    $sql_5 = oci_parse($conn, 'INSERT INTO online_user.ekys_addr (EKYC_ID,ADDR_TYP,ADDR1) VALUES(:EKYC_ID,:ADDR_TYP,:ADDR1)');
    oci_bind_by_name($sql_5, ":EKYC_ID", $ekyc_id);
    oci_bind_by_name($sql_5, ":ADDR_TYP", $p_add);
    oci_bind_by_name($sql_5, ":ADDR1", $api_paddress);
    $z = oci_execute($sql_5, OCI_NO_AUTO_COMMIT);
    if (!$z) {    
        $e = oci_error($sql_5);
        oci_rollback($conn);  // rollback changes to both tables
        trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    $q = oci_commit($conn);
    if (!$q) {
        $e = oci_error($conn);
        echo 'problem in user image';
    }
    else{
      header('Location:finish_proc.php');
    }
  }
  else{
    echo 'connection error';
  }
}
if (isset($_GET['home'])) {
  unlink($_SESSION['nid_front']);
  unlink($_SESSION['nid_back']);
  unlink($_SESSION['user_img']);
  header('Location:index.php');
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
  <div class="row bg-transparent justify-content-center">
    <div class='col-sm-2'>
      <img src=<?php echo (isset($api_photo_local)) ? $api_photo_local: ''?>   width="150" height="150">
    </div>
    <div class='col-sm-2'>
      <img src=<?php echo (isset($user_img_local)) ? $user_img_local: ''?>   width="150" height="150">
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
    <div class="row bg-transparent">
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
      <div class="col-sm-auto" >
        <form action="user_final.php" method="post">
          <input type='submit' value="Save" name="save" class="btn btn-submit" onClick="finalSubmit(event);">
        </form>   
      </div>
      <div class="col-sm-auto" >
          <a class="btn btn-submit " href="?home" role="button"  id="logout">Start Over</a>
      </div>
    </div>
  </div>
  </div>
</div>
</body>
<?php require 'layout/footer.php';?>