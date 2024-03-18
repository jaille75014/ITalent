<?php
session_start();
include('../includes/fonctions_logs.php');
include("../includes/bd.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["message_content"]) && isset($_POST["user_id_target"])) {
        $message_content = $_POST["message_content"];
        $user_id_target = $_POST["user_id_target"];

        $sql = "INSERT INTO message (content, date, user_id_target_id, user_id_source) VALUES (?, NOW(), ?, ?)";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$message_content, $user_id_target, $_SESSION['user_id']]);

        header("location: ../messagerie.php?user_id=$user_id_target");
        exit;
    } else {
        header("location: ../messagerie.php?message='Erreur'");
        exit;
    }
} else {
    header("location: ../messagerie.php?message='Erreur'");
    exit;
}
?>