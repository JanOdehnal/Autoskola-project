<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* Exception class. */
require 'C:\wamp64\www\Honza\autoskola_priprava\PHPMailer\src\Exception.php';

/* The main PHPMailer class. */
require '.\PHPMailer\src\PHPMailer.php';

/* SMTP class, needed if you want to use SMTP. */
require '.\PHPMailer\src\SMTP.php';

$email = new PHPMailer(TRUE);
/* ... */

if($send_using_gmail){
    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->SMTPAuth = true; // enable SMTP authentication
    $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
    $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
    $mail->Port = 465; // set the SMTP port for the GMAIL server
    $mail->Username = "autoskola332@gmail.com"; // GMAIL username
    $mail->Password = "Autoskola2023"; // GMAIL password
}

//Typical mail data
$mail->AddAddress("ode2@seznam.cz", $name);
$mail->SetFrom($email_from, $name_from);
$mail->Subject = "My Subject";
$mail->Body = "Mail contents";

try{
    $mail->Send();
    echo "Success!";
} catch(Exception $e){
    //Something went bad
    echo "Fail - " . $mail->ErrorInfo;
}





?>