<?php 

if (isset($_POST['email'])&& !empty($_POST['email'])){
    setcookie('email', $_POST['email'], time()+30*24*3600); // Cookie expire dans 30 jours
    
}

// Vérifier si les 2 champs sont remplis
if(!isset($_POST['email'])
    || empty($_POST['email'])
    || !isset($_POST['password'])
    || empty($_POST['password'])
){
    header('location: connexion.php?message=Vous devez remplir les deux champs !');
    exit;
}

// Vérifier si l'email est valide
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('location: connexion.php?message=Email invalide');
    exit;
}

// Vérifier si c'est un compte admin
if(isset($_POST['email'])
    && $_POST['email'] == 'admin.italent@gmail.com'
    && isset ($_POST['password'])
    && $_POST ['password'] == 'admin'
) {
    header('location: admin.php?message=Bonjour Admin ! ');
    exit;
}

// Connexion à la DB
include("includes/bd.php");

// Requête pour vérifier les identifiants dans la BD
$email = $_POST['email'];
// Salage du mot de passe 
$salt = 'SANANESL3PLUSBEAUDUMONDEETDELESGIJEPENSEQUILA49ANS';
$mdp_salt = $_POST['password'] . $salt;


// Hashage du mot de passe
$password = hash('sha512', $mdp_salt); 
$req = $bdd->prepare('SELECT id FROM users WHERE email = :email AND password = :password');
$req->execute([
    'email'=>$_POST['email'], 
    'password'=>$password
]
);
$result = $req->fetchAll();

if (empty($result)) {
    // Les identifiants sont incorrects > enregistrons la tentative dans le log et redirigeons vers le formulaire avec un message d'erreur
    writeLogLine(false, $_POST['email']);
    header('location: connexion.php?message=Identifiants incorrects'); 
    exit;
} 


// Ouverture ou création d'une session utilisateur
session_start();
$_SESSION['email'] = $email; // Ajout d'une clé email et d'une valeur

header('location: index.php');
exit;

// Fonction qui écrit une ligne dans le fichier log.txt
function writeLogLine($success, $email){
    // Ouverture du flux log.txt
    $log = fopen($success ? 'log_reussies.txt' : 'log_echouées.txt', 'a+');

    // Création de la ligne à ajouter
    // AAAA/mm/jj - h/m/s - tentative de connexion échoué de email
    $line = date("Y/m/d - H:i:s") . '- Tentative de connexion ' . ($success ? 'réussie' : 'échouée') . ' de : ' . $email . "\r";

    // Ajouter la ligne au flux ouvert
    fputs($log,$line);

    // Fermeture du flux
    fclose($log);
}

?>
