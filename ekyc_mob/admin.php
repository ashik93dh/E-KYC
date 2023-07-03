<?php require 'layout/head.php';?>
<?php 
session_start();
if ($_SESSION['user']!='ADMIN' && $_SESSION['pass']!='deltabrac#1234'){
    header('Location:login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EYC-Admin</title>
</head>
<body>
    <div class="container bg-white">
        <div class="row  ">
            <div class="col-sm-3">
                <?php
                    $conn=oci_connect('online_user','Admin123','dbhons1');
                    if($conn){
                        $sql2 = 'SELECT count(*) FROM online_user.ekys_cust_mast@dbhons1';
                        $stid2 = oci_parse($conn, $sql2);
                        oci_execute($stid2);
                        $row=oci_fetch_array($stid2, OCI_BOTH);
                        echo '<h5><b>Total Entries </b> <a href=all_det.php>'.$row[0].'</a></h5>';
                    }
                ?>
            </div>
            <div class="col-sm-3">
                <?php
                    $conn=oci_connect('online_user','Admin123','dbhons1');
                    if($conn){
                        $sql22 = 'SELECT count(*) FROM online_user.ekyc_fail_log@dbhons1';
                        $stid22 = oci_parse($conn, $sql22);
                        oci_execute($stid22);
                        $row=oci_fetch_array($stid22, OCI_BOTH);
                        echo '<h5><b>Total Errors </b> <a href=all_errors.php>'.$row[0].'</a></h5>';
                    }
                ?>
            </div>
        </div>
        <div class="row">
        <div class="col-sm-8">
            <h6><b>Locked Entries</b></h6>
                    <table class="table table-striped table-bordered table-sm table-hover table-responsive">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Er.ID</td>
                                <th scope="col">Name</td>
                                <th scope="col">NID</td>
                                <th scope="col">Date of Birth</td>
                                <th scope="col">Image Name</td>
                                <th scope="col">Entry By</td>
                                <th scope="col">Entry Time</td>
                            </tr>
                        </thead>
                        <?php
                            $conn=oci_connect('online_user','Admin123','dbhons1');
                            if($conn){
				                $count=0;
                                $sql = "SELECT ERROR_ID,CUST_NM,CUST_NID,TO_CHAR(CUST_DOB, 'dd/mm/yyyy') as CUST_DOB,IMG_LOC,ENTRY_BY,TO_CHAR(ENTRY_DT, 'dd/mm/yyyy hh:mi:ss am') as ENTRY_DT 
                                FROM ONLINE_USER.EKYC_FAIL_LOG WHERE locked='Y'  ORDER BY TO_DATE(ENTRY_DT, 'dd/mm/yyyy hh:mi:ss am') desc";
                                $stid = oci_parse($conn, $sql);
                                oci_execute($stid);
                                while ($row=oci_fetch_array($stid, OCI_BOTH)) {
                                    echo "<tr>";
                                    if (isset($row['ERROR_ID'])){echo "<td><a href=error_details.php?error_id=".$row['ERROR_ID'].">".$row['ERROR_ID']."</td>";}else{echo '<td>Not detected</td>';}
                                    if (isset($row['CUST_NM'])){echo "<td>".$row['CUST_NM']."</td>";}else{echo '<td>Not detected</td>';}
                                    if (isset($row['CUST_NID'])){echo "<td>".$row['CUST_NID']."</td>";}else{echo '<td>Not detected</td>';}
                                    if (isset($row['CUST_DOB'])){echo "<td>".$row['CUST_DOB']."</td>";}else{echo '<td>Not detected</td>';}
                                    if (isset($row['IMG_LOC'])){echo "<td>".substr($row['IMG_LOC'],44)."</td>";}else{echo '<td>Not detected</td>';}
                                    if (isset($row['ENTRY_BY'])){echo "<td>".$row['ENTRY_BY']."</td>";}else{echo '<td>Not detected</td>';}
                                    if (isset($row['ENTRY_DT'])){echo "<td>". $row['ENTRY_DT']."</td>";}else{echo '<td>Not detected</td>';}
                                    
                                    
                                    echo"<td><a  class='btn btn-primary' href=unlock_user.php?unlock=".$row['IMG_LOC'].">Unlock</a></td>";
                                    echo "</tr>";
				                    $count++;
                                }
                                    echo "<tr>";
                                    echo '<td><b>Total</b></td>';
                                    echo '<td>'. $count.'</td>';
                                    echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
            <div class="col-sm-2">
            <h6><b>Entries Today</b></h6>
                <table class="table table-striped table-bordered table-sm table-hover table-responsive">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Name</td>
                            <th scope="col">Entries</td>
                        </tr>
                    </thead>
                    <?php
                        $conn=oci_connect('online_user','Admin123','dbhons1');
                        if($conn){
			                $sum_today=0;
                            $sql3 = 'SELECT count(*) as entries,ekyc_by from ONLINE_USER.EKYS_CUST_MAST where trunc(ekyc_dt)=trunc(sysdate) group by ekyc_by order by entries desc';
                            $stid3 = oci_parse($conn, $sql3);
                            oci_execute($stid3);
                            while ($row=oci_fetch_array($stid3, OCI_BOTH)) {
                                echo "<tr>";
                                if (isset($row['EKYC_BY'])){echo "<td><a href=emp_det.php?ekyc_by=".$row['EKYC_BY'].">".$row['EKYC_BY']."</a></td>";}else{echo '<td>APP</td>';}
                                if (isset($row['ENTRIES'])){echo "<td><a href=det.php?ekyc_by=".$row['EKYC_BY'].">".$row['ENTRIES']."</a></td>";}else{echo '<td>Not detected</td>';}
                                echo "</tr>";
				                $sum_today=$sum_today+$row['ENTRIES'];
                            }
                                echo "<tr>";
                                echo '<td><b>Total</b></td>';
                                echo '<td>'.$sum_today.'</td>';
                                echo "</tr>";
                        }
                    ?>
                </table>
            </div>
            <div class="col-sm-2">
                <h6><b>Last 10 days</b></h6>
                <table class="table table-striped table-bordered table-sm table-hover table-responsive">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Date</td>
                            <th scope="col">Entries</td>
                        </tr>
                    </thead>
                    <?php
                        $sum=0;
                        $count=0;
                        $conn=oci_connect('online_user','Admin123','dbhons1');
                        if($conn){
                            $sql3 = "SELECT  count(*) as entries,trunc(ekyc_dt) as ekyc_date from ONLINE_USER.EKYS_CUST_MAST where (trunc(sysdate)-trunc(ekyc_dt))<=10 and (trunc(sysdate)!=trunc(ekyc_dt)) group by trunc(ekyc_dt) order by trunc(ekyc_dt) desc";
                            $stid3 = oci_parse($conn, $sql3);
                            oci_execute($stid3);
                            while ($row=oci_fetch_array($stid3, OCI_BOTH)) {
                                echo "<tr>";
                                if (isset($row['EKYC_DATE'])){echo "<td>".$row['EKYC_DATE']."</td>";}else{echo '<td>APP</td>';}
                                if (isset($row['ENTRIES'])){echo "<td>".$row['ENTRIES']."</td>"; $sum=$sum+$row['ENTRIES'];$count++;}else{echo '<td>Not detected</td>';}
                                echo "</tr>";
                            }
                            $avg=$sum/$count;
                            
                        }
                                echo "<tr>";
                                echo '<td><b>Average</b></td>';
                                echo '<td>'. round($avg).'</td>';
                                echo "</tr>";

                    ?>
                </table>
            </div>

    </div>
</body>
<?php require './layout/footer.php';?>
</html>