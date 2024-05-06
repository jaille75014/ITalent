<?php
session_start();
include('../includes/bd.php');
include('../includes/header_location.php');

if (!isset($_SESSION['user_id'])) {
    redirectFailure('../connexion', 'Vous devez être connecté pour accéder à cette page.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image_publication']) && isset($_POST['description'])) {
    $user_id = $_SESSION['user_id'];
    $description = htmlspecialchars($_POST['description']);

    if ($_FILES['image_publication']['error'] != 4) { 

        $acceptable = ['image/png', 'image/jpeg', 'image/gif'];
        if (!in_array($_FILES['image_publication']['type'], $acceptable)) {
            echo "Le fichier doit être un jpeg, png ou gif.";
            exit;
        }

        $maxSize = 2 * 1024 * 1024; // 2Mo
        if ($_FILES['image_publication']['size'] > $maxSize) {
            echo "Le fichier doit être inférieur à 2Mo!";
            exit;
        }

        $target_directory = "../uploads/publications/";
        if (!file_exists($target_directory)) {
            mkdir($target_directory, 0755, true);
        }

        $from = $_FILES['image_publication']['tmp_name'];
        $array = explode('.', $_FILES['image_publication']['name']);
        $ext = end($array); 
        $filename = 'publi-' . time() . '.' . $ext;
        $target_file = $target_directory . $filename;

        if (is_uploaded_file($from)) {
            if (is_writable($target_directory)) {
                if (move_uploaded_file($from, $target_file)) {
                    $stmt = $bdd->prepare("INSERT INTO PUBLICATIONS (image, description, user_id) VALUES (?, ?, ?)");
                    if ($stmt->execute([$filename, $description, $user_id])) {
                        header('Location: ../profil');
                        exit;
                    } else {
                        echo "Une erreur est survenue lors de l'ajout de la publication dans la base de données.";
                    }
                } else {
                    echo "Erreur lors du déplacement du fichier téléchargé.";
                }
            } else {
                echo "Le répertoire de destination n'est pas accessible en écriture.";
            }
        } else {
            if ($_FILES['file']['error'] === UPLOAD_ERR_NO_FILE) {
                echo "Aucun fichier sélectionné.";
            } else {
                echo "Erreur lors du téléchargement du fichier. Code d'erreur : " . $_FILES['file']['error'];
            }
        }
    } else {
        echo "Vous devez sélectionner une image.";
    }
} else {
    echo "Une erreur est survenue lors de la soumission du formulaire.";
}
?>