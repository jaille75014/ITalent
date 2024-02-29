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
$q = 'INSERT INTO USERS(email_number) VALUES ($rand_verification_email) WHERE email = '. $_GET['message'];

try {
    //Server settings
    $mail->SMTPDebug = 1;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'italent.contact.site@gmail.com';                     //SMTP username
    $mail->Password   = 'amlgyldqoziafkuu';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;              //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('italent.contact.site@gmail.com', 'Italent');
    $mail->addAddress($_GET['message']); // Destinataire

    $body = '<p>Bonjour, nous vous remercions de faire confiance à Italent pour la recherche de votre prochain emploi ! <br><br>
    Nous avons juste besoin d\'une petite vérification de votre part pour que vous puissiez vous connecter. <br>
    Copiez ce code pour vérifier votre identité et retournez sur Italent !<br>Votre code de vérification : <b>' . $rand_verification_email . '</b></p>';


    //Attachments :
    $mail->addAttachment('assets/LOGO_version_complète.png', "LOGO_version_complète.png");

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Confirmation de votre inscription';
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);
    $mail->send();

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header('location : inscription.php?message=L\'email n\'a pas pu être envoyé, vérifiez que vous avez bien écrit votre adresse email.');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification | Italent</title>
</head>
<body>
    <?php include('includes/header.php') ?>
    <main>
        <h1>Vous y êtes presque !</h1>
        <p>Nous vous avons envoyé un mail de confirmation à l'adresse mail que vous avez indiqué dans le formulaire
            consultez la et revenez ici le plus vite possible !
        </p>
        <p>Renseignez le code à 6 chiffres :</p>
        <form action="verification_email.php" method="POST">
        <input type="text" name="code" placeholder="Entrez le code :">
        <input type="submit" value="Vérifier le code">
        </form>
        <?php 
        $q = 'SELECT email_number FROM USERS WHERE email = ' . $_GET['message']; 
        // Vérifie si le code correspond à celui inscrit dans la bdd
        if(isset($_POST['code']) && $_POST['code'] == $q){
            // Si c'est le cas, on valide l'email
            $q = 'INSERT INTO USERS (email_check) VALUES (1) WHERE email =' . $_GET['message'];
            header('location :connexion.php?message=Inscription valide, veuillez vous connecter');
            exit;
        } else {
            echo 'Ce n\'est pas le bon code, réessaye';
        }
        ?>
    </main>
</body>
</html>