<?php 
//use assets\vendor\phpMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
require_once('assets/vendor/phpMailer/Exception.php');
require_once('assets/vendor/phpMailer/PHPMailer.php');
require_once('assets/vendor/phpMailer/SMTP.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['email'])){

    $to1 = "shahid.jktechnosoft@gmail.com"; 
    $to2 = "tantryriyaz87@gmail.com";
    $from = $_POST['email']; 
    
    $name = $_POST['name'];    
    
      $subject = "Request for MA3S Intro Deck.";
      
      $mail = new PHPMailer\PHPMailer\PHPMailer();
      //$mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->Mailer = "smtp";

      $mail->SMTPDebug  = 4;  
      $mail->SMTPAuth   = TRUE;
      $mail->SMTPSecure = "tls";
      $mail->Port       = 587;
      $mail->Host       = "mail.stie.com.sg";
      $mail->Username   = "info@stie.com.sg";
      $mail->Password   = "in5#aS135!}";      

      $mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
      );

      $mail->IsHTML(true);
      $mail->AddAddress($to1); //Recipient name is optional
      $mail->SetFrom("info@thetestingpro.com", "TheTestingPro");
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
                    Thank you. Please download the MA3S intro deck here https://bit.ly/download-MA3S 
                    <br>
                    For more information or enquiry, please email us at info@thetestingpro.com
                  </td>
                </tr>
              </table> <br> <br>
              </td>
          </tr>
        </table>
      </body>
      </html>';

    /*  */

      $content2  = '<html xmlns="http://www.w3.org/1999/xhtml">
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
                        This Person has requested for MA3S Intro Deck, Response with download link https://bit.ly/download-MA3S was sent. 
                            
                    <div>
                      <br><u>Sender Details</u><br>
                      <b>'.$name.'</b><br>
                      Email: '.$from.'<br>                      
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
          echo $msg;
          //return;
      } else {
          echo "Error while sending Email.";
          //return; 
          var_dump($mail->ErrorInfo);
          //var_dump($mail); exit;
      }
      //$mail->ClearAllRecipients();
      $mail->ClearAddresses();
      $mail->AddAddress($to2);
      $mail->MsgHTML($content2); 
      if($mail->Send()) {
        $msg = "OK";          
        echo $msg;
        //return;
    } else {
        echo "Error while sending Email.";
        //return; 
        var_dump($mail->ErrorInfo);
        //var_dump($mail); exit;
    }
   
    }
?>