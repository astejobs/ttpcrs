<?php 
  date_default_timezone_set('Asia/Singapore');
  session_start();
  ini_set('display_errors',1);
  error_reporting(E_ALL);

  /*** THIS! ***/
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  /*** ^^^^^ ***/
  if(!isset($_SESSION['ID'])) {
    header("location:login.php");
    exit;
  }
  if(isset($_SESSION['ID'])) {
    $now = time();
    if($now > $_SESSION['expire']) {
        header("location:login.php?sessionExpired=true");
        exit;
    }
  }

  require_once('connection.php');
  //Update Existing Record 
  if(isset($_GET['update'])){

  if(isset($_POST['id'])){ 
    $id = $_POST['id'];
    $patientName = mysqli_real_escape_string($conn, $_POST['patientName']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dobDate = mysqli_real_escape_string($conn, $_POST['dobDate']);
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
    $ariSymptomps = isset($_POST['ariSymptomps']) ? "1" : "0";
    $contraindication = isset($_POST['contraindication']) ? "1" : "0";
    
      $sql = "UPDATE registrations SET patientName='".$patientName."', 
                                       gender='".$gender."', 
                                       dob='".$dobDate."', 
                                       nric_fin_number='".$nric_fin_number."', 
                                       nationality='".$nationality."', 
                                       contactNumber='".$contactNumber."', 
                                       testType='".$testType."', 
                                       specimenType='".$specimenType."', 
                                       clinicName='".$clinicName."', 
                                       physician_mcr='".$performing_mcr."', 
                                       testDate='".$testDate."', 
                                       testTime='".$testTime."', 
                                       paymentMode='".$paymentMode."', 
                                       paymentRefNo='".$paymentRefNo."', 
                                       staffCode='".$staffCode."', 
                                       testLocation='".$testLocation."', 
                                       ari_symptoms='".$ariSymptomps."', 
                                       contraindication='".$contraindication."', 
                                       passportNumber='".$passportNumber."' WHERE id='".$id."'";
      
      if ($conn->query($sql) === TRUE) {            
            //echo "Blog Added Successfully";
            $_SESSION['msg']="Record has been updated  successfully"; 
            header('location:edit-entries.php');
            exit;
      } else {
            $_SESSION['msg']="Error: Record was not updated, please try again"; 
            header('location:edit-entries.php');
            exit;
            echo "Error: " . $sql . "<br>" . $conn->error;
      }
       
      $conn->close();
   
     
  }
  
} else {  //Add New Registration 

  if(isset($_POST['submit'])){ 
    /* print_r($_POST); 
    
    $tst = isset($_POST['ariSymptomps']) ? "checked" : "unchecked";
    echo $tst;
    exit; */
  
    $patientName = mysqli_real_escape_string($conn, $_POST['patientName']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dobDate = mysqli_real_escape_string($conn, $_POST['dobDate']);
    $dobDate = date($dobDate);
    $passportNumber = mysqli_real_escape_string($conn, $_POST['passportNumber']);
    $nric_fin_number = mysqli_real_escape_string($conn, $_POST['nric_fin_number']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
    $contactNumber = mysqli_real_escape_string($conn, $_POST['contactNumber']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $serviceType = mysqli_real_escape_string($conn, $_POST['serviceType']);
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
    $ariSymptomps = isset($_POST['ariSymptomps']) ? "1" : "0";
    $contraindication = isset($_POST['contraindication']) ? "1" : "0";

    /* $s1 = mysqli_query($conn, "SELECT * FROM registrations WHERE passportNumber = '".$passportNumber."'");
    if(mysqli_num_rows($s1)) {
      $_SESSION['msg']="This passport Number is already registered!"; 
      header('location:register-form.php');
      exit;
    } */
   /*  $s1 = mysqli_query($conn, "SELECT * FROM registrations WHERE nric_fin_number = '".$nric_fin_number."'");
    if(mysqli_num_rows($s1)) {
      $_SESSION['msg']="NRIC/FIN is already registered!"; 
      header('location:register-form.php');
      exit;
    } */

    $sql = "INSERT INTO registrations (patientName, dob, gender,passportNumber,nric_fin_number,nationality,
            contactNumber,email,serviceType,testType,specimenType,clinicName,physician_mcr,testDate,testTime,
            paymentMode,paymentRefNo,staffCode,testLocation,ari_symptoms,contraindication)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("sssssssssssssssssssss", $patientName,$dobDate,$gender,$passportNumber,$nric_fin_number,$nationality,
                      $contactNumber,$email,$serviceType,$testType,$specimenType,$clinicName,$performing_mcr,$testDate,
                    $testTime,$paymentMode,$paymentRefNo,$staffCode,$testLocation,$ariSymptomps,$contraindication);
    if($stmt->execute()) {
      $last_id = $conn->insert_id;
      $_SESSION['msg']="Registration Submitted successfully"; 
      header('location:print-label.php?id='.$last_id);
    } else {
      echo $stmt->errorInfo;
      echo "Record not Inserted";
      echo $stmt->error;
    }
    //print_r($_POST);
    $stmt->close();    
       
      $conn->close();
     
    }
}

   
?>