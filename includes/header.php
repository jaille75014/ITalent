<?php 
if (isset($_SESSION['user_id']) &&  $_SESSION['statut']==1) {
    $links = [
        "Accueil" => "etudiant",
        "Profil" => "profil",
        "Messages" => "messagerie",
        "Déconnexion" => "deconnexion"
    ];
}  else if (isset($_SESSION['user_id']) &&  $_SESSION['statut']==2) {
  $links = [
      "Accueil" => "index_recruteur",
      "Profil" => "profil",
      "Messages" => "messagerie",
      "Déconnexion" => "deconnexion"
  ];
} else if (isset($_SESSION['user_id']) &&  $_SESSION['statut']==3) {
  $links = [
      "Accueil" => "admin",
      "Profil" => "profil",
      "Captcha" => "captcha_admin",
      "Newsletter" => "newsletter_admin",
      "Compétence" => "competence_admin",
      "Débannissement" => "demandes",
      "Logs" => "admin_log",
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
    return '<li><a class="text-primary" href="' . $url . '">' . $name . '</a></li>';
}
?>


<header class="bg-light">
  
    <nav class="navbar1">
    

    
      <a href="index.php" class="logo"><img src="assets/LOGO_version_minimalisé.png" alt="Logo ITalent" height="70px" ></a>
      
      <div class="nav-links">

        <ul>
          <?php 
            foreach($links as $name => $url){
              echo writeNavLine($name, $url);
            }
          ?>
          <li><img src="assets/iconeDarkMode.svg" alt="Bouton pour activer / désactiver le mode sombre" id="darkMode" width="20px"></li>
          
        </ul>

      </div>

      <img src="assets/menu.png" alt="logo burger menu" class="burger-menu">
      

    

    </nav>
        
      
    
    
    

  <script src="js/header.js"></script>
</header>