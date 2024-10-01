<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'IAP/Mail/PHP_Mailer/src/Exception.php';
require 'IAP/Mail/PHP_Mailer/src/PHPMailer.php';
require 'IAP/Mail/PHP_Mailer/src/SMTP.php';

if (isset($_POST["send"])){
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail ->SMTPAuth = true;
    $mail->Username = 'patrickmaina.nganga@strathmore.edu';
    $mail->Password = 'gtae fcxy vded oyxf';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;


     $mail->setFrom('patrickmaina.nganga@strathmore.edu');
     $mail->addAddress($_POST["email"]);
     $mail->isHTML(true);
     $mail->Subject = $_POST["sUBJECT"];
     $mail->Body = $_POST["message"];

     $mail->send();

     echo
     "
     <script> 
     alert('sent successfully');
     document.location.href = 'mail.php';
    
     </script>
     ";
      
}
?>