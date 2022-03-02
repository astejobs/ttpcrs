<?php 
require_once('connection.php');

  require_once('header.php');
?>

<style>
  td, th {
    padding: 0px;
  }
  .table-sm td, .table-sm th {
    padding: 0px !important;
  }
  .float-right {
    float:right;
  }
  .lbl {
    width:189px;
    height: 129px;
    font-size:6px !important;
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
                              font-size:6px !important;
                              /* border:1px solid red; */
                              background-color: #ffffff;
                            }
                            .table-sm td, .table-sm th {
                              padding: 0px !important;
                            }
                            @page { margin: 0; }
                            body { margin: 1.6cm; }
                          }
                        </style>
                      <table class="table-sm table-borderless lbl table-light" id="labelToPrint1">
                          <tr>
                            <td>
                                <?php
                                  $tdate=date_create($row['testDate']);
                                  echo date_format($tdate,"d/m/Y");
                                ?>
                            </td>
                            <td class="float-right">
                                <?php
                                  $ttime=date_create($row['testTime']);
                                  echo date_format($ttime,"h:i A");
                                ?>
                            </td>
                          </tr>
                          <tr>
                            <td><?php echo $row['patientName'] ?></td>
                            <td class="float-right"><?php echo $row['passportNumber'] ?></td>
                          </tr>
                          <tr>
                            <td> DOB: 
                                <?php
                                  $tdate=date_create($row['dob']);
                                  echo date_format($tdate,"d/m/Y");
                                ?>
                            </td>
                            <td class="float-right"><?php echo $row['nric_fin_number'] ?></td>                           
                          </tr>
                          <tr>
                            <td><?php echo $row['nationality'] ?></td>
                            <td class="float-right"><?php echo $row['testType']." &emsp;&emsp;&emsp; ".$row['specimenType']?></td>
                          </tr>
                          <tr>
                            <td colspan="2"><?php echo $row['clinicName'] ?></td>
                          </tr>
                          <tr>
                          <td colspan="2" style="text-align:center"><?php echo $row['physician_mcr'] ?></td>
                          </tr>
                          <tr>
                            <td><?php echo $row['staffCode'] ?></td>
                            <td class="float-right"><?php echo $row['testLocation'] ?></td>
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

                      saveAs(uri, '<?php echo $row["nric_fin_number"] ?>.png');
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
  newWin.document.write('<html><head><style>@media print{.table{width:189px;height: 129px;font-size:6px !important;} .lbl {width:189px;height: 129px;font-size:6px !important;}.table-sm td, .table-sm th {padding: 0px !important;}@page { margin: 0; }body { margin: 1.6cm; }}</style></head><body onload="window.print()">'+labelToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  setTimeout(function(){newWin.close();},100);
}
</script>