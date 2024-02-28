<?php
session_start();
//Import PHPMailer classes 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include('includes/bd.php');

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$rand_verification_email = rand(100000, 999999);
echo $_GET['message'];


try {
    //Server settings
    $mail->SMTPDebug = 1;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'italent.contact.site@gmail.com';                     //SMTP username
    $mail->Password   = 'AJR3MOUSQUETAIRES';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;              //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('italent.contact.site@gmail.com', 'Italent');
    $mail->addAddress($_GET['message']); // Destinataire

$body = '<p>Bonjour, nous vous remercions de faire confiance à Italent pour la recherche de votre prochain emploi !
Nous avons juste besoin d\'une petite vérification de votre part pour que vous puissiez vous connecter. 
Copiez ce code pour vérifier votre identité et retournez sur Italent !<br>Votre code de vérification :' . $rand_verification_email . '</p>';


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Confirmation de votre inscription';
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

$message = '
Code de vérification :'  . $rand_verification_email;




    
?>