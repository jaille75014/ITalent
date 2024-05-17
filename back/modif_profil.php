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
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tel = $_POST['tel'];
    $job = isset($_POST['job']) ? $_POST['job'] : null;


    // Vérification de l'envoie du mdp 
    $passwordReset = isset($_POST['password']) && !empty($_POST['password']);
    if($passwordReset) {
        if (strlen($_POST['password']) < 8) {
            header('location: ../profil?id=' . $_POST['user_id'] . '&messageFailure=Le mot de passe doit faire au moins 8 caractères !&type=danger');
            exit;
        } else {
            $salt = 'SANANESL3PLUSBEAUDUMONDEETDELESGIJEPENSEQUILA49ANS';
            $mdp_salt = $_POST['password'] . $salt;
            $password = hash('sha512', $mdp_salt);
        }
    }

    $query = "SELECT statut FROM USERS WHERE user_id = ?";
    $res = $bdd->prepare($query);
    $res->execute([$user_id]);
    $result = $res->fetch(PDO::FETCH_ASSOC);
    $status = $result['statut'];

    if($status != 3) {
    // Sélectionner l'ID du poste à partir de la table JOBS
    $query = "SELECT id FROM JOBS WHERE name = ?";
    $res = $bdd->prepare($query);
    $res->execute([$job]);
    $result = $res->fetch(PDO::FETCH_ASSOC);
    $job_id = $result['id'];

    // Mettre à jour la table USERS avec l'ID du poste
    $query = "UPDATE USERS SET firstname = ?, lastname = ?, email = ?, tel = ?, student_job = ?, password = ? WHERE user_id = ?";
    $res = $bdd->prepare($query);
    $res->execute([$firstname, $lastname, $email, $tel, $job_id, $password, $user_id]);
    } else { // Si l'utilisateur est un administrateur
        // Mettre à jour la table USERS sans modifier le champ student_job
    $query = "UPDATE USERS SET firstname = ?, lastname = ?, email = ?, tel = ?, password = ? WHERE user_id = ?";
    $res = $bdd->prepare($query);
    $res->execute([$firstname, $lastname, $email, $tel, $password, $user_id]);
    }

    if ($res->rowCount() > 0) {
        redirectSuccess('../profil', 'Vos informations ont été mises à jour.');
    } else {
        redirectFailure('../profil', 'Une erreur est survenue lors de la mise à jour de vos informations.');
    }
}
?>