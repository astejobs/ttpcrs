<?php 
require_once('connection.php');

  require_once('header.php');
  if(!isset($_SESSION['ID'])) {
    header('location:login.php');
  }
?>

<style>
  td, th {
    padding: 0px;
    width: max-content;
    margin: 0px;
    /* letter-spacing: 1px; */
  }
  .rt-align {
    text-align: right;
  }
  .table-sm td, .table-sm th {
    padding: 0px !important;
    padding-right: 2px !important; 
    padding-left: 2px !important; 
    /* font-weight: 500; */
  }
  .float-right {
    float:right;
  }
  .lbl {
    width:189px;
    height: 129px;
    font-size:9px !important;
    font-weight: 600;   
    /* border:1px solid red;   */  
  }
</style>

<section class="h-100">
<?php
//Update Existing News Blog 
if(isset($_GET['id'])) {

    $id = $_GET['id'];
   
    
      $sql = "SELECT * FROM registrations WHERE id='".$id."'";
      
      $result = $conn->query($sql);
      if (mysqli_num_rows($result)) {            
            //echo "Record Retrieved Successfully";
            $row = $result->fetch_assoc();
            //print_r($row); 

            //LABEL HTML
            ?>
                <div class="container h-100" style="margin-top:150px;">
                  <div class="row">
                  <div class="col-sm-12">
                      <?php
                          if(isset($_SESSION['msg'])) 
                          { 
                              echo "<div class='alert alert-success'><strong>".$_SESSION['msg']."</strong> !";
                              echo "<button class='close' data-dismiss='alert'>&times;</button></div>";
                              unset($_SESSION['msg']);
                          }
                      ?>
                  </div>
                    
                    <div class="col-sm-6">
                      <div class="" id="labelToPrint">
                      <style>
                          .float-right {
                            float:right;
                          }

                          @media print{                            
                            .lbl {
                              width:189px;
                              height: 129px;
                              font-size:9px !important;
                              /* border:1px solid red; */
                              background-color: #ffffff;
                            }
                            .table-sm td, .table-sm th {
                              padding: 0px !important;
                            }
                            @page { margin: 0; }
                            body { margin: 10px; }
                          }
                        </style>
                      <table class="table-sm table-borderless lbl table-light" id="labelToPrint1" style="font-weight:600">
                          <tr>
                            <td>
                                <?php
                                  $tdate=date_create($row['testDate']);
                                  echo date_format($tdate,"d/m/Y");
                                ?>
                            </td>
                            <td class="rt-align">
                                <?php
                                  $ttime=date_create($row['testTime']);
                                  echo date_format($ttime,"h:i A");
                                ?>
                            </td>
                          </tr>
                          <tr>
                            <td><?php echo $row['patientName'] ?></td>
                            <td class="rt-align"><?php echo $row['gender'] ?></td>
                          </tr>
                          <tr>
                          <tr>
                            <td><strong>Passport: </strong> <?php echo $row['passportNumber'] ?></td>
                            <td class="rt-align">                                
                                <!-- <strong>NRIC/FIN: </strong> -->
                                <?php echo $row['nric_fin_number'] ?>                                
                            </td>
                          </tr>
                          <tr>
                            <td> <strong>DOB: </strong>
                                <?php
                                  $tdate=date_create($row['dob']);
                                  echo date_format($tdate,"d/m/Y");
                                ?>
                            </td>
                            <td class="rt-align"><?php echo $row['nationality'] ?></td>                           
                          </tr>
                          <tr>
                            <td style="font-size:8px;"><?php echo $row['testType']." &nbsp&nbsp&nbsp&nbsp ".$row['specimenType'] ?></td>
                            <td class="rt-align" style="font-size:8px;"><?php echo $row['serviceType']?></td>
                          </tr>
                          <!-- <tr>
                            <td colspan="2"> echo //$row['clinicName']; ?></td>
                          </tr>
                          <tr>
                          <td colspan="2" style="text-align:center"> echo //$row['physician_mcr'] ?></td>
                          </tr> -->
                          <tr>
                            <td><?php echo $row['staffCode'] ?></td>
                            <td class="rt-align"><?php echo $row['testLocation'] ?></td>
                          </tr>
                          <tr>
       <!--                      <td style="text-align:center" colspan="2">
                                <?php
                                  //if( !empty($row['nric_fin_number']) ) {                                    
                                    ?><img alt="testing" src="barcode.php?text=<?php //echo $row['nric_fin_number'] ?>&size=13&print=true" /> <?php
                                  //} else {
                                    ?><img alt="testing" src="barcode.php?text=<?php //echo $row['passportNumber'] ?>&size=13&print=true" /> <?php
                                  //}
                                ?>
                            </td> -->
                          </tr>
                        </table>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <button class="btn btn-sm btn-info" id="print_btn">Download As Image</button>
                        <button class="btn btn-sm btn-info" id="print_btn2">Print</button>
                      </div>
                    </div>

                  </div>
                  <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group float-right">
                        <a href="index.php" class="btn btn-sm btn-info">Done</a>
                      </div>
                    </div>
                    <div id="result">
                      <!-- Result will appear be here -->
                    </div>
                  </div>
                  
                </div>
            <?php
      } else {
        //$_SESSION['msg']="Error: News blog was not updated, please try again"; 
        //wp_redirect("blog-home.php");
        exit;
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
       
      $conn->close();
   

  require_once('footer.php');
}

?>
</section>
<script type="text/javascript" src="assets/js/html2canvas.js"></script>
<script>
  $(document).ready(function() {
    $('#print_btn').click(function() {
        console.log("Printinggggg");
        //printDiv();
        var resultDiv = document.getElementById("result");
              html2canvas(document.getElementById("labelToPrint1"), {
                  onrendered: function(canvas) {
                      //var img = canvas.toDataURL("image/png");
                      //result.innerHTML = '<a id="download_btn" style="visibility:visible" download="test.png" href="'+img+'">test</a>';
                      var saveAs = function(uri, filename) {
                      var link = document.createElement('a');
                      if (typeof link.download === 'string') {
                          document.body.appendChild(link); // Firefox requires the link to be in the body
                          link.download = filename;
                          link.href = uri;
                          link.click();
                          document.body.removeChild(link); // remove the link when done
                      } else {
                          location.replace(uri);
                      }
                    };

                      var img = canvas.toDataURL("image/png",0.99),
                          uri = img.replace(/^data:image\/[^;]/, 'data:application/octet-stream');

                      saveAs(uri, '<?php echo $row["passportNumber"] ?>.png');
                  }
          });
          
        
    });
    
    $('#print_btn2').click(function() {
      printDiv();
    });
  });

function printDiv() 
{
  var labelToPrint=document.getElementById('labelToPrint');
  var newWin=window.open('','Print-Window');
  newWin.document.open();
  newWin.document.write('<html><head><style>@media print{.table{width:189px;height: 129px;font-size:9px !important;padding: 0px !important;} .lbl {width:189px;height: 129px;font-size:9px !important;}.table-sm td, .table-sm th {padding: 0px !important;font-weight:700}@page { margin: 0; size: 189px 129px; }body { margin: 10px; }}</style></head><body onload="window.print()">'+labelToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  setTimeout(function(){newWin.close();},100);
}
</script>