<?php
include("../includes/header_location.php");
// Vérifier si les champs sont présents et non vides
if (!isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['password']) || empty($_POST['password'])) {
    header('location: ../connexion?messageFailure=Veuillez remplir les deux champs !');
    exit;
}

// Vérifier si l'email est valide
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('location: ../connexion?messageFailure=Email invalide');
    exit;
}

// Connexion à la base de données
include("../includes/bd.php");

// Salage du mot de passe
$salt = 'SANANESL3PLUSBEAUDUMONDEETDELESGIJEPENSEQUILA49ANS';
$mdp_salt = $_POST['password'] . $salt;

// Hashage du mot de passe
$password = hash('sha512', $mdp_salt);

// Requête pour vérifier les identifiants dans la base de données
$req = $bdd->prepare('SELECT user_id, statut FROM USERS WHERE email = :email AND password = :password');
$req->execute([
    'email' => $_POST['email'],
    'password' => $password
]);
$result = $req->fetch(PDO::FETCH_ASSOC);

// Inclure le fichier de fonctions de log
include("../includes/fonctions_logs.php");

// Enregistrement de la tentative de connexion dans les logs
if (empty($result['user_id'])) {
    writeLogLine(false, $_POST['email']);
    header('location: ../connexion?messageFailure=Identifiants ou mot de passe incorrects');
    exit;
} else {
    writeLogLine(true, $_POST['email']);
}

// Vérification de l'état de l'email
$req = $bdd->prepare('SELECT email_check FROM USERS WHERE email = :email');
$req->execute([
    'email' => $_POST['email']
]);
$email_check_result = $req->fetch(PDO::FETCH_ASSOC);
foreach ($email_check_result as $index => $values) {
    if ($values != 1) {
        // L'email n'est pas vérifié > rediriger vers le formulaire de connexion avec un message d'erreur
        header('location: ../connexion?messageFailure=Votre email n\'a pas été vérifié. Veuillez consulter vos emails pour confirmer votre adresse.');
        exit;
    }  
}



// La connexion a réussi > démarrer la session
session_start();
$_SESSION['user_id'] = $result['user_id'];
$_SESSION['statut'] = $result['statut'];
if($result['statut'] == 0){
    redirectFailure('../ban', 'Banned&id=' . $_SESSION['user_id']);
}



// Redirection vers la page appropriée selon le statut de l'utilisateur


if(isset($_SESSION['statut'])){
    header('location: ../captcha?messageSuccess=Connexion réussie, veuillez répondre au captcha suivant.');
    exit;
} else {
    // En cas d'erreur de statut, déconnecter l'utilisateur et rediriger vers la page de connexion
    session_destroy();
    header('location: ../connexion?messageFailure=Erreur lors de la connexion');
    exit;
}


?>