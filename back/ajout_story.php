<?php
session_start();
include('../includes/bd.php');
include('../includes/header_location.php');

if (!isset($_SESSION['user_id'])) {
    redirectFailure('../connexion', 'Vous devez être connecté pour accéder à cette page.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image_story'])) {
    $user_id = $_SESSION['user_id'];
    $image = $_FILES['image_story'];

    $target_directory = "../uploads/storys/";
    if (!file_exists($target_directory)) {
        mkdir($target_directory, 0755, true);
    }

    $filename = time() . basename($image["name"]); 
    $target_file = $target_directory . $filename;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($image["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "Le fichier n'est pas une image.";
        $uploadOk = 0;
    }

    if ($image["size"] > 2 * 1024 * 1024) { 
        echo "Le fichier est trop volumineux.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Votre fichier n'a pas été téléchargé.";
        exit; 
    } else {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            $stmt = $bdd->prepare("INSERT INTO STORYS (image, user_id, expiration) VALUES (?, ?, ADDDATE(NOW(), INTERVAL 1 DAY))");
            if ($stmt->execute([$filename, $user_id])) { 
                header('Location: ../profil');
                exit; 
            } else {
                echo "Erreur lors de l'ajout dans la base de données.";
            }
        } else {
            echo "Erreur lors du téléchargement de votre fichier.";
        }
    }
} else {
    echo "Aucun fichier ou formulaire invalide.";
}
?>