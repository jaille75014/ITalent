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

$res = $bdd->prepare("DELETE FROM USERS WHERE user_id = ?");
if ($res->execute([$user_id])) {
    session_destroy();
    header('Location: ../login.php');
} else {
    header('Location: ../profil.php');
}
?>