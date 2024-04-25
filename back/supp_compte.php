<?php
session_start();
include("../includes/bd.php");

if (!isset($_SESSION['user_id'])) {
    header('Location: ../connexion');
    exit;
}

if(isset($_POST['delete_user']) && isset($_POST['user_id'])) {
        $id = $_POST['user_id'];
        
        $req_publications = $bdd->prepare('DELETE FROM PUBLICATIONS WHERE user_id = :id');
        $req_publications->execute(array(':id' => $id));
    
        $req_storys = $bdd->prepare('DELETE FROM STORYS WHERE user_id = :id');
        $req_storys->execute(array(':id' => $id));
    
        $req = $bdd->prepare('DELETE FROM USERS WHERE user_id = :id'); // Opter pour une modification du statut à 0 plutôt que la suppression
        $req->execute(array(':id' => $id));
    
        if(isset($_POST['raison_suppression'])) {
            $raison = $_POST['raison_suppression'];
            $log_file = '../logs/delete_user_log.txt';
            file_put_contents($log_file, "Utilisateur banni (ID: $id) - Raison: $raison\n", FILE_APPEND);
        }
    
        header('location: admin');
        exit;
    }

?>