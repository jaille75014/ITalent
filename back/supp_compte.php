<?php
session_start();
include("../includes/bd.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: ../connexion');
    exit;
}

if (isset($_POST['ban_user'])) {
    $userId = $_POST['user_id'];
    $raison = $_POST['raison_suppression'];
        $req_publications = $bdd->prepare('DELETE FROM PUBLICATIONS WHERE user_id = :id');
        $req_publications->execute(array(':id' => $id));
    
        $req_storys = $bdd->prepare('DELETE FROM STORYS WHERE user_id = :id');
        $req_storys->execute(array(':id' => $id));
    
        $req = $bdd->prepare('DELETE FROM USERS WHERE user_id = :id'); // Opter pour une modification du statut à 0 plutôt que la suppression
        $req->execute(array(':id' => $id));
    
        $logMessage = "L'utilisateur avec l'ID $userId a été banni pour la raison suivante : $raison\n";
        file_put_contents('../logs/ban.txt', $logMessage, FILE_APPEND);
    
        header('location: admin');
        exit;
    }

?>