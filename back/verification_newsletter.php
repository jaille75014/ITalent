<?php 
session_start();  
if(isset($_POST["email"])) {
  if( !empty($_POST['email'])){
    if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
      header('location: ' . htmlspecialchars($_GET['url']) .'?messageFailure=Votre email est invalide :('); 
      exit;
  }
  $_SESSION['newsletter'] = 1;
  $serverName = $_SERVER['SERVER_NAME'];
  include '../includes/phpmailer.php'; // Settings for phpmailer

  $email = htmlspecialchars($_POST['email']);
  //Recipients
  $mail->setFrom('italent.contact.site@gmail.com', 'Italent');
  $mail->addAddress($email); // Destinataire
  
  $body = '<p>Vous touchez au but ! Pour valider votre inscription à notre newsletter, 
  <a href="https://' . $serverName . '/inscription_newsletter?news=1&email=' . $email . '&url=' . htmlspecialchars($_GET['url']) . '">cliquez ici</a></p>.'; // tru = condition pour la page d'inscription à la newsletter; 
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
    echo'<p class="text-center">Un email viens de vous être envoyé !
    Cette page va se fermer automatiquement dans 10 secondes !</p>';
?>
      <script>
        setTimeout(function() {
          window.close();
        }, 10000); // 10000 millisecondes = 10 secondes
      </script>
    <?php
  } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      header("location: ../index.php?messageFailure=Une erreur est survenue lors de l'envoi de l'email :(");
  } 
  } //if(!empty($_POST['email'])) 
  
} // if(isset($_GET["email"])) {

?>