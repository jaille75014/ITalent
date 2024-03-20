<?php 
session_start();  
if(isset($_POST["email"])) {
  if( !empty($_POST['email'])){
    if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
      header('location: ' . htmlspecialchars($_GET['url']) .'?messageFailure=Votre email est invalide :('); 
      exit;
  }
  $_SESSION['newsletter'] = 1;
  include '../includes/phpmailer.php'; // Settings for phpmailer

  $email = htmlspecialchars($_POST['email']);
  //Recipients
  $mail->setFrom('italent.contact.site@gmail.com', 'Italent');
  $mail->addAddress($email); // Destinataire
  
  $body = '<p>Vous touchez au but ! Pour valider votre inscription à notre newsletter, 
  <a href="213.32.89.122/inscription_newsletter.php?news=1&email=' . $email . '&url=' . htmlspecialchars($_GET['url']) . '">cliquez ici</a></p>.'; // tru = condition pour la page d'inscription à la newsletter; 
                                                                                                                        //url=page sur laquelle il s'est inscrit pour le rediriger sur la meme page en cas de problemes

  //Attachments :
  $mail->addAttachment('../assets/LOGO_version_complète.png', "LOGO_version_complète.png");

  //Content
  $mail->isHTML(true);                                  //Set email format to HTML
  $mail->Subject = 'Inscription a la newsletter';
  $mail->Body    = $body;
  $mail->AltBody = strip_tags($body);

  try {
    $mail->send();
    echo'Un email viens de vous être envoyé';

  } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      header("location: ../connexion.php");
  } 

  } //if(!empty($_POST['email'])) 
  
} // if(isset($_GET["email"])) {

?>