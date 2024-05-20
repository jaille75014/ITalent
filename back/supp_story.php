<?php
session_start();
include("../includes/bd.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: ../connexion');
    exit;
}

if (isset($_GET['story_id'])) {
    $story_id = $_GET['story_id'];
    $user_id = $_SESSION['user_id'];

    $res = $bdd->prepare("SELECT story_id, image, expiration FROM STORYS WHERE story_id = ? AND user_id = ?");
    $res->execute([$story_id, $user_id]);
    if ($res->rowCount() > 0) {
        $res = $bdd->prepare("DELETE FROM STORYS WHERE story_id = ?");
        if ($res->execute([$story_id])) {
            header('Location: ../profil?');
        } else {
            header('Location: ../profil');
        }
    } else {
        header('Location: ../profil');
    }
} else {
    header('Location: ../profil');
}
?>