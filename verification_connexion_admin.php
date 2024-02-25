<?php 

if(!isset($_POST['email'])
    || empty($_POST['email'])
    || !isset($_POST['mot_de_passe'])
    || empty($_POST['mot_de_passe'])
){
    header('location: portail_admin.php?message=Vous devez remplir les deux champs !');
    exit;
}

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('location: portail_admin.php?message=Identifiants et/ou mot de passe incorrect');
    exit;
}

if(isset($_POST['email'])
    && $_POST['email'] == 'admin.italent@gmail.com'
    && isset ($_POST['password'])
    && $_POST ['password'] == 'admin'
) {
    header('location: admin.php?message=connected');
    exit;
}else {
    header('location: portal_admin.php?message=Identifiants inconnus');
    exit;
}

?>
