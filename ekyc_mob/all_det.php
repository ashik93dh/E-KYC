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
                    <option value="2">Smart ID</option>
                    <option value="4">Entry By</option>
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-10">
            <h5>All Entries</h5>
                    <div class="table-wrapper-scroll-y my-custom-scrollbar table-responsive" style="height: 400px;">
                        <table  class="table table-striped table-bordered table-sm table-hover" id="myTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Name</td>
                                            <th scope="col">NID</td>
                                            <th scope="col">Smart ID</td>
                                            <th scope="col">Date of Birth</td>
                                            <th scope="col">Entry By</td>
                                            <th scope="col">Entry Time</td>
                                        </tr>
                                    </thead>
                                    <?php
                                        
                                        $conn=oci_connect('online_user','Admin123','dbhons1');
                                        if($conn){
                                            $count=0;
                                            $sql = "SELECT EKYC_ID,CUST_NM,CUST_NID,CUST_SM_ID,CUST_DOB,EKYC_BY,TO_CHAR(EKYC_DT, 'dd/mm/yyyy hh:mi:ss am') AS EKYC_DT FROM online_user.ekys_cust_mast  order by TO_DATE(EKYC_DT, 'dd/mm/yyyy hh:mi:ss am') desc";
                                            $stid = oci_parse($conn, $sql);
                                            
                                            oci_execute($stid);
                                            while ($row=oci_fetch_array($stid, OCI_BOTH)) {
                                                echo "<tr>";
                                                if (isset($row['CUST_NM'])){echo "<td><a href=entry_details.php?ekyc_id=".$row['EKYC_ID'].">".$row['CUST_NM']."</td>";}else{echo '<td>Not detected</td>';}
                                                if (isset($row['CUST_NID'])){echo "<td>".$row['CUST_NID']."</td>";}else{echo '<td>Not detected</td>';}
                                                if (isset($row['CUST_SM_ID'])){echo "<td>".$row['CUST_SM_ID']."</td>";}else{echo '<td>Not detected</td>';}
                                                if (isset($row['CUST_DOB'])){echo "<td>". $row['CUST_DOB']."</td>";}else{echo '<td>Not detected</td>';}
                                                if (isset($row['EKYC_BY'])){echo "<td>". $row['EKYC_BY']."</td>";}else{echo '<td>Not detected</td>';}
                                                if (isset($row['EKYC_DT'])){echo "<td>". $row['EKYC_DT']."</td>";}else{echo '<td>Not detected</td>';}
                                                echo "</tr>";
                                                $count++;
                                            }
                                                
                                                
                                                
                                                
                                        }
                                    ?>
                        </table>
                </div>
            </div>
            <div class="col-sm-2">
            <h6><b>All Entries By Name</b></h6>
            <div class="table-wrapper-scroll-y my-custom-scrollbar table-responsive" style="height: 400px;">
                <table class="table table-striped table-bordered table-sm table-hover" >
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
                            $sql3 = 'SELECT count(*) as entries,ekyc_by from ONLINE_USER.EKYS_CUST_MAST WHERE ekyc_by is not null  group by ekyc_by order by entries desc';
                            $stid3 = oci_parse($conn, $sql3);
                            oci_execute($stid3);
                            while ($row=oci_fetch_array($stid3, OCI_BOTH)) {
                                echo "<tr>";
                                if (isset($row['EKYC_BY'])){echo "<td>".$row['EKYC_BY']."</td>";}else{echo '<td>APP</td>';}
                                if (isset($row['ENTRIES'])){echo "<td><a href=emp_det.php?ekyc_by=".$row['EKYC_BY'].">".$row['ENTRIES']."</a></td>";}else{echo '<td>Not detected</td>';}
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