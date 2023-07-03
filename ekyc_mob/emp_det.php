<?php require 'layout/head.php';?>
<?php session_start();?>
<?php $ekyc_by=$_GET['ekyc_by'];?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h5><?php echo $ekyc_by;?></h5>
        <div class="row">
                <div class="col-sm-10">
                    <h6>All Entries</h6>
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table  class="table table-striped table-bordered table-sm table-responsive">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Name</td>
                                            <th scope="col">NID</td>
                                            <th scope="col">Smart ID</td>
                                            <th scope="col">Date of Birth</td>
                                            <th scope="col">Entry Time</td>
                                        </tr>
                                    </thead>
                                    <?php
                                        
                                        $conn=oci_connect('online_user','Admin123','dbhons1');
                                        if($conn){
                                            $count=0;
                                            $sql = "SELECT EKYC_ID,CUST_NM,CUST_NID,CUST_SM_ID,CUST_DOB,TO_CHAR(EKYC_DT, 'dd/mm/yyyy hh:mi:ss am') as EKYC_DT  FROM online_user.ekys_cust_mast WHERE ekyc_by=:ekyc_by order by TO_DATE(EKYC_DT, 'dd/mm/yyyy hh:mi:ss am') desc";
                                            $stid = oci_parse($conn, $sql);
                                            oci_bind_by_name($stid, ':ekyc_by', $ekyc_by);
                                            oci_execute($stid);
                                            while ($row=oci_fetch_array($stid, OCI_BOTH)) {
                                                echo "<tr>";
                                                if (isset($row['CUST_NM'])){echo "<td><a href=entry_details.php?ekyc_id=".$row['EKYC_ID'].">".$row['CUST_NM']."</td>";}else{echo '<td>Not detected</td>';}
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
                        <?php echo '<b><h6>Total : '.$count.'</h6></b>';?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <h6>All Errors</h6>
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                            <table  class="table table-striped table-bordered table-sm table-responsive">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col">Name</td>
                                                <th scope="col">NID</td>
                                                <th scope="col">Date of Birth</td>
                                                <th scope="col">Entry Time</td>
                                            </tr>
                                        </thead>
                                        <?php
                                            
                                            $conn=oci_connect('online_user','Admin123','dbhons1');
                                            if($conn){
                                                $count=0;
                                                $sql = "SELECT * FROM online_user.ekyc_fail_log WHERE entry_by=:entry_by order by entry_dt desc";
                                                $stid = oci_parse($conn, $sql);
                                                oci_bind_by_name($stid, ':entry_by', $ekyc_by);
                                                oci_execute($stid);
                                                while ($row=oci_fetch_array($stid, OCI_BOTH)) {
                                                    echo "<tr>";
                                                    if (isset($row['CUST_NM'])){echo "<td>".$row['CUST_NM']."</td>";}else{echo '<td>Not detected</td>';}
                                                    if (isset($row['CUST_NID'])){echo "<td>".$row['CUST_NID']."</td>";}else{echo '<td>Not detected</td>';}
                                                    if (isset($row['CUST_DOB'])){echo "<td>". $row['CUST_DOB']."</td>";}else{echo '<td>Not detected</td>';}
                                                    if (isset($row['ENTRY_DT'])){echo "<td>". $row['ENTRY_DT']."</td>";}else{echo '<td>Not detected</td>';}
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
                        <?php echo '<b><h6>Total : '.$count.'</h6></b>';?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-3">
                            <a href="admin.php" class="btn btn-primary btn-sm">Go back</a>
                    </div>
                </div>
        </div>
    </div>
<?php require 'layout/footer.php';?>
</body>
</html>