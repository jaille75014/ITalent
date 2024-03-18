<?php
session_start();
include('../includes/bd.php'); 

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image_story'])) {
    $user_id = $_SESSION['user_id'];
    $image = $_FILES['image_story'];

    $target_directory = "../uploads/storys/";
    $target_file = $target_directory . basename($image["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(isset($_POST["submit"])) {
        $check = getimagesize($image["tmp_name"]);
        if($check !== false) {
            echo "Le fichier est une image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }
    }

    if (file_exists($target_file)) {
        echo "Le fichier existe déjà.";
        $uploadOk = 0;
    }

    if ($image["size"] > 2 * 1024 * 1024) {
        echo "Votre fichier est trop volumineux.";
        $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Votre fichier n'a pas été téléchargé.";
    } else {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            $stmt = $bdd->prepare("INSERT INTO STORYS (image, user_id, expiration) VALUES (?, ?, ADDDATE(NOW(), INTERVAL 1 DAY))");
            if($stmt->execute([basename($image["name"]), $user_id])){
                echo "L'histoire a été ajoutée avec succès.";
                header('Location: ../profil.php');
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