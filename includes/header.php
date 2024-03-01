<?php 
if (isset($_SESSION['email']) &&  $_SESSION['statut']==1) {
    $links = [
        "Accueil" => "index_etudiant.php",
        "Profil" => "profil.php",
        "Entretien" => "entretien.php",
        "Messages" => "messages.php",
        "Deconnexion" => "deconnexion.php"
    ];
}  else if (isset($_SESSION['email']) &&  $_SESSION['statut']==2) {
  $links = [
      "Accueil" => "index_recruteur.php",
      "Profil" => "profil.php",
      "Entretien" => "entretien.php",
      "Messages" => "messages.php",
      "Deconnexion" => "deconnexion.php"
  ];
} else if (isset($_SESSION['email']) &&  $_SESSION['statut']==3) {
  $links = [
      "Accueil" => "index_admin.php",
      "Recherche" => "recherche.php",
      "Base de données" => "bdd.php",
      "Deconnexion" => "deconnexion.php"
  ];
} else {
    $links = [
        "Accueil" => "index.php", 
        "Connexion" => "connexion.php",
        "Inscription" => "inscription.php",
    ];
}


function writeNavLine($name, $url){
    return '<li class="nav-item">' . '<a class="nav-link text-primary" href="' . $url . '">' . $name . '</a>' . '</li>';
}
?>


<header>
  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container">

      <a class="nav-link" href="index.php"><img alt="Logo ITalent" height="90px" src="assets/LOGO_version_minimalisé.png"></a>
      <div class="justify-content-end" id="navbarNav">

        <ul class="navbar-nav">
          <?php 
          foreach($links as $name => $url){
              echo writeNavLine($name, $url);
          }
          ?>
        </ul> 

      </div>

    </div>
  </nav>
</header>