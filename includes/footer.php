<footer>
  
  <div class="row">
    <div class="col-12 col-lg-3">
      <img src="assets/man_working.png" class="logo" height="120px">
      <p>Le Treizième Travail d'Hercule : Trouver un emploi.</p>
    </div>
      <div class=" col-12 col-lg-3">
        <h5 class="text-uppercase mb-4">Nous contacter</h5>
        <ul class="list-unstyled">
            <li class="mb-2">
              <a href="https://maps.app.goo.gl/qd5XGyCC3ew7SA596" target="_blank" class="text-white"><i class='bx bxs-map'></i>21 rue Erard, 75012 Paris</a>
            </li>
            <li class="mb-2">
              <a href="tel:0602081047" class="text-white"><i class='bx bxs-phone'></i>+33 6 02 08 10 47</a>
            </li>
            <li class="mb-2">
              <a href="mailto:contact@italent.com" class="text-white"><i class='bx bxs-mail'>contact@italent.site</i></a>
            </li>
          </ul>
        </div>


        <div class="col-12 col-lg-3">
        <h5 class="text-uppercase mb-4">Liens</h5>
        <ul class="list-unstyled">
            <li class="mb-2">
              <a href="connexion.php" class="text-white">Se connecter</a>
            </li>
            <li class="mb-2">
              <a href="inscription.php" class="text-white">S'enregistrer</a>
            </li>
            <li class="mb-2">
              <a href="#!" class="text-white">A propos de nous</a>
            </li>
          </ul>
    </div>

    <div class="col-12 col-lg-3">
        <h5 class="text-uppercase mb-4">Informations légales</h5>
        <ul class="list-unstyled">
            <li class="mb-2">
              <a href="#!" class="text-white">Mentions légales</a>
            </li>
            <li class="mb-2">
              <a href="#!" class="text-white">Conditions généraless</a>
            </li>
            <li class="mb-2">
              <a href="#!" class="text-white">Politique de confidentialité</a>
            </li>
            <li class="mb-2">
              <a href="#!" class="text-white">Utilisation des cookies</a>
            </li>
          </ul>
    </div>
  </div>


<?php 

if(isset($_GET["email"])) {
  if( !empty($_POST['email'])){
    if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
      header('location: ' . $url .'?messageFailure=Votre email est invalide :('); 
      exit;
  }
  $_SESSION['newsletter'] = 1;
  include 'phpmailer.php'; // Settings for phpmailer

  $email = htmlspecialchars($_POST['email']);
  //Recipients
  $mail->setFrom('italent.contact.site@gmail.com', 'Italent');
  $mail->addAddress($email); // Destinataire
  
  $body = '<p>Vous touchez au but ! Pour valider votre inscription à notre newsletter, 
  <a href="213.32.89.122/inscription_newsletter.php?news=1&email=' . $email . '&url=' . $url . '">cliquez ici</a></p>.'; // tru = condition pour la page d'inscription à la newsletter; 
                                                                                                                        //url=page sur laquelle il s'est inscrit pour le rediriger sur la meme page en cas de problemes

  //Attachments :
  $mail->addAttachment('../assets/LOGO_version_complète.png', "LOGO_version_complète.png");

  //Content
  $mail->isHTML(true);                                  //Set email format to HTML
  $mail->Subject = 'Inscription à la newsletter';
  $mail->Body    = $body;
  $mail->AltBody = strip_tags($body);

  try {
    $mail->send();
    echo'Un email viens de vous être envoyé !';

  } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      header("location: connexion.php");
  } 

  } //if(!empty($_POST['email'])) 
  
} // if(isset($_GET["email"])) {

?>







  <div class="row">
      <div class="col-8 offset-2 col-lg-4 offset-lg-4">
      <h5 class="text-uppercase mb-4">Newsletter</h5>

      <form action="" method="POST">
      <i class='bx bxs-envelope'></i>
      <input type="email" name="email" placeholder="Entrez votre e-mail" required>
      <button type="submit"><i class='bx bx-right-arrow-alt'></i></button>
    </form>
      </div>
  </div>
  </div>
  <hr>
  <p class="copyright">Tous droits réservés &copy 2024 - ITalent </p>

</footer>