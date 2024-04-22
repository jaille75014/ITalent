<?php 
if (isset($_SESSION['user_id']) &&  $_SESSION['statut']==1) {
    $links = [
        "Accueil" => "index_etudiant",
        "Profil" => "profil",
        "Entretien" => "entretien",
        "Messages" => "messagerie",
        "Déconnexion" => "deconnexion"
    ];
}  else if (isset($_SESSION['user_id']) &&  $_SESSION['statut']==2) {
  $links = [
      "Accueil" => "index_recruteur",
      "Profil" => "profil",
      "Entretien" => "entretien",
      "Messages" => "messagerie",
      "Déconnexion" => "deconnexion"
  ];
} else if (isset($_SESSION['user_id']) &&  $_SESSION['statut']==3) {
  $links = [
      "Accueil" => "admin",
      "Captcha" => "captcha_admin",
      "Newsletter" => "newsletter_admin",
      "Compétence" => "competence_admin",
      "Déconnexion" => "deconnexion"
  ];
} else {
    $links = [
        "Accueil" => "index", 
        "Connexion" => "connexion",
        "Inscription" => "inscription"
    ];
}


function writeNavLine($name, $url){
    return '<li class="nav-item">' . '<a class="nav-link text-primary" href="' . $url . '">' . $name . '</a>' . '</li>';
}
?>


<header class="bg-light">
  
    <div class="container">

      <a href="index"><img alt="Logo ITalent" height="90px" src="assets/LOGO_version_minimalisé.png"></a>
      <nav class="bg-light" id="nav">
        <ul>
          <?php 
          foreach($links as $name => $url){
              echo writeNavLine($name, $url);
          }
          ?>
        </ul>
      </nav>
      
    </div>

    <button class="nav-toggler" id="toggler" aria-label="toggler navigation menu" type="button">
      <span class="line l1"></span>
      <span class="line l2"></span>
      <span class="line l3"></span>
    </button>
    
    

  <script src="js/header.js"></script>
</header>