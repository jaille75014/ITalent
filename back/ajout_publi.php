<?php
session_start();
include('../includes/bd.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image_publication']) && isset($_POST['description'])) {
    $user_id = $_SESSION['user_id'];
    $description = htmlspecialchars($_POST['description']);
    $image = $_FILES['image_publication'];

    $target_directory = "../uploads/publications/";
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
        echo "Fichier est trop volumineux.";
        $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Votre fichier n'a pas été téléchargé.";
        exit; 
    } else {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            $stmt = $bdd->prepare("INSERT INTO PUBLICATIONS (image, description, user_id) VALUES (?, ?, ?)");
            if ($stmt->execute([$filename, $description, $user_id])) { 
                header('Location: ../profil.php');
                exit;
            } else {
                echo "Une erreur est survenue lors de l'ajout de la publication dans la base de données.";
            }
        } else {
            echo "Erreur lors du téléchargement de votre fichier.";
        }
    }
} else {
    echo "Aucun fichier sélectionné ou formulaire invalide.";
}
?>