<?php 
//use assets\vendor\phpMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
require_once('assets/vendor/phpMailer/Exception.php');
require_once('assets/vendor/phpMailer/PHPMailer.php');
require_once('assets/vendor/phpMailer/SMTP.php');

if(isset($_POST['email'])){

    $to = "shahid.jktechnosoft@gmail.com"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    if(isset($_POST['companyName'])){
      $company_name = $_POST['companyName'];
    } else {
      $company_name = '';
    }
    $first_name = $_POST['name'];
    if(isset($_POST['contactNumber'])){
      $contact_number = $_POST['contactNumber'];
    } else {
      $contact_number = '';
    }
    $enquiry_type = $_POST['enquiryType'];     
      
      $message = $_POST['message'];
      $subject = "You have an email from TheTestingPro domain.";
      
      $mail = new PHPMailer\PHPMailer\PHPMailer();
      //$mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->Mailer = "smtp";

      $mail->SMTPDebug  = 1;  
      $mail->SMTPAuth   = TRUE;
      $mail->SMTPSecure = "tls";
      $mail->Port       = 587;
      $mail->Host       = "mail.stie.com.sg";
      $mail->Username   = "info@stie.com.sg";
      $mail->Password   = "in5#aS135!}";

      $mail->IsHTML(true);
      $mail->AddAddress("shahid.jktechnosoft@gmail.com", "Shah Shahid");
      $mail->SetFrom("shahid.sheikhpora@gmail.com", "TheTestingPro");
      $mail->Subject = $subject;
      $mail->AddEmbeddedImage('logo.png', 'logoImage');

      $content  = '<html xmlns="http://www.w3.org/1999/xhtml">
      <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>TheTestingPro Mail</title>
      </head>
      
      <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top" bgcolor="#f5f8fd;"
              style="background-color: #f5f8fd;"><br> <br>
              <table width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" valign="top" bgcolor="#f5f8fd;"
                    style="background-color: #f5f8fd; font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #000000; padding: 0px 15px 10px 15px;">
                    
                    <img src="cid:logoImage" style="display:block;width:193px;height:150px" alt="TheTestingPro">
                   
                    
                    <br>
                    <span style="font-size:18px;font-weight:400px;"><b>'.$subject.'</b></span>							
                    <br>
                    
                    <div>
                      <br>'.$message.'<br>
                      <br><u>Sender Details</u><br>
                      <b>'.$first_name.'</b><br>
                      Company: '.$company_name.'<br>
                      Contact Number: '.$contact_number.'<br>
                      Email: '.$from.'<br>
                      Enquiry Type: '.$enquiry_type.'<br>
                      
                    </div>
                  </td>
                </tr>
              </table> <br> <br>
              </td>
          </tr>
        </table>
      </body>
      </html>';

      $mail->MsgHTML($content); 
      if($mail->Send()) {
          $msg = "OK";          
          echo $msg; exit;
          //return;
      } else {
          echo "Error while sending Email.";
          //return; 
          var_dump($mail); exit;
      }
   
    }
?>