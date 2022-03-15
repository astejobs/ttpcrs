
<?php 
session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);


/*** THIS! ***/
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
/*** ^^^^^ ***/

// initializing variables
$username = "";
$name    = "";
$site = "";
$position    = "";
$role = "";
$errors = array(); 


require_once('connection.php');


//Update Existing Record 
if(isset($_POST['updateUser'])){

  if(isset($_POST['id'])) { echo "in edit";
      $id = $_POST['id'];
      // receive all input values from the form
      //$username = mysqli_real_escape_string($conn, $_POST['username']);
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      //$password_1 = mysqli_real_escape_string($conn, $_POST['password']);
      //$password_2 = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
      $role = mysqli_real_escape_string($conn, $_POST['role']);
      $position = mysqli_real_escape_string($conn, $_POST['position']);
      $site = mysqli_real_escape_string($conn, $_POST['site']);

      // form validation: ensure that the form is correctly filled ...
      // by adding (array_push()) corresponding error unto $errors array
      //if (empty($username)) { array_push($errors, "Username is required"); }
      if (empty($name)) { array_push($errors, "Name is required"); }
      if (empty($site)) { array_push($errors, "Site is required"); }
      if (empty($position)) { array_push($errors, "Position is required"); }
      //if (empty($password_1)) { array_push($errors, "Password is required"); }
      //if ($password_1 != $password_2) {
      //array_push($errors, "The two passwords do not match");    
      
      // Finally, update user if there are no errors in the form
      if (count($errors) == 0) { 
        //$pwd1 = password_hash($password_1, PASSWORD_BCRYPT); //encrypt the password before saving in the database
        
        $sql = "UPDATE users SET name='$name', 
                                  role='$role', 
                                  position='$position', 
                                  site='$site' WHERE id='$id'";
        
        if ($conn->query($sql) === TRUE) {            
              echo "User Updated Successfully";
              $_SESSION['msg']="User has been updated  successfully"; 
              header('location:users.php');
              exit;
        } else {
              $_SESSION['msg']="Error: User was not updated, please try again"; 
              header('location:edit-user.php');
              exit;
              echo "Error: " . $sql . "<br>" . $conn->error;
        }
      } else {
        $_SESSION['error'] = $errors;
        header('location: edit-user.php'); 
        exit;
      }
    
       
      $conn->close();
   
     
  }
  
} 

// REGISTER NEW USER
if (isset($_POST['submit'])) {
  // receive all input values from the form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password_1 = mysqli_real_escape_string($conn, $_POST['password']);
    $password_2 = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $site = mysqli_real_escape_string($conn, $_POST['site']);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($name)) { array_push($errors, "Name is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // first check the database to make sure 
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR name='$name' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    
    if ($user) { // if user exists
      if ($user['username'] === $username) {
        array_push($errors, "Username already exists");
      }

      if ($user['name'] === $name) {
        array_push($errors, "Name already exists");
      }
    }
    
    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) { 
      $pwd1 = password_hash($password_1, PASSWORD_BCRYPT); //encrypt the password before saving in the database

      $query = "INSERT INTO users (name,username, site,position,role, password) 
            VALUES('$name','$username', '$site','$position','$role', '$pwd1')";
      if(mysqli_query($conn, $query)) {
            $_SESSION['success'] = "User Added Successfully!";
            header('location:create-user.php');
            exit;
        }
      //$_SESSION['username'] = $username;
    } else {
        
      $_SESSION['error'] = $errors;
      header('location: create-user.php'); 
      exit;
    }
  }

?>