<?php
session_start();

if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 3) {
    header('location:index');
    exit;
}

$apache_error_log_file = '/var/log/apache2/error.log';

if (file_exists($apache_error_log_file)) {
    header('Content-Description: File Transfer'); // Description contenu --> Transfert de fichier 
    header('Content-Type: application/octet-stream'); // Fichier téléchargé sous forme binaire
    header('Content-Disposition: attachment; filename="error.log"'); // Nom du fichier pour téléchargement
    header('Expires: 0'); // Eviter mise en cache
    header('Cache-Control: must-revalidate'); // Egige validation du chache avant de le réutiliser
    header('Pragma: public'); 
    header('Content-Length: ' . filesize($apache_error_log_file)); // Taille du fichier pour téléchargement
    readfile($apache_error_log_file);
    exit;
} else {
    echo "Aucun log d'erreur Apache disponible à télécharger.";
}
?>