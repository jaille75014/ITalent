<?php
//Import PHPMailer classes 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require(__DIR__ . '/../vendor/autoload.php');

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

    //Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; 
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = 'italent.contact.site@gmail.com';   
    $mail->Password   = 'amlgyldqoziafkuu';              
    $mail->SMTPSecure = 'tls';      
    $mail->Port       = 587;              

?>