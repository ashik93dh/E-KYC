<?php require 'layout/head.php';?>
<?php session_start();?>
<?php
if (isset($_GET['ekyc_id'])){
    $ekyc_id=$_GET['ekyc_id'];
    $conn=oci_connect('online_user','Admin123','dbhons1');
    if($conn){
        $sql = "SELECT EKYC_ID,CUST_NM,CUST_DOB,CUST_F_NAME,MATCH_PER,CUST_M_NAME,CUST_SPOUSE,CUST_NID,CUST_SM_ID,CUST_DOB,TO_CHAR(EKYC_DT, 'dd/mm/yyyy hh:mi:ss am') as EKYC_DT,EKYC_BY  FROM online_user.ekys_cust_mast WHERE ekyc_id=:ekyc_id";
        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':ekyc_id', $ekyc_id);
        oci_execute($stid);
        while ($row=oci_fetch_array($stid, OCI_BOTH)) {
            if (isset($row['CUST_NM'])){$name=$row['CUST_NM'];}
            if (isset($row['CUST_DOB'])){$dob=$row['CUST_DOB'];}
            if (isset($row['CUST_NID'])){$nid=$row['CUST_NID'];}else{$nid='Not collected';}
            if (isset($row['CUST_SM_ID'])){$smart_id=$row['CUST_SM_ID'];}else{$smart_id='Not collected';}
            if (isset($row['CUST_F_NAME'])){$f_name=$row['CUST_F_NAME'];}
            if (isset($row['CUST_M_NAME'])){$m_name=$row['CUST_M_NAME'];}
            if (isset($row['CUST_SPOUSE'])){$s_name=$row['CUST_SPOUSE'];}else{$s_name='Not collected';}
            if (isset($row['EKYC_DT'])){$ekyc_dt=$row['EKYC_DT'];}
            if (isset($row['EKYC_BY'])){$ekyc_by=$row['EKYC_BY'];}
            if (isset($row['MATCH_PER'])){$match_per=$row['MATCH_PER'];}
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
                        <th scope="row">EKYC ID</th>
                        <td><?php echo $ekyc_id; ?></td>
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
                        <th scope="row">Smart ID</th>
                        <td><?php echo $smart_id; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Father's Name</th>
                        <td><?php echo $f_name; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Mother's Name</th>
                        <td><?php echo $m_name; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Spouse's Name</th>
                        <td><?php echo $s_name; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">EKYC Date</th>
                        <td><?php echo $ekyc_dt; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">EKYC By</th>
                        <td><?php echo $ekyc_by; ?></td>
                    </tr>

                    <tr>
                        <th scope="row">Match Percentage</th>
                        <td><?php echo $match_per.' %'; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-7">
            <table class="table ">
            <caption>List of Images. Submitted By <?php echo $ekyc_by;?></caption>
                <thead>
                    <tr>
                        
                    </tr>
                </thead>
                <tbody>

               
            <?php
                $sql2='SELECT * FROM ONLINE_USER.EKYC_IMG WHERE EKYC_ID=:EKYC_ID ORDER BY SN DESC';
                $stid2 = oci_parse($conn, $sql2);
                oci_bind_by_name($stid2, ':EKYC_ID', $ekyc_id);
                oci_execute($stid2);
                while ($row=oci_fetch_array($stid2, OCI_BOTH)) {
                    echo "<tr class='table-active'>";
                    echo '<th scope="row" class=" text-center">'.$row['IMG_TYP'].'</th>';
                    echo'<td>';
                    echo'<div class="det_img">';
                    $remote_img='//192.107.2.154/DBH-FSDATA/dbh_all/ekyc_img/'.$row['IMG_NM'];
                    $local_img='upload/'.$row['IMG_NM'];
                    if(copy($remote_img, $local_img)){
                        if($row['IMG_TYP']=='User Image'){
                            echo '<img src="'.$local_img.'" height="120px" width="100px" alt="No Image Found">';
                        }
                        else{
                            echo '<img src="'.$local_img.'" height="160px" width="250px" alt="No Image Found">';
                        }
                        
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