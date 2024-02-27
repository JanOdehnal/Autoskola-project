<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* Exception class. */
require 'PHPMailer\PHPMailer\src\Exception.php';

/* The main PHPMailer class. */
require 'PHPMailer\PHPMailer\src\PHPMailer.php';

/* SMTP class, needed if you want to use SMTP. */
require 'PHPMailer\PHPMailer\src\SMTP.php';

$email = new PHPMailer(TRUE);
$mail = $email;
/* ... */

if(/*$send_using_gmail*/true){
    $mail->SMTPDebug  = 1; 
    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->SMTPAuth = true; // enable SMTP authentication
    $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
    $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
    $mail->Port = 465; // set the SMTP port for the GMAIL server
    $mail->Username = "autoskola332@gmail.com"; // GMAIL username
    $mail->Password = "Autoskola2023"; // GMAIL password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
}

//Typical mail data
$mail->AddAddress("ode2@seznam.cz", /*$name*/"Ode 2");
$mail->SetFrom(/*$email_from, $name_from*/"autoskola332@gmail.com", "Autoskola");
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