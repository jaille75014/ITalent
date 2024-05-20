<?php
session_start();
include("../includes/bd.php"); 
include('../includes/fonctions_logs.php');
include("../includes/header_location.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_FILES); 
    var_dump($_POST); 

    if (!empty($_FILES['image']['name']) && isset($_POST['description']) && !empty($_POST['description'])) {
        $user_id = $_SESSION['user_id'];
        $description = $_POST['description'];
        
        $acceptable = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['image']['type'], $acceptable)) {
            redirectFailure("../etudiant", "Le fichier doit être un jpeg, png ou gif.");
        }

        $maxSize = 1024 * 1024 * 5; 
        if ($_FILES['image']['size'] > $maxSize) {
            redirectFailure("../etudiant", "Le fichier doit peser moins de 2Mo.");
        }

        $uploadDir = "../uploads/publications/";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $array = explode('.', $_FILES['image']['name']);
        $ext = end($array);
        $filename = 'image-' . time() . '.' . $ext;

        $uploadFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $stmt = $bdd->prepare("INSERT INTO PUBLICATIONS (image, description, user_id) VALUES (?, ?, ?)");
            $stmt->execute([$uploadFile, $description, $user_id]);
            
            redirectSuccess("../etudiant", "Votre publication a bien été ajoutée.");
        } else {
            redirectFailure("../etudiant", "Une erreur s'est produite lors de l'upload de l'image.");
        }
    } else {
        redirectFailure("../etudiant", "Veuillez remplir tous les champs du formulaire.");
    }
} else {
    header("location: ../etudiant");
    exit(); 
}
?>