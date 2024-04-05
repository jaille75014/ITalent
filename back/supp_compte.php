<?php
session_start();
include("../includes/bd.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$res = $bdd->prepare("DELETE FROM PUBLICATIONS WHERE user_id = ?");
$res->execute([$user_id]);

$res = $bdd->prepare("DELETE FROM STORYS WHERE user_id = ?");
$res->execute([$user_id]);

$res = $bdd->prepare("DELETE FROM USERS WHERE user_id = ?"); // Opter pour une modification du statut à 0 plutôt que la suppression
if ($res->execute([$user_id])) {
    session_destroy();
    header('Location: ../login.php');
} else {
    header('Location: ../profil.php');
}
?>