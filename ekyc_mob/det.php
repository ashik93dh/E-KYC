<?php require 'layout/head.php';?>
<?php session_start();?>
<?php
$ekyc_by=$_GET['ekyc_by'];
?>
<div class="container">
    <div class="row">
        <?php echo '<h5>Entry By: '.$ekyc_by.'</h5>';?>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="table-wrapper-scroll-y my-custom-scrollbar table-responsive">
                <table  class="table table-striped table-bordered table-sm table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <td scope="col">Name</td>
                                    <td scope="col">NID</td>
                                    <td scope="col">Smart ID</td>
                                    <td scope="col">Date of Birth</td>
                                    <td scope="col">Entry Time</td>
                                </tr>
                            </thead>
                            <?php
                                $conn=oci_connect('online_user','Admin123','dbhons1');
                                if($conn){
                                    $count=0;
                                    $sql = "SELECT CUST_NM,CUST_NID,CUST_SM_ID,CUST_DOB,TO_CHAR(EKYC_DT, 'dd/mm/yyyy hh:mi:ss am') as EKYC_DT  FROM online_user.ekys_cust_mast WHERE ekyc_by=:ekyc_by and trunc(ekyc_dt)=trunc(sysdate) order by TO_DATE(EKYC_DT, 'dd/mm/yyyy hh:mi:ss am') DESC";
                                    $stid = oci_parse($conn, $sql);
                                    oci_bind_by_name($stid, ':ekyc_by', $ekyc_by);
                                    oci_execute($stid);
                                    while ($row=oci_fetch_array($stid, OCI_BOTH)) {
                                        echo "<tr>";
                                        if (isset($row['CUST_NM'])){echo "<td>".$row['CUST_NM']."</td>";}else{echo '<td>Not detected</td>';}
                                        if (isset($row['CUST_NID'])){echo "<td>".$row['CUST_NID']."</td>";}else{echo '<td>Not detected</td>';}
                                        if (isset($row['CUST_SM_ID'])){echo "<td>".$row['CUST_SM_ID']."</td>";}else{echo '<td>Not detected</td>';}
                                        if (isset($row['CUST_DOB'])){echo "<td>". $row['CUST_DOB']."</td>";}else{echo '<td>Not detected</td>';}
                                        if (isset($row['EKYC_DT'])){echo "<td>". $row['EKYC_DT']."</td>";}else{echo '<td>Not detected</td>';}
                                        echo "</tr>";
                                        $count++;
                                    }
                                        
                                }
                            ?>
                        </table>
                </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo '<b><h5>Total : '.$count.'</h5></b>';?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <a href="admin.php" class="btn btn-primary btn-sm">Go back</a>
        </div>
    </div>
</div>

<?php require 'layout/footer.php';?>