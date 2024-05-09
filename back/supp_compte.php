<?php
session_start();
include("../includes/bd.php");
include("../includes/header_location.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: ../connexion');
    exit;
}

$user_id = $_SESSION['user_id'];
$insert_ban = 'INSERT INTO BAN (user_id, date_ban, reason) VALUES (:user_id, :date_ban, :reason)';
$res = $bdd->prepare($insert_ban);
$res->execute([
    ':user_id' => $user_id,
    ':date_ban' => date('Y-m-d H:i:s', strtotime('+30 days')),
    ':reason' => 'Suppression de compte'
]);
$res = $bdd->prepare("UPDATE USERS SET status = 0 WHERE user_id = ?"); 
if ($res->execute([$user_id])) {
    session_destroy();
    redirectSuccess("../index", "Votre compte a bien été supprimé ,vous disposez de 30 jours pour le réactiver.");
} else {
    redirectFailure("../profil", "Une erreur est survenue lors de la suppression de votre compte, veuillez réessayer.");
}
?>