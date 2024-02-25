<?php 

if (isset($_POST['email'])&& !empty($_POST['email'])){
    setcookie('email', $_POST['email'], time()+30*24*3600); // Cookie expire dans 30 jours
    
}

if(!isset($_POST['email'])
    || empty($_POST['email'])
    || !isset($_POST['password'])
    || empty($_POST['password'])
){
    header('location: connexion.php?message=Vous devez remplir les deux champs !');
    exit;
}

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('location: connexion.php?message=Identifiants et/ou mot de passe incorrect');
    exit;
}

if(isset($_POST['email'])
    && $_POST['email'] == 'admin.italent@gmail.com'
    && isset ($_POST['password'])
    && $_POST ['password'] == 'admin'
) {
    header('location: admin.php?message=Bonjour Admin ! ');
    exit;
}else {
    header('location: connexion.php?message=Identifiants inconnus');
    exit;
}

?>
