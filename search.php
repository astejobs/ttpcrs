<?php 
session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);

/*** THIS! ***/
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
/*** ^^^^^ ***/

require_once('connection.php');
//Update Existing Record 
if(isset($_GET['update'])){

    $patientName = mysqli_real_escape_string($conn, $_POST['patientName']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dobDate = mysqli_real_escape_string($conn, $_POST['dobDate']);
    

        if(!empty($_POST['search']))
        {
            $search = $_POST['search'];
            $stmt = $con->prepare("select * from employee_info where department like '%$search%' or name like '%$search%'");
            $stmt->execute();
            $employee_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //print_r($employee_details);
            
        }
        else
        {
            $searchErr = "Please enter the information";
        }
    //print_r($_POST);
    $stmt->close();    
       
    $conn->close();
     
    
}

   
?>