<?php 

if(isset($_POST['email'])){

    $to = "shahid.jktechnosoft@gmail.com"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address

    $sql = "INSERT INTO subscribers (email) VALUES ('$from')";
    
    if ($conn->query($sql) === TRUE) {

      $headers = "From:" . $from;
      $subject = $from." has subscribed for Newsletter";

      mail($to,$subject,$headers);

      $msg = "OK";
      echo $msg;

    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
 
    

    //echo "Mail Sent. Thank you " . $first_name . ", we will contact you shortly.";
    // You can also use header('Location: thank_you.php'); to redirect to another page.
   
    }
?>