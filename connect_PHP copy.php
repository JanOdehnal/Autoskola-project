<?php
 
/*use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require 'vendor/autoload.php';
 
$mail = new PHPMailer(true);
 
try {
    $mail->SMTPDebug = 2;                                       
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gfg.com;';                    
    $mail->SMTPAuth   = true;                             
    $mail->Username   = 'autoskola332@gmail.com';                 
    $mail->Password   = 'Autoskola2023';                        
    $mail->SMTPSecure = 'tls';                              
    $mail->Port       = 587;  
 
    $mail->setFrom('from@gfg.com', 'Name');           
    $mail->addAddress('ode2@seznam.cz');
    //$mail->addAddress('receiver2@gfg.com', 'Name');
      
    $mail->isHTML(true);                                  
    $mail->Subject = 'Subject';
    $mail->Body    = 'HTML message body in <b>bold</b> ';
    $mail->AltBody = 'Body in plain text for non-HTML mail clients';
    $mail->send();
    echo "Mail has been sent successfully!";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}*/
 
?>


<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$mail = new PHPMailer(true);




//mozane reseni!!!!!!!!!!!!!!!!!!






    // Server settings
    $mail->SMTPDebug = 2;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'youremail@gmail.com';                     // SMTP username
    $mail->Password   = 'yourpassword';                               // SMTP password
    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    // Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
    $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');
    // Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
    echo 'Message has been sent';
