<?php 
include("../includes/bd.php");

$users_subscribed = 'SELECT email FROM USERS WHERE newsletter = 1';
$req=$bdd->prepare($users_subscribed);
    $result=$req->execute();
    $results = $req->fetch(PDO::FETCH_ASSOC);
    include('../includes/phpmailer.php');

    
    if(isset($_POST['header']) && !empty($_POST['header'])){
        $header = htmlspecialchars($_POST['header']);
    } else {
        $header = 'Quoi de neuf chez ITalent ?';
    }
    
    if(isset($_POST['body_newsletter']) && !empty($_POST['body_newsletter'])){
        $body = $_POST['body_newsletter'];
    } else {
        $body = '<h1>Bienvenue dans la newsletter d\'Italent</h1> <p>Pour l\'instant, nous travaillons encore sur la newsletter...
        Vous recevrez prochainement de nouveaux mails vous permettant de vous tenir au courant des prochaines nouveautées !</p>';
    }

    if(isset($_FILES['image']) && !empty($_FILES['image'])){
        $image = $_FILES['image'];
    } else {
        $image = '../assets/LOGO_version_complète.png';
    }
        
    foreach ($results as $index => $values) {
        if(isset($_POST['etudiant'])){
            $type = 'SELECT statut FROM USERS WHERE email = \''. $values . '\'';
            $req=$bdd->prepare($type);
            $result=$req->execute();
            $result = $req->fetch(PDO::FETCH_ASSOC);
            if ($result == 1) {
                echo '<p>Envoi du mail à' . $values . '</p>';
                    //Recipients
                $mail->setFrom('italent.contact.site@gmail.com', 'Italent');
                $mail->addAddress($values); // Destinataire

                //Attachments :
                $mail->addAttachment($image, 'Image de la newsletter');

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $header;
                $mail->Body    = $body;
                $mail->AltBody = strip_tags($body);

                try {
                $mail->send();

                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } 
        } else if(isset($_POST['recruteur'])){
            $type = 'SELECT statut FROM USERS WHERE email = \''. $values . '\'';
            $req=$bdd->prepare($type);
            $result=$req->execute();
            $result = $req->fetch(PDO::FETCH_ASSOC);
            if ($result == 2) {
                echo '<p>Envoi du mail à' . $values . '</p>';
                    //Recipients
                    $mail->setFrom('italent.contact.site@gmail.com', 'Italent');
                    $mail->addAddress($values); // Destinataire
    
                    //Attachments :
                    $mail->addAttachment($image, 'Image de la newsletter');
    
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = $header;
                    $mail->Body    = $body;
                    $mail->AltBody = strip_tags($body);
    
                    try {
                    $mail->send();
    
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
            }
        } else {
            echo '<p>Envoi du mail à' . $values . '</p>';
            //Recipients
            $mail->setFrom('italent.contact.site@gmail.com', 'Italent');
            $mail->addAddress($values); // Destinataire

            //Attachments :
            $mail->addAttachment($image, 'Image de la newsletter');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $header;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);

            try {
            $mail->send();

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
    header("location: ../newsletter_admin.php?messageSuccess=Tous les email ont été envoyé !");
?>