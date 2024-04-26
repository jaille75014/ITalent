<?php
session_start();
include("../includes/bd.php");
include("../includes/header_location.php");

if (!isset($_SESSION['user_id'])) {
    redirectFailure('../connexion', 'Vous devez être connecté pour accéder à cette page.');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tel = $_POST['tel'];
    $job = $_POST['job'];

    // Sélectionner l'ID du poste à partir de la table JOBS
    $query = "SELECT id FROM JOBS WHERE name = ?";
    $res = $bdd->prepare($query);
    $res->execute([$job]);
    $result = $res->fetch(PDO::FETCH_ASSOC);
    $job_id = $result['id'];

    // Vérification de l'envoie du mdp 
    $passwordReset = isset($_POST['password']) && !empty($_POST['password']);
    if($passwordReset) {
        if (strlen($_POST['password']) < 8) {
            header('location: edit.php?id=' . $_POST['user_id'] . '&message=Le mot de passe doit faire au moins 8 caractères !&type=danger');
            exit;
        }
    }

    // Mettre à jour la table USERS avec l'ID du poste
    $query = "UPDATE USERS SET firstname = ?, lastname = ?, email = ?, tel = ?, student_job = ? WHERE user_id = ?";
    $res = $bdd->prepare($query);
    if ($res->execute([$firstname, $lastname, $email, $tel, $job_id, $user_id])) {
        redirectSuccess('../profil', 'Vos informations ont été mises à jour.');
    } else {
        redirectFailure('../profil', 'Une erreur est survenue lors de la mise à jour de vos informations.');
    }


}
?>