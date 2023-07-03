<?php
// Create connection to Oracle

function dbConnect($user,$pass,$db){
   $conn = oci_connect($user, $pass,$db);
   if (!$conn) 
   {
      $m = oci_error();
      echo $m['message'], "\n";
      return false;
   }
   else{
      return true;
   }
}
function getImageId($user,$pass,$db){
   $conn = oci_connect($user, $pass,$db);
   if (!$conn) 
   {
      $m = oci_error();
      echo $m['message'], "\n";
      exit;
   }
   else 
   {
      $s = oci_parse($conn, "begin :ret :=get_img_no(:param1); end;");
      $param = "IMG_SL";
      oci_bind_by_name($s, ':ret', $r, 200);
      oci_bind_by_name($s, ':param1', $param);
      oci_execute($s);
      oci_close($conn);
      return $r;
   }
}
function getekycId($user,$pass,$db){
   $conn = oci_connect($user, $pass,$db);
   if (!$conn) 
   {
      $m = oci_error();
      echo $m['message'], "\n";
      exit;
   }
   else 
   {
      $s = oci_parse($conn, "begin :ret :=get_img_no(:param1); end;");
      $param = "EKYC_ID";
      oci_bind_by_name($s, ':ret', $r, 200);
      oci_bind_by_name($s, ':param1', $param);
      oci_execute($s);
      oci_close($conn);
      return $r;
   }
}
function getImagePath($user,$pass,$db){
   $conn = oci_connect($user, $pass,$db);
   if (!$conn) 
   {
      $m = oci_error();
      echo $m['message'], "\n";
      return 0;
   }
   else 
   {
      $sql = 'SELECT dir_path,dir_name FROM images.image_path@dbhrac WHERE dir_name= :didbv';
      $stid = oci_parse($conn, $sql);
      $didbv = "ekyc_img";
      oci_bind_by_name($stid, ':didbv', $didbv);
      oci_execute($stid);
      $row = oci_fetch_array($stid, OCI_BOTH);
      $path= $row[0];
      oci_close($conn);
      return $path;
   }   
}
function newCustomer($nid,$user,$pass,$db){
   $conn = oci_connect($user, $pass,$db);
   $result=false;
   if (!$conn) 
   {
      $m = oci_error();
      echo $m['message'], "\n";
      return 0;
   }
   else 
   {
      $sql = 'SELECT count(ekyc_id) FROM ekys_cust_mast WHERE cust_nid= :nid OR cust_sm_id=:nid';
      $stid = oci_parse($conn, $sql);
      oci_bind_by_name($stid, ':nid', $nid);
      oci_execute($stid);
      $row = oci_fetch_array($stid, OCI_BOTH);
      $count= $row[0];
      if($count>=1){
         $result= false;
      }
      else{
         $result=true;
      }
   }  
    return $result;
}
function checkUser($user,$pass,$db,$user_name,$password){
   $conn = oci_connect($user, $pass,$db);
   $result=false;
   if (!$conn) 
   {
      $m = oci_error();
      echo $m['message'], "\n";
      return 0;
   }
   else 
   {
      $sql = 'SELECT count(empsrtname) FROM dbh_user.user_pass@dbhrac WHERE empsrtname=:srtname';
      $stid = oci_parse($conn, $sql);
      oci_bind_by_name($stid, ':srtname', $user_name);
      oci_execute($stid);
      $row = oci_fetch_array($stid, OCI_BOTH);
      $count= $row[0];
      if($count>=1){
         $sql2='select dbh_user.decrypt(emp_status,empl_no)  from dbh_user.user_pass@dbhrac where empsrtname=:srtname';
         $stid2 = oci_parse($conn, $sql2);
         oci_bind_by_name($stid2, ':srtname', $user_name);
         oci_execute($stid2);
         $row = oci_fetch_array($stid2, OCI_BOTH);
         $dec_pass= $row[0];
         if($password==$dec_pass){
            $result=true;
         }
         else{
            $result=false;
         }
      }
      else{
         $result=false;
      }
   }  
    return $result;
}
function deleteUserfile($file){
   unlink($file);
}
function formatDate($x){
   $str=$x;
   $dob=preg_replace("/\s+/", "", $str);
   $day=substr($dob,0,2);
   $month=substr($dob,2,3);
   $year=substr($dob,5,4);
   $month_arr = array("Jan", "Feb", "Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
   for ($x = 0; $x <= count($month_arr)-1; $x++) {
       if(strtoupper($month_arr[$x])==strtoupper($month)){
           $month=$x+1;
       }
     }
   $month=str_pad($month, 2, '0', STR_PAD_LEFT);
   $new_date=$year.'-'.$month.'-'.$day;
   return $new_date;//$dob1='yyyy-mm-dd' format
}
function processNID($nid,$dob){
   $year=substr($dob,6,4);
   return $year.$nid;
}
function checkInvalidData($nid,$name,$user,$pass,$db){
   $conn = oci_connect($user, $pass,$db);
   $sql = 'SELECT count(*) FROM online_user.ekyc_fail_log WHERE cust_nm=:cust_name or cust_nid=:cust_nid';
   $stid = oci_parse($conn, $sql);
   oci_bind_by_name($stid, ':cust_name', $name);
   oci_bind_by_name($stid, ':cust_nid', $nid);
   oci_execute($stid);
   $row = oci_fetch_array($stid, OCI_BOTH);
   $count= $row[0];
   if($count>=2){
      $result=true;
   }
   else{
      $result=false;
   }
   return $result;
}
?>