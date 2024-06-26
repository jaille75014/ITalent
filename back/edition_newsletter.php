<?php 
session_start();
include("../includes/bd.php");
include('../includes/phpmailer.php');
include('../includes/header_location.php');

$userid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'envoyé automatiquement';
function getSubscribedUsers($bdd) {
    $users_subscribed = 'SELECT email FROM USERS WHERE newsletter = 1';
    $req = $bdd->prepare($users_subscribed);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

function getUserType($bdd, $email) {
    $type = 'SELECT statut FROM USERS WHERE email = :email';
    $req = $bdd->prepare($type);
    $req->execute(['email' => $email]);
    return $req->fetch(PDO::FETCH_ASSOC);
}

function sendEmail($mail, $header, $body, $image, $emails) {
    $mail->setFrom('italent.contact.site@gmail.com', 'Italent');

    foreach ($emails as $email) {
        $mail->addBCC($email); // Ajoutez le destinataire en copie cachée
    }

    //Attachments :
    $mail->addAttachment($image, 'Image de la newsletter');

    //Content
    $mail->isHTML(true);   
    $mail->CharSet = 'UTF-8';                               
    $mail->Subject = $header;
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);

    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
function saveNewsletter($bdd, $header, $body, $user_id) {
    $query = 'INSERT INTO NEWSLETTER (title, body, user_id) VALUES (:title, :body, :user_id)';
    $req = $bdd->prepare($query);
    $req->execute(['title' => $header, 'body' => $body, 'user_id' => $user_id]);
}


$header = isset($_POST['header']) && !empty($_POST['header']) ? htmlspecialchars($_POST['header']) : 'Quoi de neuf chez ITalent ?';
$body = isset($_POST['body_newsletter']) && !empty($_POST['body_newsletter']) ? $_POST['body_newsletter'] : 
'<h1>Bienvenue dans la newsletter d\'Italent</h1> <p>Pour l\'instant, 
nous travaillons encore sur la newsletter... Vous recevrez prochainement 
de nouveaux mails vous permettant de vous tenir au courant des prochaines nouveautées !</p>';

$image = $_FILES['image']['error'] != 4 ? $_FILES['image'] : '../assets/LOGO_version_complète.png';

$results = getSubscribedUsers($bdd);

$emails = [];
foreach ($results as $index => $values) {
    $userType = getUserType($bdd, $values['email']);
    if ((isset($_POST['etudiant']) && $userType['statut'] == 1) || (isset($_POST['recruteur']) && $userType['statut'] == 2) || (isset($_POST["admin"]) && $userType['statut'] == 3)) {
        echo '<p>Ajout de ' . $values['email'] . ' à la liste des destinataires</p>';
        $emails[] = $values['email'];
    } else { // envoi à tous les utilisateurs
        echo '<p>Ajout de ' . $values['email'] . ' à la liste des destinataires</p>';
        $emails[] = $values['email'];
    }
}

sendEmail($mail, $header, $body, $image, $emails);

// Enregistre le mail envoyé dans la base de données apres l'envoi de tous les mails
saveNewsletter($bdd, $header, $body, $userid);

redirectSuccess('../newsletter_admin', 'Tous les email ont été envoyé !');
?>