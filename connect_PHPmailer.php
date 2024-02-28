<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* Exception class. */
require 'PHPMailer\PHPMailer\src\Exception.php';

/* The main PHPMailer class. */
require 'PHPMailer\PHPMailer\src\PHPMailer.php';

/* SMTP class, needed if you want to use SMTP. */
require 'PHPMailer\PHPMailer\src\SMTP.php';

function create_email()
{
    $email = new PHPMailer(TRUE);
    $mail = $email;
    $mail->SMTPDebug  = 1; 
    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->SMTPAuth = true; // enable SMTP authentication
    $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
    $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
    $mail->Port = 465; // set the SMTP port for the GMAIL server
    $mail->Username = "autoskola332@gmail.com"; // GMAIL username
    $mail->Password = "scsmouvcdiutixvr"; // GMAIL password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    return $mail;
}

function send_email($name, $msg)
{
    $mail=create_email();
    $mail->AddAddress($name, "");
    $mail->SetFrom("autoskola332@gmail.com", "Autoskola");
    $mail->Subject = "Autoskola info";
    $mail->Body = $msg;
    try{
        $mail->Send();
        echo "<script>document.getElementById('logs').innerHTML = 'Uspěšně odeslano!'</script>";
    } catch(Exception $e){
        //Something went bad
        echo "<script>document.getElementById('logs').innerHTML = 'Chyba - " . $mail->ErrorInfo."'</script>";

    }
    echo "<script>location.reload()</script>";
    echo "<script>document.getElementById('logs').innerHTML = 'Emaily bohužel nefungují!'</script>";
}
?>