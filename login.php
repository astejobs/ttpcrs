<?php
require_once('header.php');

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
		}
		
} else {
?>

<section id="main-section" class="clearfix">
	<div class="container-fluid pt-5">
	
<!-- Body Section -->
<section id="why-us" class="why-us">
	<div class="container-fluid">
		<div class="row col-sm-12">
			<?php
				if(isset($_SESSION['invalidlogindetails'])) 
				{ 
					echo "<div class='alert alert-danger'><strong>".$_SESSION['invalidlogindetails']."</strong> !";
					echo "<button class='close' data-dismiss='alert'>&times;</button></div>";
					unset($_SESSION['invalidlogindetails']);
				}
			?>
		</div>
	
		<div class="row">
			<div class="card-chart p-5 mx-auto" data-aos="slide-down">
				<form action="login.php" method="post">
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label">Username</label>
						<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="username">
						<div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
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
