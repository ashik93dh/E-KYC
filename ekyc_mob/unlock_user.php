<?php
if(isset($_GET['unlock'])){
    $conn = oci_connect('online_user','Admin123','dbhons1');
    $locked='Y';
    if($conn){
        $sql_1 = oci_parse($conn, "UPDATE online_user.ekyc_fail_log SET locked='N' WHERE img_loc=:img_loc");
        oci_bind_by_name($sql_1, ":img_loc", $_GET['unlock']); 
    }
    $r = oci_execute($sql_1, OCI_NO_AUTO_COMMIT);
    if (!$r) {    
        $e = oci_error($sql_1);
        oci_rollback($conn);  // rollback changes to both tables
        trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    $q = oci_commit($conn);
    if (!$q) {
        $e = oci_error($conn);
        
    }
    else{
        header('Location:admin.php?unlocked=yes');
    }
   
        
}
?>