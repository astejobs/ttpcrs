<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TheTestingPro &#9867; (TTP)</title>
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
<body>
		
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top header-transparent">
    <div class="container d-flex align-items-center">

      <!-- Uncomment below if you prefer to use an image logo -->
      <a href="index.php" class="logo mr-auto "><img src="assets/img/TheTestingPro.png" alt="" class="img-fluid" data-aos="zoom-out-down"></a>

      <nav class="main-nav d-none d-lg-block">
        <ul>
          <li class="m1" label="Home"><a href="index.php">Register</a></li>
          
          <li class="drop-down m1" label="Contact"><a href="">Reports</a>  
            <ul>
              <li><a href="contact.php">Past Attendance</a></li>           
            </ul>
          </li>   

          <li class="drop-down m1" label="Contact"><a href="">Query</a>  
            <ul>
              <li><a href="registrations.php">Search Dbase</a></li>           
            </ul>
          </li>   

          <?php if(isset($_SESSION['ID'])) { ?>

            <?php if( $_SESSION['ROLE']=='ADMIN' || $_SESSION['ROLE']=='MANAGER') { ?>            
              <li class="drop-down m1" label="Contact"><a href="">Admin</a>  
                <ul>
                  <li><a href="contact.php">Edit/Delete Entries</a></li>           
                </ul>
              </li> 
            <?php } ?>

            <?php if($_SESSION['ROLE']=='ADMIN') { ?>
              <li class="drop-down m1" label="Contact"><a href="">Account</a>  
                <ul>
                  <li><a href="contact.php">Add/Delete Accounts</a></li> 
                  <li><a href="contact.php">Edit/Delete Entries</a></li>           
                </ul>
              </li>             
            <?php } ?>

            <li><a href="login.php?logout=true">Logout</a></li>

          <?php } else { ?>
            <li><a href="login.php">Login</a></li>
          <?php } ?>
        </ul>
      </nav><!-- .main-nav-->

    </div>
  </header><!-- End Header -->