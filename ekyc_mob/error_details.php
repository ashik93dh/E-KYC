<?php require 'layout/head.php';?>
<?php session_start();?>
<?php
if (isset($_GET['error_id'])){
    $error_id=$_GET['error_id'];
    $conn=oci_connect('online_user','Admin123','dbhons1');
    if($conn){
        $sql = "SELECT ERROR_ID,CUST_NM,CUST_NID,CUST_DOB,IMG_LOC,TO_CHAR(ENTRY_DT, 'dd/mm/yyyy hh:mi:ss am') as ENTRY_DT,ENTRY_BY  FROM online_user.ekyc_fail_log WHERE ERROR_ID=:error_id";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':error_id', $error_id);
        oci_execute($stid);
        while ($row=oci_fetch_array($stid, OCI_BOTH)) {
            if (isset($row['CUST_NM'])){$name=$row['CUST_NM'];}else{$name='Not collected';}
            if (isset($row['CUST_DOB'])){$dob=$row['CUST_DOB'];}else{$dob='Not collected';}
            if (isset($row['CUST_NID'])){$nid=$row['CUST_NID'];}else{$nid='Not collected';}
            if (isset($row['ENTRY_DT'])){$entry_dt=$row['ENTRY_DT'];}
            if (isset($row['ENTRY_BY'])){$entry_by=$row['ENTRY_BY'];}
            if (isset($row['IMG_LOC'])){$img_loc=$row['IMG_LOC'];}
        }
        
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entry Details</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-5">
            <table class="table table-responsive table-sm">
                <thead>
                    <tr>
                    <th scope="col"><h5><?php echo $name; ?></h5></th>
                    <td></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">ERROR ID</th>
                        <td><?php echo $error_id; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">NID</th>
                        <td><?php echo $nid; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Date of Birth</th>
                        <td><?php echo $dob; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Entry Date</th>
                        <td><?php echo $entry_dt; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Entry By</th>
                        <td><?php echo $entry_by; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-7">
            <table class="table ">
            <caption>List of Failed Submissions(Images). Submitted By <?php echo $entry_by;?></caption>
                <thead>
                    <tr>
                        
                    </tr>
                </thead>
                <tbody>

               
            <?php
                $sql2='SELECT IMG_LOC FROM ONLINE_USER.EKYC_FAIL_LOG WHERE CUST_NID=:CUST_NID';
                $stid2 = oci_parse($conn, $sql2);
                oci_bind_by_name($stid2, ':CUST_NID', $nid);
                oci_execute($stid2);
                while ($row=oci_fetch_array($stid2, OCI_BOTH)) {
                    echo "<tr class='table-active'>";
                    echo'<td>';
                    echo'<div class="det_img">';
                    $remote_img=$img_loc;
                    $local_img='upload/'.$error_id.'.jpg';
                    if(copy($remote_img, $local_img)){
                            echo '<img src="'.$local_img.'" height="160px" width="250px" alt="No Image Found">';
                    }
                    else{
                        echo 'No Image Found';
                    }
                    echo '</div>';
                    echo '</td>';
                    echo '</tr>';
                }  

            ?>
             </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
                <a href="admin.php?dellocal" class="btn btn-primary btn-sm">Go back</a>
        </div>
    </div>    
</div>    
</body>
<?php require 'layout/footer.php';?>
</html>