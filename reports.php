<?php
   ini_set('display_errors',1);
   error_reporting(E_ALL);

   /*** THIS! ***/
   mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
   /*** ^^^^^ ***/

   require_once('header.php');
   require_once('connection.php');

   if(isset($_POST["export"]))
    {
        exit();
    } else {
            $site = "";
            if(isset($_POST['testLocation'])) {
                $site = $_POST['testLocation'];
            }
            if($site == "Please Select") {
                $site = ""; 
            }

            $from_date  = date('Y-m-d');
            if(isset($_POST['fromDate']) && !empty($_POST['fromDate'])) {            
                $from_date  = $_POST['fromDate'];
            }
            $to_date  = date('Y-m-d');
            if(isset($_POST['toDate']) && !empty($_POST['toDate'])) {
                $to_date  = $_POST['toDate'];
            }

            $q = "SELECT * FROM `registrations` WHERE `id`>'0' ";
            if($site && !empty($site)){
                $q .= " AND `testLocation` LIKE '%".$site."%' AND `testDate` BETWEEN '" . $from_date . "' AND  '" . $to_date . "' ";
            } else {
                $q .= " AND `testDate` BETWEEN '" . $from_date . "' AND  '" . $to_date . "' ";
            } 
            $result = mysqli_query($conn, $q);  
            //$resultCount = mysqli_query($conn, $getCountQuery);
       //}
   //}else {
   //}
   }

?>

<link href='assets/js/DataTables/datatables.min.css' rel='stylesheet' type='text/css'>
 
<section id="main-section" class="clearfix">
	<div class="container-fluid pt-5 mt-3">
	

<!-- Body Section -->
<main id="main">
  
  <div class="row">
   <div class="col-sm-12">
       <div class="container-fluid mt-5"> 
       <p class=" p-2 font-weight-bold text-center">Past Attendance Reports </p>
           <?php if(isset($_SESSION['ID'])) { ?>
               <form action="reports.php" method="POST">
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <div class="form-group">  
                                <label >Select Location</label>
                                <select class="form-control" name="testLocation">
                                    <option>Please Select </option>
                                    <option value="JEC"<?=$site == 'JEC' ? ' selected="selected"' : '';?>>JEC</option>
                                   
                                    <option value="GM"<?=$site == 'GM' ? ' selected="selected"' : '';?>>GM</option>
                                    <option value="ROXY"<?=$site == 'ROXY' ? ' selected="selected"' : '';?>>ROXY</option>
                                    <option value="CQC"<?=$site == 'CQC' ? ' selected="selected"' : '';?>>CQC</option>
                                    <option value="IBIS"<?=$site == 'IBIS' ? ' selected="selected"' : '';?>>IBIS</option>
                                    <option value="MTS"<?=$site == 'MTS' ? ' selected="selected"' : '';?>>MTS</option>
                                    <option value="SPEC"<?=$site == 'SPEC' ? ' selected="selected"' : '';?>>SPEC</option>

                                </select>  
                            </div>                        
                        </div>                    
                        <div class="col-sm-6">
                            <label for="">Start Date</label>                      
                            <div class="input-group mb-3">
                                <input type="text" name="fromDate" id="from_date" placeholder="from date" class="form-control">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary fpcl1" type="button"><i class="fa fa-times"></i></button>
                                </div>
                            </div>                       
                        </div>                    
                        <div class="col-sm-6">
                            <label for="">End Date</label>
                            <div class="input-group mb-3">
                                <input type="text" name="toDate" id="to_date" placeholder="to date" class="form-control">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary fpcl2" type="button"><i class="fa fa-times"></i></button>
                                </div>                             
                            </div>                        
                        </div>                    
                        <div class="col-sm-6 form-group">
                            <label>                                
                                <small>
                                    <em>
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        click search to view and export to save as excel
                                    </em>
                                </small>
                            </label>
                            <br> 
                            <button type="submit" class="btn btn-success px-5"><i class="fa fa-search mr-2"></i>Search</button>
                            <button type="submit" formaction="generate-excel.php" formmethod="POST" id="export" class="btn btn-dark px-5 float-right" name="export"><i class="fa fa-download mr-2"></i>Export as excel</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group mt-3">
                        </div> 
                    </div>
                </form>
                <?php } ?>
       </div>
       <?php
        if(isset($_SESSION['msg'])) 
        { 
            echo "<div class='alert alert-success'><strong>".$_SESSION['msg']."</strong> !";
            echo "<button class='close' data-dismiss='alert'>&times;</button></div>";
            unset($_SESSION['msg']);
        }
        ?> 
        <div class='alert d-none del-msg'><strong><span><span></strong>
            <button class='close' data-dismiss='alert'>&times;</button>
        </div>
   </div>
  </div>
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th class="th-sm">#</th>
                            <th class="th-sm">Date</th>
                            <th class="th-sm">Time</th>
                            <th class="th-sm">Test Location</th>
                            <th class="th-sm">Name</th>
                            <th class="th-sm">Passport</th>
                            <th class="th-sm">NRIC/FIN</th>
                            <th class="th-sm">Nationality</th>
                            <th class="th-sm">Contact Number</th>
                            <th class="th-sm">Email</th>
                            <th class="th-sm">Service Type</th>
                            <th class="th-sm">Test Code/Type</th>
                            <th class="th-sm">Specimen Type</th>
                            <th class="th-sm">Mode of Payment</th>
                            <th class="th-sm">Payment Ref</th>
                            <th class="th-sm">Staff Code</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php                                   

                        if (!$result) { 
                            echo "Sorry unable to search this time!"; 
                        } 
                        else if (!($result->num_rows > 0)) {
                            echo "NO RECORDS fOUND!"; 
                        } else {
                            // output data of each row
                            $idx = 1; 
                            while($row = mysqli_fetch_array($result)) { 
                        ?> 
                        <tr>
                            <td><?php echo $idx ?></td>
                            <td>
                                <?php
                                    $tdate=date_create($row['testDate']);
                                    echo date_format($tdate,"d/m/Y");
                                ?>
                            </td>
                            <td>
                                <?php
                                    $tdate=date_create($row['testTime']);
                                    echo date_format($tdate,"h:i A");
                                ?>
                            </td>
                            <td>
                                <?php echo $row["testLocation"]; ?>
                            </td>
                            <td><?php echo $row["patientName"] ?></td>
                            <td><?php echo $row["passportNumber"] ?></td>
                            <td><?php echo $row["nric_fin_number"] ?></td>                            
                            <td><?php echo $row["nationality"] ?></td>
                            <td><?php echo $row["contactNumber"] ?></td>
                            <td><?php echo $row["email"] ?></td>
                            <td><?php echo $row["serviceType"] ?></td>
                            <td><?php echo $row["testType"] ?></td>
                            <td><?php echo $row["specimenType"] ?></td>
                            <td><?php echo $row["paymentMode"] ?></td>
                            <td><?php echo $row["paymentRefNo"] ?></td>
                            <td><?php echo $row["staffCode"] ?></td>
                        </tr>
                        <?php
                            $idx++;
                            }
                        } 
                        /* else {

                        }  */

                        ?>
                    </tbody>
                   
            </table>  

        </div>                              
        
    </div>
   </main>
   
   <!-- End #main -->
<!-- End Body Section -->


</div>
</section> 


</main><!-- End #main -->

<?php
require_once('footer.php');
?>
<script src="assets/js/DataTables/datatables.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script>
    $(document).ready(function() {
        
        $('#myTable').DataTable({
            "lengthMenu": [ 5, 10, 25, 50 ],
            responsive: true,
            searchPlaceholder: "Search records",
            search: "",
            columnDefs: [
                { orderable: false, targets: 2 },
                { orderable: false, targets: 7 },
                { orderable: false, targets: 8 },
                { orderable: false, targets: 9 }
                ],
            order: [[0, 'asc']]
        });
        //$('#myTable_filter').remove();
        $('#myTable_filter').css("display","none");

        from_config = {
          maxDate: "today",
          dateFormat: "Y-m-d",
          altFormat: "d/m/Y",
          altInput: true,
          defaultDate: "<?php echo $from_date ?>",
          onChange: function(selectedDates, dateStr, instance) {
            toPicker.set('minDate', selectedDates[0]);
          }
      }
        to_config = {
          maxDate: "today",
          dateFormat: "Y-m-d",
          altFormat: "d/m/Y",
          altInput: true,
          defaultDate: "<?php echo $to_date ?>",
      }
      fromPicker = $("#from_date").flatpickr(from_config);
      toPicker = $("#to_date").flatpickr(to_config);
      $(".fpcl1").click(function() { console.log("clicked");
        fromPicker.clear();
      });
      $(".fpcl2").click(function() { console.log("clicked");
        toPicker.clear();
      });

      $('#export1').click(function() {
        console.log('form submitting');
        console.log($('form').serialize())
        $.ajax({
            type: 'POST',
            xhrFields: {
                responseType: 'blob'
            },
            url: 'generate-excel.php',
            data: $('form').serialize(),
            success: function (data) {
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(data);
                a.href = url;
                a.download = 'myfile.xlsx';
                document.body.append(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
                
                console.log(data);
                console.log('form was submitted');
            }
          });
      });

    });

</script>