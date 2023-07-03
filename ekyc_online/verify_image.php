<?php require 'config/config.php';?>
<?php require 'session_mn.php';?>
<?php require 'fetch_customer_id.php';?>
<?php
error_reporting(0);
manageSession();
$destFile=$user_img;
$new_dir=strval(getImagePath('online_user','Admin123','dbhons1'));
$nid=strval(preg_replace("/\s+/", "", $user_nid));
$dob=formatDate($user_dob);
//echo $dob;
if ($destFile!=null && $nid!=null && $dob!=null){
    if(newCustomer($nid,'online_user','Admin123','dbhons1')){
        $output=json_decode(shell_exec("python api_scripts/porichoy_facematch_api.py $destFile $nid $dob"),true);
        if($output==null){
            echo 'Nothing Found';
            endSession();
        }
        else{
            $name=$output['Name'];
            $dob=$output['Dob'];
            $fname=$output['FName'];
            $mname=$output['MName'];
            $sname=$output['Spouse'];
            $p_address=$output['PAddress'];
            $pr_address=$output['PrAddress'];
            $nid_user_img=$output['Photo'];
            $ekyc_stat=$output['Ekyc'];
            $percentage=$output['Percentage'];
            $result=$output['Result'];
            $_SESSION['photo']=$output['Photo'];
            $p_add='Permanent';
            $pr_add='Present';
            $user='APP';
            $ekyc_id=getekycId('online_user','Admin123','dbhons1');
            $conn = oci_connect('online_user','Admin123','dbhons1');
            if($conn){
                if (strlen($nid)==10){
                    $sql_4 = oci_parse($conn, "INSERT INTO online_user.ekys_cust_mast(EKYC_ID,CUST_NM,CUST_SM_ID,CUST_DOB,CUST_F_NAME,CUST_M_NAME,CUST_SPOUSE,MATCH_PER) 
                                                                                VALUES(:EKYC_ID,:CUST_NM,:CUST_NID,to_date(:CUST_DOB,'mm/dd/yyyy'),:CUST_F_NAME,:CUST_M_NAME,:CUST_SPOUSE,:MATCH_PER)");
                    oci_bind_by_name($sql_4, ":EKYC_ID", $ekyc_id);
                    oci_bind_by_name($sql_4, ":CUST_NM", $name);
                    oci_bind_by_name($sql_4, ":CUST_NID", $nid);
                    oci_bind_by_name($sql_4, ":CUST_DOB", $dob);
                    oci_bind_by_name($sql_4, ":CUST_F_NAME", $fname);
                    oci_bind_by_name($sql_4, ":CUST_M_NAME", $mname);
                    oci_bind_by_name($sql_4, ":CUST_SPOUSE", $sname);
                    oci_bind_by_name($sql_4, ":MATCH_PER", $percentage);
                }
                else{
                    $sql_4 = oci_parse($conn, "INSERT INTO online_user.ekys_cust_mast(EKYC_ID,CUST_NM,CUST_NID,CUST_DOB,CUST_F_NAME,CUST_M_NAME,CUST_SPOUSE,MATCH_PER,EKYC_BY) 
                                                                                VALUES(:EKYC_ID,:CUST_NM,:CUST_NID,to_date(:CUST_DOB,'mm/dd/yyyy'),:CUST_F_NAME,:CUST_M_NAME,:CUST_SPOUSE,:MATCH_PER,:EKYC_BY)");
                    oci_bind_by_name($sql_4, ":EKYC_ID", $ekyc_id);
                    oci_bind_by_name($sql_4, ":CUST_NM", $name);
                    oci_bind_by_name($sql_4, ":CUST_NID", $nid);
                    oci_bind_by_name($sql_4, ":CUST_DOB", $dob);
                    oci_bind_by_name($sql_4, ":CUST_F_NAME", $fname);
                    oci_bind_by_name($sql_4, ":CUST_M_NAME", $mname);
                    oci_bind_by_name($sql_4, ":CUST_SPOUSE", $sname);
                    oci_bind_by_name($sql_4, ":MATCH_PER", $percentage);
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
                oci_bind_by_name($sql_5, ":ADDR1", $p_address);
                $z = oci_execute($sql_5, OCI_NO_AUTO_COMMIT);
                if (!$z) {    
                $e = oci_error($sql_5);
                oci_rollback($conn);  // rollback changes to both tables
                trigger_error(htmlentities($e['message']), E_USER_ERROR);
                }
                $q = oci_commit($conn);
                if (!$q) {
                    $e = oci_error($conn);
                    echo 'problem in storing data';
                }
                else{

                    $_SESSION['name']=$name;
                    $_SESSION['dob']=$dob;
                    $_SESSION['fname']=$fname;
                    $_SESSION['mname']=$mname;
                    $_SESSION['sname']=$sname;
                    $_SESSION['paddress']=$p_address;
                    $_SESSION['praddress']=$pr_address;
                    $_SESSION['nid']=$nid;

                    $_SESSION['ekyc']=$output['Ekyc'];
                    $_SESSION['percentage']=$output['Percentage'];
                    $_SESSION['result']=$output['Result'];
                    $_SESSION['user_img']=$destFile;
                    header("Location:http://192.107.2.13:8080/ords/f?p=100:13:$session_id::NO::P_EKYC_ID:$ekyc_id");
                   
                }
            }
        
        }
    }
    else{

        echo 'customer exists';

    }

}
?>
<script type="text/javascript" src="resources/js/main.js"></script>
<script type="text/javascript" src="resources/js/sweetalert.js"></script>