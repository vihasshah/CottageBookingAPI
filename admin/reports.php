<?php
    include '../core/Cottage.php';
        $Name="all";
        $fromdate=date("Y-m-d",strtotime(' -1 month'));
        $todate=date("Y-m-d",strtotime(' +1 month'));
        $sql = "SELECT cottages.name,users.firstname,users.lastname,booking_status.FromDate,booking_status.ToDate FROM cottages,users,booking_status WHERE ";
    if(!empty($_POST)){
        $Name=$_POST['name'];
        $fromdate=$_POST['fromd'];
        $todate=$_POST['tod'];
        if($Name!="All"){
            $sql = $sql."  cottages.id=$Name AND "; 
        }
        else {
        }
        $sql=$sql." booking_status.FromDate BETWEEN '$fromdate' AND '$todate'  AND ";  
    }
    $conn = new mysqli("localhost","root","","CottageBooking");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    $sql = $sql." booking_status.CottageId=cottages.id AND booking_status.UserId=users.id ";
    $result = $conn->query($sql);
?>

<html>
<head>
    <!-- color palette -->
    <link rel="stylesheet" href="palette.css">
    <!-- materialize -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
     <script type="text/javascript" src="../assets/js/tableexport/tableexport.js"></script>
    <!-- icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- jquery -->
    
    
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- custom js -->
    <script src="common.js"></script>
    <script type="text/javascript">
            function myFunction() {
                 $('#customers').tableExport({type:'excel',escape:'false'});
            }
    </script>
    <!-- custom css -->
    <link rel="stylesheet" href="common.css">
</head>
<body>
    <!-- navbar -->
    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper default-primary-color">
                <a href="#!" class="brand-logo ">Cottage Booking</a>
                <ul class="right hide-on-med-and-down">
                    <li><a <?php if(basename($_SERVER['PHP_SELF'])=="index.php") echo "style='background: lightseagreen;'"; ?> href="index.php"><i class="material-icons left">store</i>Cottages</a></li>
                     <li><a <?php if(basename($_SERVER['PHP_SELF'])=="reports.php") echo "style='background: lightseagreen;'"; ?>  href="reports.php"><i class="material-icons left">insert_chart</i>Reports</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- main body  -->
    <br><br>
    <div class="row">
        <div class="col s10 offset-s1">
            <!-- <h4 class="primary-text-color">Cottages List</h4>
            <div id="cottageList" class="col s12"></div> -->
            <!-- <script>renderCottageList()</script> -->
                <!-- START DATATABLE EXPORT -->
                <div class="panel panel-default">
                    <div>
                        <form method="post" >
                             <div class="form-group" >
                                <label class="">Cottage</label>
                                <?php 
                                    $sql1 = "SELECT * FROM cottages";
                                    $result1 = $conn->query($sql1);
                                ?>
                                <div class="">                                        
                                    <select class="form-control" name="name">
                                        <option>All</option>
                                        <?php 
                                        if ($result1->num_rows > 0) {
                                            // output data of each row
                                            while($row1 = $result1->fetch_assoc()) {
                                                ?> 
                                                    <option <?php if($row1['id']==$Name){ echo "selected"; } ?> value="<?=$row1['id']?>" >   <?=$row1["name"]?></option>
                                                <?php
                                            }
                                        } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-md-3 control-label">From </label>
                                <div class="col-md-5">
                                    <input type="date" class="form-control datepicker" name="fromd" id="fromd" onchange="c();"   value="<?php  if(isset($_POST['fromd'])){ echo $_POST['fromd']; }else{   echo date('Y-m-d',strtotime(' -1 month')); } ?>" >
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-md-3 control-label">To </label>
                                <div class="col-md-5">
                                    <input type="date" class="form-control datepicker" id="tod" name="tod"  min="<?php echo date("Y-m-d"); ?>"  value="<?php if(isset($_POST['tod'])){ echo $_POST['tod']; }else{  echo date("Y-m-d",strtotime(' +1 month'));}  ?>">
                                </div>
                            </div>
                             <div >
                                <button class="btn" style=""><i class="fa fa-bars"></i>Filter</button> &nbsp;&nbsp;&nbsp;
                               <!--  <button class="btn" type="button" name="download" onclick="myFunction()"  style="background-color: deepskyblue"><i class="fa fa-bars"></i>Generate Report as Excel</button> -->
                            </div>
                        </form>                                     
                    </div>
                    
                   
                    <div class="panel-body" id="reports">
                        <?php if(isset($_POST['download'])){
                            header("Content-Type:   application/xls");
                            header('Content-Disposition: attachment; filename=abc.xls'); 
                        }?>
                        <table id="customers" class="table datatable">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Cottage Name</th>
                                    <th>Booking Date</th>
                                    <th>Days</th>
                                </tr>
                            </thead>
                            <tbody>      
                                <?php
                                if ($result->num_rows > 0) {
                                    // output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        //echo "id: " . $row["name"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
                                        $Day=strtotime($row["ToDate"])-strtotime($row["FromDate"]);
                                        $Day= round($Day / (60 * 60 * 24));
                                ?>
                                    <tr>
                                        <td><?=$row["firstname"]." ".$row["firstname"]?></td>
                                        <td><?=$row["name"]?></td>
                                        <td><?=$row["FromDate"]?></td>
                                        <td><?=$Day?></td>
                                        
                                    </tr>
                                <?php
                                   }
                                        } else {
                                            echo "No results";
                                        }
                                ?>
                                  </tbody>
                        </table>                                    
                        
                    </div>
                </div>
                <!-- END DATATABLE EXPORT -->                                       
        </div>
       
    </div>
    <!-- floating btn -->
   
</body>
<script type="text/javascript">
  function c(){
    document.getElementById('tod').value = document.getElementById('fromd').value ;
     document.getElementById('tod').setAttribute("min", document.getElementById('fromd').value );
  }  
  
</script>


   
</html>

