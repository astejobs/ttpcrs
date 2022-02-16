<?php 
require_once('connection.php');
//Update Existing News Blog 
if(isset($_GET['edit'])){

  if(isset($_POST['id'])){ 
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $author_name = mysqli_real_escape_string($conn, $_POST['authorName']);
    $date_posted = mysqli_real_escape_string($conn, $_POST['datePosted']);
  
    $tagTitles = $_POST['tagTitle'];
    $tagLinks = $_POST['tagLink'];
    
      $sql = "UPDATE blog SET author_name='".$author_name."', date_posted='".$date_posted."', title='".$title."', content='".$content."' WHERE id='".$id."'";
      
      if ($conn->query($sql) === TRUE) {            
            echo "Blog Added Successfully";
            $_SESSION['msg']="News blog has been updated  successfully"; 
            header('Location:./blog-home.php');
            //wp_redirect("blog-home.php"); 
            exit;
      } else {
        $_SESSION['msg']="Error: News blog was not updated, please try again"; 
        header('Location:./blog-home.php');
        //wp_redirect("blog-home.php");
        exit;
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
       
      $conn->close();
   
     
  }
  
} else {  //Add New Registration 

  if(isset($_POST['submit'])){
  
    $patientName = mysqli_real_escape_string($conn, $_POST['patientName']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dobDate = mysqli_real_escape_string($conn, $_POST['dobDate']);
    $dobDate = date($dobDate);
  /*   $dobDay = mysqli_real_escape_string($conn, $_POST['dobDay']);
    $dobMonth= mysqli_real_escape_string($conn, $_POST['dobMonth']);
    $dobYear = mysqli_real_escape_string($conn, $_POST['dobYear']); */
    $passportNumber = mysqli_real_escape_string($conn, $_POST['passportNumber']);
    $nric_fin_number = mysqli_real_escape_string($conn, $_POST['nric_fin_number']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
    $contactNumber = mysqli_real_escape_string($conn, $_POST['contactNumber']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $testType = mysqli_real_escape_string($conn, $_POST['testType']);
    $specimenType = mysqli_real_escape_string($conn, $_POST['specimenType']);
    $clinicName = mysqli_real_escape_string($conn, $_POST['clinicName']);
    $performing_mcr = mysqli_real_escape_string($conn, $_POST['performing_mcr']);
    $testDate = mysqli_real_escape_string($conn, $_POST['testDate']);
    $testTime = mysqli_real_escape_string($conn, $_POST['testTime']);
    /* $testDay = mysqli_real_escape_string($conn, $_POST['testDay']);
    $testMonth = mysqli_real_escape_string($conn, $_POST['testMonth']);
    $testYear = mysqli_real_escape_string($conn, $_POST['testYear']);
    $testHours = mysqli_real_escape_string($conn, $_POST['testHours']);
    $testMinutes = mysqli_real_escape_string($conn, $_POST['testMinutes']);
    $testShift = mysqli_real_escape_string($conn, $_POST['testShift']); */
    $paymentMode = mysqli_real_escape_string($conn, $_POST['paymentMode']);
    $paymentRefNo = mysqli_real_escape_string($conn, $_POST['paymentRefNo']);
    $staffCode = mysqli_real_escape_string($conn, $_POST['staffCode']);
    $testLocation = mysqli_real_escape_string($conn, $_POST['testLocation']);
    $ariSymptomps = mysqli_real_escape_string($conn, $_POST['ariSymptomps']);
    $contraindication = mysqli_real_escape_string($conn, $_POST['contraindication']);

    print_r($_POST);

    $sql = "INSERT INTO registrations (patientName, dob, gender,passportNumber,nric_fin_number,nationality,
            contactNumber,email,testType,specimenType,clinicName,physician_mcr,testDate,testTime,paymentMode,
            paymentRefNo,staffCode,testLocation,ari_symptoms,contraindication)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssssssssssssssssssss", $patientName,$dobDate,$gender,$passportNumber,$nric_fin_number,$nationality,
                      $contactNumber,$email,$testType,$specimenType,$clinicName,$performing_mcr,$testDate,
                    $testTime,$paymentMode,$paymentRefNo,$staffCode,$testLocation,$ariSymptomps,$contraindication);
    $stmt->execute();

    $stmt->close();
    ?>
<?php
  require_once('header.php');
?>
<style>
  .float-right {
    float:right;
  }

  @media print{
    .lbl {
      width:189px;
      height: 129px;
    }
  }
  </style>
    <div class="container" style="margin-top:50px">
      <div class="row mt-5" style="margin-top:50px">
        <div class="col">
          <div class="table-responsive" style="margin-top:50px">
            <table class="table-sm table-borderless lbl" style="font-size:9px;border:1px solid red;">
              <tr>
                <td><?php echo $testDate ?></td>
                <td class="float-right"><?php echo $testTime ?></td>
              </tr>
              <tr>
                <td><?php echo $patientName ?></td>
                <td class="float-right"><?php echo $nric_fin_number ?></td>
              </tr>
              <tr>
                <td>DOB: <?php echo $dobDate ?></td>
                <td class="float-right"><?php echo $passportNumber ?></td>
              </tr>
              <tr>
                <td><?php echo $nationality ?></td>
                <td class="float-right"><?php echo $testType."  ".$specimenType ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo $clinicName ?></td>
              </tr>
              <tr>
              <td colspan="2" style="text-align:center"><?php echo $performing_mcr ?></td>
              </tr>
              <tr>
                <td><?php echo $staffCode ?></td>
                <td class="float-right"><?php echo $testLocation ?></td>
              </tr>
              <tr>
                <td style="text-align:center" colspan="2"><img alt="testing" src="barcode.php?text=<?php echo $nric_fin_number ?>&print=true" /></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>





<?php
  require_once('footer.php');

    //echo'<br><br><br><img alt="testing" src="barcode.php?text='.$nric_fin_number.'&print=true" />';
 
    
      //$sql = "INSERT INTO blog (author_name,date_posted,title,content) VALUES ('$author_name','$date_posted','$title','$content')";
      
      /* if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
         if($last_id != '') { 
            foreach($tagTitles as $key => $title)
              {
                if($title != '' && $tagLinks[$key] != '')
                {
                  $title_tag = mysqli_real_escape_string($conn, $title);
                  $link_tag = mysqli_real_escape_string($conn, $tagLinks[$key]);
                 
                  $sqlTags = "INSERT INTO blog_post_tags (blog_id,link,title) VALUES ('$last_id','$link_tag','$title_tag')";
                  if ($conn->query($sqlTags) === TRUE) { 
                    echo "Tag added";
                  } else {
                    $_SESSION['msg']="Error: News blog Tags were not added, Please try again"; 
                    echo "Error in Tags: " . $sql . "<br>" . $conn->error;
                    header('Location:./blog-home.php');
                    //wp_redirect("blog-home.php");
                    exit;
                  }
                } 
             }
            echo "Blog Added Successfully";
            $_SESSION['msg']="News blog was added  successfully";
            header('Location:./blog-home.php');
            //wp_redirect("blog-home.php");
            exit;
          }      
  
       } else {
        $_SESSION['msg']="Error: News blog was not added, please try again";
        echo "Error: " . $sql . "<br>" . $conn->error;
        header('Location:./blog-home.php');
        //wp_redirect("blog-home.php");
        exit;
      } */
       
      $conn->close();
     
    }
}

    /* function insertTags($conn, $blog_id, $tagTitles, $tagLinks) {
      foreach($tagTitles as $key => $title)
      {
          if($title != '' && $tagLinks[$key] != '')
          {
            $insData = array("blog_id"=>$blog_id, "link"=>mysqli_real_escape_string($conn, $tagLinks[$key]), "title"=>mysqli_real_escape_string($conn, $title));
            $columns = implode(", ",array_keys($insData));
            $values  = implode(", ", $insData);
            //echo "cols \n";
            //print_r($columns);
            //echo "values \n";
            //print_r($values);

            $sqlTags = "INSERT INTO `blog_post_tags` ($columns) VALUES ($values)";
            if ($conn->query($sqlTags) === TRUE) {              
              return true;
              
            } else {
              return false;
            }
          } 
      }
    } */
?>