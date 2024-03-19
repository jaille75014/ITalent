<?php
session_start();
include("../includes/bd.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: ../connexion.php');
    exit;
}

if (isset($_GET['publi_id'])) {
    $publi_id = $_GET['publi_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $bdd->prepare("SELECT * FROM PUBLICATIONS WHERE publi_id = ? AND user_id = ?");
    $stmt->execute([$publi_id, $user_id]);
    if ($stmt->rowCount() > 0) {
        $stmt = $bdd->prepare("DELETE FROM PUBLICATIONS WHERE publi_id = ?");
        if ($stmt->execute([$publi_id])) {
            header('Location: ../profil.php?');
        } else {
            header('Location: ../profil.php');
        }
    } else {
        header('Location: ../profil.php');
    }
} else {
    header('Location: ../profil.php');
}
?>