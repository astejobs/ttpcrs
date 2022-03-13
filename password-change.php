<?php
  require_once('header.php');
  $activePage = "Contact";
  $errors = array(); 
  include 'connection.php';

  if(isset($_POST['submit'])) {

    $username = $_POST['username'];
    //$password = $_POST['password'];
    $newpassword = $_POST['newpassword'];
    $confirmnewpassword = $_POST['confirmnewpassword'];

  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($newpassword)) { array_push($errors, "Password is required"); }
  if ($newpassword != $confirmnewpassword) {
	  array_push($errors, "The two passwords do not match");  
  }
  if (count($errors) == 0) { 
    $user_check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
      if ($user['username'] === $username) {
        $pwd1 = password_hash($newpassword, PASSWORD_BCRYPT); //encrypt the password before saving in the database
        $sql = "UPDATE users SET password='$pwd1' where username='$username'";
        $result2 = mysqli_query($conn, $sql);
        if($result2) {
          $_SESSION['success'] = "Congratulations You have successfully changed user password!";
          header('location: password-change.php');
          exit;
        }
      }
    } else {
      array_push($errors, "The username you entered does not exist"); 
    }
  }else {
    //$_SESSION['error'] = $errors;
    //header('location: password-change.php'); 
  }
    
    
    /* $result = mysqli_query($conn, "SELECT password FROM users WHERE username='$username'");
            if(!$result) {
              array_push($errors, "The username you entered does not exist"); 
              //$_SESSION['error'] = $errors;
              header('location: password-change.php');
            }else {

              if($newpassword==$confirmnewpassword) {
                  $pwd1 = password_hash($newpassword, PASSWORD_BCRYPT); //encrypt the password before saving in the database
                  $sql=mysqli_query($conn, "UPDATE users SET password='$pwd1' where username='$username'");
                  if($sql) {
                    $_SESSION['success'] = "Congratulations You have successfully changed user password!";
                    header('location: password-change.php');
                  } 
              } else {
                array_push($errors, "Password and Confirm Password does not match!");
                //$_SESSION['error'] = $errors;
                header('location: password-change.php');
              }

            }  */

  }
      
?>

<section id="main-section" class="clearfix">
	<div class="container-fluid pt-5">
	

<!-- Body Section -->

 <!-- ======= Why Us Section ======= -->
 <section id="why-us" class="why-us">
      <div class="container-fluid" data-aos="fade-up">

        

       <div class="row">
         <div class="col-sm-6 offset-md-3">
         <p class=" p-2 bg-dark text-white font-weight-bold text-center">CHANGE PASSWORD</p>
            <form method="POST" action="password-change.php">
                <div class="col-sm-12">
                    <?php
                        if(isset($_SESSION['success'])) 
                        { 
                            echo "<div class='alert alert-success'><strong>".$_SESSION['success']."</strong> !";
                            echo "<button class='close' data-dismiss='alert'>&times;</button></div>";
                            unset($_SESSION['success']);
                        } 
                        if (count($errors) > 0) : ?>
                          <div class="text-danger">
                            <?php foreach ($errors as $error) : ?>
                              <p><?php echo $error ?></p>
                            <?php endforeach ?>
                          </div>
                        <?php  endif;   
                    ?>
                </div>
            
                <div class="form-group">                  
                  <label>Enter your Username</label>
                  <input type="username" class="form-control" name="username">
                </div>
                
                <!-- <div class="form-group">                  
                  <label>Enter your existing password:</label>
                  <input type="password" class="form-control" name="password">
                </div> -->
                
                <div class="form-group">                  
                  <label>Enter your new password:</label>
                  <input type="password" class="form-control" name="newpassword">
                </div>
                
                <div class="form-group">                  
                  <label>Re-enter your new password:</label>
                  <input type="password" class="form-control" name="confirmnewpassword">
                </div>
                
                <div class="form-group">                  
                  <input type="submit" class="btn btn-info btn-block" name="submit" value="Update Password">
                </div>
              </form>
         </div>
       </div>
      </div>
     </div>

    </section>
		

<!-- End Body Section -->

<!-- Contact Section -->
<?php
 /*  require_once('contact-form.php'); */
?>

    
<!-- End contact Section -->


</div>
</section> 


</main><!-- End #main -->
<?php
require_once('footer.php');
?>