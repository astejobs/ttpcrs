<?php session_start(); date_default_timezone_set('Asia/Singapore'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Client Registration System &#9867; (CRS)</title>
  <meta content="The Testing Pro, makes covid-19 testing easy for you" name="descriptison">
  <meta content="The Testing Pro, Covid-19 test, coronavirus, corona tests, easy testing" name="keywords">

  <!-- Favicons -->
  <!-- <link href="assets/img/favicon.png" rel="icon" type='image/png'> -->
  <link rel='rel' href='favicon.ico' type='image/x-icon'>
  <link rel='shortcut icon' href='favicon.ico' type='image/x-icon'>
  <!-- <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

  <!-- Google Fonts -->
  <link href="assets/css/fonts.css" rel="stylesheet">
  <link href="assets/css/fonts2.css" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="assets/vendor/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/owl-carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/flatpickr.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" /> -->

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  
  <script src="assets/vendor/jquery/jquery.min.js"></script>
</head>
<body style="background:url('assets/img/login-bg.png')">
	
<?php
/* require_once('header.php'); */

/*   if (isset($_SESSION['ID'])) {
      header("location:index.php");
      exit();
  } */

require_once('connection.php');

if(isset($_GET['logout'])) {
	session_destroy();
	header("location:login.php"); 
	exit(); 
}

if(isset($_POST['login'])) {

		$errorMsg = "";

		$username=mysqli_real_escape_string($conn, $_POST['username']);
		$pwd=mysqli_real_escape_string($conn, $_POST['password']);

		//$pwd=md5($pwd);
		
		/* $options = [
			'cost' => 10,
		]; */		  
		//$pwd1 = password_hash($pwd, PASSWORD_BCRYPT);
		//echo $pwd1;
		function login($conn,$username, $password){
			$sql1 = "SELECT * FROM `users` WHERE `username`='".$username."'";
			$userResult=mysqli_query($conn, $sql1);
			$userCount=mysqli_num_rows($userResult);		
			if($userCount==true) { 
				while($userRow = $userResult->fetch_assoc()) {
					if(password_verify($password, $userRow['password'])) { 
						$_SESSION['ID'] = $userRow['id'];
						$_SESSION['ROLE'] = $userRow['role'];
						$_SESSION['NAME'] = $userRow['name'];
						$_SESSION['start'] = time();
						$_SESSION['expire'] = $_SESSION['start']+(3*60*60);  //3 hours
						return password_verify($password, $userRow['password']);
					} 					
				}
				return 0;
			}
			return 0;
		}			


		if (!empty($username) || !empty($pwd)) {
			if(login($conn,$username,$pwd)) {				
				header("location:index.php"); 
				die();  
			} else {
				$errorMsg = "No user found on this username";
				$_SESSION['invalidlogindetails']="**Incorrect login details";
				header("location:login.php");
				//wp_redirect("login.php"); 
				exit;
			}		
		}else{
			$errorMsg = "Username and Password is required";
			$_SESSION['invalidlogindetails']=$errorMsg;
			header("location:login.php");
			exit;
		}
		
} else {
?>

<section id="main-section" class="clearfix">
	<div class="container-fluid pt-5">
	
<!-- Body Section -->
<section id="why-us" class="why-us" style="height:100%">
	<div class="container-fluid">
			
		<div class="row">
			<div class="card-chart col-sm-4 offset-md-4 p-5 mx-auto" data-aos="slide-down">
			<?php
					if(isset($_SESSION['invalidlogindetails'])) 
					{ 
						echo "<div class='alert alert-danger'>".$_SESSION['invalidlogindetails']." !";
						echo "<button class='close' data-dismiss='alert'>&times;</button></div>";
						unset($_SESSION['invalidlogindetails']);
					}
					if(isset($_GET['sessionExpired'])) {
						echo "<div class='alert alert-danger'>Session Expired, Please login !";
						echo "<button class='close' data-dismiss='alert'>&times;</button></div>";
						session_destroy();
					}
				?>
				<form action="login.php" method="post">
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label">Username</label>
						<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="username">
						<!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
					</div>
					<div class="mb-3">
						<label for="exampleInputPassword1" class="form-label">Password</label>
						<input type="password" class="form-control" id="exampleInputPassword1" name="password">
					</div>
					<button type="submit" name="login" class="btn btn-info btn-block">Login</button>
				</form>
			</div>
		</div>

	</div>
	
</section>
<!-- End Body Section -->

 </div>
</section> 
<?php
	require_once('footer.php');
	}
	$conn->close();
?>
