<?php
    require_once('header.php');
    require_once('connection.php');
    //$activePage = "Blog";
?>

<section id="main-section" class="clearfix">
	<div class="container-fluid pt-5">
	

<!-- Body Section -->
<main id="main">
  
  <div class="row">
   <div class="col-sm-12 text-center">
       <div class="blog-page-header">
           <h2 class="display-5 mt-5">Registrations</h2>  
       </div>
       <?php
        if(isset($_SESSION['msg'])) 
        { 
            echo "<div class='alert alert-success'><strong>".$_SESSION['msg']."</strong> !";
            echo "<button class='close' data-dismiss='alert'>&times;</button></div>";
            unset($_SESSION['msg']);
        }
        ?> 
   </div>
  </div>
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th class="th-sm">#</th>
                            <th class="th-sm">Patient Name</th>
                            <th class="th-sm">D.O.B</th>
                            <th class="th-sm">Gender</th>
                            <th class="th-sm">Passport</th>
                            <th class="th-sm">NRIC_FIN</th>
                            <th class="th-sm">Test Type</th>
                            <th class="th-sm">Test Date</th>
                            <th class="th-sm">Test Time</th>
                            <th class="th-sm">Action</th>
                        </tr>
                    </thead>
                    <tbody>  
                
                                <?php
                                   $sql = "SELECT * FROM registrations ORDER BY testDate desc LIMIT 20";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                    // output data of each row
                                        $idx = 1;
                                        while($row = $result->fetch_assoc()) { 
                                ?> 
                                    <tr>
                                        <td><?php echo $idx ?></td>
                                        <td><?php echo $row["patientName"] ?></td>
                                        <td><?php echo $row["dob"] ?></td>
                                        <td><?php echo $row["gender"] ?></td>
                                        <td><?php echo $row["passportNumber"] ?></td>
                                        <td><?php echo $row["nric_fin_number"] ?></td>
                                        <td><?php echo $row["testType"] ?></td>
                                        <td><?php echo $row["testDate"] ?></td>
                                        <td><?php echo $row["testTime"] ?></td>
                                        <td>
                                                <a href="print-label.php?id=<?php echo $row["id"]; ?>" data-toggle="tooltip" title="Print Label"><i class="fa fa-clipboard" style="color:#1bb1dc"></i></a>
                                                <a href="edit-blog.php?id=<?php echo $row["id"]; ?>" data-toggle="tooltip" title="Edit News"><i class="fa fa-pencil-square" style="color:#1bb1dc"></i></a>
                                                <a style="cursor:pointer" class="remove"  id="<?php echo $row['id']; ?>" data-toggle="tooltip" title="Delete"><i class="fa fa-trash" style="color:#1bb1dc"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                        $idx++;
                                        }
                                    } else {
                                    //echo "0 results";  onClick="copyToClipboard('<?php echo $id >')"
                                    }
                                    $conn->close();
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