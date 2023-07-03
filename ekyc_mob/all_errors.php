<?php require 'layout/head.php';?>
<?php session_start();?>
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
        <div class="row">
            <div class="col-sm-3">
                <input type="text" placeholder="Search" class="form-control" onkeyup="filterData()" id="myInput">
            </div>
            <div class="col-sm-2">
                <select class="form-select" aria-label="Default select example" id="searchby">
                    <option  selected value="0">Name</option>
                    <option value="1">NID</option>
                    <option value="3">Entry By</option>
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-10">
            <h5>All Errors</h5>
                    <div class="table-wrapper-scroll-y my-custom-scrollbar table-responsive" style="height: 400px;">
                        <table  class="table table-striped table-bordered table-sm table-hover" id="myTable">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Error ID</td>
                                    <th scope="col">Name</td>
                                    <th scope="col">NID</td>
                                    <th scope="col">Date of Birth</td>
                                    <th scope="col">Entry By</td>
                                    <th scope="col">Entry Time</td>
                                    <th scope="col">Locked</td>
                                </tr>
                            </thead>
                            <?php 
                                $conn=oci_connect('online_user','Admin123','dbhons1');
                                if($conn){
                                    $count=0;
                                    $sql = "SELECT ERROR_ID,CUST_NM,CUST_NID,CUST_DOB,ENTRY_BY,IMG_LOC,TO_CHAR(ENTRY_DT, 'dd/mm/yyyy hh:mi:ss am') AS ENTRY_DT , LOCKED FROM online_user.ekyc_fail_log  order by TO_DATE(ENTRY_DT, 'dd/mm/yyyy hh:mi:ss am') desc";
                                    $stid = oci_parse($conn, $sql);
                                    oci_execute($stid);
                                    while ($row=oci_fetch_array($stid, OCI_BOTH)) {
                                        echo "<tr>";
                                        if (isset($row['ERROR_ID'])){echo "<td><a href=error_details.php?error_id=".$row['ERROR_ID'].">".$row['ERROR_ID']."</td>";}
                                        if (isset($row['CUST_NM'])){echo "<td>".$row['CUST_NM']."</td>";}else{echo '<td>Not detected</td>';}
                                        if (isset($row['CUST_NID'])){echo "<td>".$row['CUST_NID']."</td>";}else{echo '<td>Not detected</td>';}
                                        if (isset($row['CUST_DOB'])){echo "<td>". $row['CUST_DOB']."</td>";}else{echo '<td>Not detected</td>';}
                                        if (isset($row['ENTRY_BY'])){echo "<td>". $row['ENTRY_BY']."</td>";}else{echo '<td>Not detected</td>';}
                                        if (isset($row['ENTRY_DT'])){echo "<td>". $row['ENTRY_DT']."</td>";}else{echo '<td>Not detected</td>';}
                                        if (isset($row['LOCKED'])){echo "<td>". $row['LOCKED']."</td>";}else{echo '<td>Not detected</td>';}
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
            <div class="col-sm-3"><?php echo "<h6 id='tot-row'>Total : $count</h6>";?></div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                    <a href="admin.php" class="btn btn-primary btn-sm">Go back</a>
            </div>
        </div>                                   
    </div>

<?php require 'layout/footer.php';?>
<script>

</script>    
</body>
</html>