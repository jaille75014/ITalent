<?php 
session_start();
include("includes/bd.php");
$req = 'SELECT date_ban, reason FROM BAN WHERE id = ' . $_SESSION['user_id'];
$res = $bdd->query($req);
if ($res->rowCount() > 0) {
    $row = $res->fetch(PDO::FETCH_ASSOC);
    $banDate = $row['date_ban'];
    $reason = $row['reason'];
} else {
    $banDate = "Supprimé";
    $reason = "Supprimé";
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title> Talent</title>
    <meta name="Description" content="ITalent, la révolution de la recherche d'emplois pour les étudiants en Informatique.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <!-- Ajout de la favicon -->
    <link rel="icon" type="image/png" href="assets/LOGO_icone.png">
    <!-- Intégration de la police d'écriture  -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <!-- Intégration de notre CSS -->
    <link type="text/css" rel="stylesheet" href="./css/style.css">
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous">
    </script>

</head>
    <body>
        <main>

        <div class="container_ban">
        <div class="form">
        <div class="contact-info">
            <?php 
            if($banDate == "Supprimé") {
                echo '<h3 class="title">Vous avez décidé de supprimer votre compte</h3>';
                echo '<p class="title">Si vous changez d\'avis, vous pouvez remplir ce formulaire pour récupérer votre compte</p>';
            } else {
                echo '<h3 class="title">Compte suspendu</h3>';
                echo '<p>Votre compte a été banni par un administrateur et sera définitivement supprimé le : ' . $banDate . 'Raison : ' . $reason . ' Vous pouvez contester ce ban en remplissant ce formulaire</p>';
            }
            ?>
          <div class="info">
            <div class="information">
              <img src="assets/location.png" class="icon" alt="" />
              <p>21 rue Erard, 75012 Paris</p>
            </div>
            <div class="information">
              <img src="assets/email.png" class="icon" alt="" />
              <p>italent.contact.site@gmail.com</p>
            </div>
            <div class="information">
              <img src="assets/phone.png" class="icon" alt="" />
              <p>+33 6 02 08 10 47</p>
            </div>
          </div>

          <div class="social-media">
            <p>Suivez nous</p>
            <div class="social-icons">
              <a href="#">
                <i class="fab fa-youtube"></i>
              </a>
              <a href="#">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </div>
        </div>

        <div class="contact-form">
          <span class="circle one"></span>
          <span class="circle two"></span>

          <form action="back/checkban" autocomplete="off" class="form_ban">
            <h3 class="title">Réclamations</h3>
            <div class="input-container">
              <input type="text" name="name" class="input" />
              <label for="">Prénom</label>
              <span>Prénom</span>
            </div>
            <div class="input-container">
              <input type="email" name="name" class="input" />
              <label for="">Nom</label>
              <span>Nom</span>
            </div>
            <div class="input-container">
              <input type="tel" name="email" class="input" />
              <label for="">Email</label>
              <span>Email</span>
            </div>
            <div class="input-container textarea">
              <textarea name="message" class="input"></textarea>
              <label for="">Message</label>
              <span>Message</span>
            </div>
            <input type="submit" value="Send" class="btn_ban" />
          </form>
        </div>
      </div>
    </div>

    <script src="js/script.js"></script>
  </body>
</html>