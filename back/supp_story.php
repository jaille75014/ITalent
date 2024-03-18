<?php
session_start();
include("../includes/bd.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['story_id'])) {
    $story_id = $_GET['story_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $bdd->prepare("SELECT * FROM STORYS WHERE story_id = ? AND user_id = ?");
    $stmt->execute([$story_id, $user_id]);
    if ($stmt->rowCount() > 0) {
        $stmt = $bdd->prepare("DELETE FROM STORYS WHERE story_id = ?");
        if ($stmt->execute([$story_id])) {
            header('Location: profil.php?');
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