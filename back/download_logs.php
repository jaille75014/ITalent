<?php
session_start();

include("../includes/header_location.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 3) {
    header('Location: index');
    exit;
}

$logs_directory = '../logs/';
$absolute_path = realpath($logs_directory);

// Vérifiez si le chemin absolu est valide
if ($absolute_path === false) {
    exit("Le chemin absolu du dossier logs est invalide.");
}

echo "Chemin absolu du dossier logs: $absolute_path";

$logs_directory = $absolute_path . '/';
$logs_files = glob($logs_directory . '*.txt'); 

// Affichez les fichiers trouvés pour le débogage
if (!empty($logs_files)) {
    echo "Fichiers de logs trouvés : ";
    foreach ($logs_files as $file) {
        echo basename($file);
    }
} else {
    redirectFailure("../admin_log", "Aucun fichier de log trouvé dans le dossier.");
}

if (!empty($logs_files)) {
    $zip = new ZipArchive(); // Créez une archive zip pour regrouper tous les fichiers de log
    $zip_name = 'logs.zip';
    if ($zip->open($zip_name, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
        foreach ($logs_files as $log_file) {
            $zip->addFile($log_file, basename($log_file));
        }
        $zip->close();

        if (file_exists($zip_name)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . basename($zip_name) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($zip_name));
            flush(); // Vider le tampon de sortie du système
            readfile($zip_name);
            unlink($zip_name); // Supprimez le fichier zip après le téléchargement
            exit;
        } else {
            redirectFailure("../admin_log", "Erreur lors de la création de l'archive ZIP.");
        }
    } else {
        redirectFailure("../admin_log", "Erreur lors de la création de l'archive ZIP.");
    }
} else {
    redirectFailure("../admin_log", "Aucun log disponible à télécharger.");
}
?>