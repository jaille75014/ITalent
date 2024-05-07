<?php
session_start();
include("../includes/bd.php"); 
include('../includes/fonctions_logs.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['description']) && !empty($_FILES['image']['name'])) {
        $user_id = $_SESSION['user_id'];

        $description = $_POST['description'];
        
        $uploadDir = "../assets/"; 
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $stmt = $bdd->prepare("INSERT INTO PUBLICATIONS (image, description, user_id) VALUES (?, ?, ?)");
            $stmt->execute([$uploadFile, $description, $user_id]);
            
            header("location: ../etudiant");
            exit(); 
        } else {
            echo "Une erreur s'est produite lors de l'upload de l'image.";
        }
    } else {
        echo "Veuillez remplir tous les champs du formulaire.";
    }
} else {
    header("location: ../etudiant");
    exit(); 
}
?>