<?php
session_start();
include("../includes/bd.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: ../connexion.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $bdd->prepare("DELETE FROM PUBLICATIONS WHERE user_id = ?");
$stmt->execute([$user_id]);

$stmt = $bdd->prepare("DELETE FROM STORYS WHERE user_id = ?");
$stmt->execute([$user_id]);

$stmt = $bdd->prepare("DELETE FROM USERS WHERE user_id = ?");
if ($stmt->execute([$user_id])) {
    session_destroy();
    header('Location: ../login.php');
} else {
    header('Location: ../profil.php');
}
?>