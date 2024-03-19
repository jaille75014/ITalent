<?php
session_start();
include('../includes/bd.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$maxContentLength = 255;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message_content'], $_POST['user_id_target_id'])) {
    $user_id_target_id = $_POST['user_id_target_id'];
    $message_content = $_POST['message_content'];
    
    if (strlen($message_content) > $maxContentLength) {
        header('Location: ../messagerie.php?user_id=' . urlencode($user_id_target_id) . '&messageFailure=Message trop long&max_length=' . $maxContentLength);
        exit;
    }

    $user_id_source = $_SESSION['user_id'];
    
    // Nettoyer message > éviter injection XSS
    $message_content = htmlspecialchars($message_content);

    // Préparation de la requête d'insertion
    $stmt = $bdd->prepare("INSERT INTO message (content, user_id_target_id, user_id_source, date) VALUES (?, ?, ?, NOW())");
    
    if ($stmt->execute([$message_content, $user_id_target_id, $user_id_source])) {
        header('Location: ../messagerie.php?user_id=' . urlencode($user_id_target_id));
        exit;
    } else {
        echo "Une erreur est survenue lors de l'envoi du message.";
    }
} else {
    echo "Veuillez remplir tous les champs.";
}
?>