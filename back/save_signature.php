<?php
// Vérifier si des données ont été reçues
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données de l'image base64 depuis la requête POST
    $imageData = $_POST['signatureData'];

    // Convertir les données de l'image base64 en fichier image et enregistrer sur le serveur
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);
    $imageData = base64_decode($imageData);

    // Chemin de sauvegarde du fichier image sur le serveur
    $filePath =  uniqid() . '.png';

    // Enregistrer le fichier image sur le serveur
    if (file_put_contents($filePath, $imageData)) {
        // Indiquer que l'enregistrement a réussi
        echo 'Signature enregistrée avec succès !';
    } else {
        // Indiquer qu'il y a eu une erreur lors de l'enregistrement
        echo 'Erreur lors de l\'enregistrement de la signature.';
    }
} else {
    // Si la requête n'est pas de type POST, renvoyer une erreur "Method Not Allowed"
    http_response_code(405);
}
?>
