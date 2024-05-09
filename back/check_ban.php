<?php 
session_start();
include("../includes/bd.php");
include("../includes/header_location.php");
include("../includes/phpmailer.php");


if(isset($_GET['id'])) {
    $user_id = htmlspecialchars($_GET['id']);
    $select_statut = 'SELECT name_factory FROM USERS WHERE user_id = ' . $user_id;
    $res = $bdd->query($select_statut);
    $row = $res->fetch(PDO::FETCH_ASSOC);
    

    if ($row['name_factory'] !== NULL) {
        $update_statut = 'UPDATE USERS SET statut = 1 WHERE user_id = ' . $user_id;
    } else {
        $update_statut = 'UPDATE USERS SET statut = 2 WHERE user_id = ' . $user_id;
    }
    
    $bdd->query($update_statut);
    $delete_ban = 'DELETE FROM BAN WHERE id = ' . $user_id;
    $bdd->query($delete_ban);
    if(isset($_GET['admin'])) {
        redirectSuccess('../demande', 'L\'utilisateur a bien été débanni');
    } else {
        redirectSuccess('../connexion', 'Votre compte a bien été réactivé');
    }

} else {
    if(empty($_POST['name']) || empty($_POST['lastname']) || empty($_POST['message']) || empty($_POST['email'])) {
        redirectFailure('../ban', 'Veuillez remplir tous les champs');
    }    

    if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        redirectFailure('../ban', 'Votre email est invalide :('); 
    }
    $user_id = $_SESSION['user_id'];
    $name = htmlspecialchars($_POST['name']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    if($_POST['reason'] != "Suppression de compte") {
    $request_unban = 'INSERT INTO BAN_REQUEST (user_id, firstname, lastname, email, message, date) VALUES ("' . $user_id .'", "' . $name . '", "' . $lastname . '", "' . $email . '", "' . $message . '", "'. date('Y-m-d H:i:s') .'")';
    $res = $bdd->query($request_unban);

        if($res) {
            redirectSuccess('../ban', 'Votre demande a bien été envoyée');
        } else {
            redirectFailure('../ban', 'Une erreur est survenue lors de l\'envoi de votre demande');
        }
    } else { 
        // Envoi d'un mail a l'utilisateur pour récupérer son compte
        //Recipients
        $mail->setFrom('italent.contact.site@gmail.com', 'Italent');
        $mail->addAddress($email); // Destinataire

        $serverName = $_SERVER['SERVER_NAME'];

        $body = '<p>Bonjour, vous avez demandé la récupération de votre compte.<br></p>
        <p>Pour vérifier votre identitée, veuillez cliquer sur ce lien, après quoi votre compte sera réactivé : 
            <a href="https://' . $serverName . '/back/check_ban?id=' . $user_id . '">Récupérer mon compte</a><br>
        </p>';

        //Attachments :
        $mail->addAttachment('../assets/LOGO_version_complète.png', "LOGO_version_complète.png");

        //Content
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Récupération de votre compte ITalent';
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body);

        try {
            $mail->send();
            echo '<p>Consultez vos email / spans pour récupérer votre compte. Vous pouvez à présent fermer cette fenêtre. Merci</p>';
        } catch (Exception $e) {
            echo "Message non envoyé. Mailer Error: {$mail->ErrorInfo}";
        } 
    }
}
?>