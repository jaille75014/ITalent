<?php
session_start();
include("../includes/bd.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: ../connexion.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];

    $query = "UPDATE USERS SET firstname = ?, lastname = ?, email = ?, tel = ? WHERE user_id = ?";
    $res = $bdd->prepare($query);
    if ($res->execute([$firstname, $lastname, $email, $tel, $user_id])) {
        header('Location: ../profil.php');
    } else {
        header('Location: ../profil.php?messageFailure=');
    }
}
?>