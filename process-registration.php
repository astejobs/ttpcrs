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
    $paymentMode = mysqli_real_escape_string($conn, $_POST['paymentMode']);
    $paymentRefNo = mysqli_real_escape_string($conn, $_POST['paymentRefNo']);
    $staffCode = mysqli_real_escape_string($conn, $_POST['staffCode']);
    $testLocation = mysqli_real_escape_string($conn, $_POST['testLocation']);
    $ariSymptomps = mysqli_real_escape_string($conn, $_POST['ariSymptomps']);
    $contraindication = mysqli_real_escape_string($conn, $_POST['contraindication']);

    $sql = "INSERT INTO registrations (patientName, dob, gender,passportNumber,nric_fin_number,nationality,
            contactNumber,email,testType,specimenType,clinicName,physician_mcr,testDate,testTime,paymentMode,
            paymentRefNo,staffCode,testLocation,ari_symptoms,contraindication)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssssssssssssssssssss", $patientName,$dobDate,$gender,$passportNumber,$nric_fin_number,$nationality,
                      $contactNumber,$email,$testType,$specimenType,$clinicName,$performing_mcr,$testDate,
                    $testTime,$paymentMode,$paymentRefNo,$staffCode,$testLocation,$ariSymptomps,$contraindication);
    if($stmt->execute()) {
      echo "Record Inserted Successfully";
    }
    //print_r($_POST);
    $stmt->close();    
       
      $conn->close();
     
    }
}

   
?>