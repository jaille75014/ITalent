<?php
session_start();

if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 3) {
    header('location:index');
    exit;
}

$log_file = '../logs/logs.txt';
if (file_exists($log_file)) {
    header('Content-Description: File Transfer'); // Description contenu --> Transfert de fichier 
    header('Content-Type: application/octet-stream'); // Fichier téléchargé sous forme binaire
    header('Content-Disposition: attachment; filename="'.basename($log_file).'"'); 
    header('Expires: 0'); // Eviter mise en cache
    header('Cache-Control: must-revalidate'); // Egige validation du chache avant de le réutiliser
    header('Pragma: public'); 
    header('Content-Length: ' . filesize($log_file)); // Taille du fichier pour téléchargement
    readfile($log_file);
    exit;
} else {
    echo "Aucun log disponible à télécharger.";
}
?>