<?php
session_start();

if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 3) {
    header('location:index');
    exit;
}

$logs_directory = '../logs'; // Chemin vers le dossier contenant les logs

$logs_files = glob($logs_directory . '/*.txt'); // Vérifiez si un fichier de log existe dans le dossier
if (!empty($logs_files)) {
    $zip = new ZipArchive(); // Créez une archive zip pour regrouper tous les fichiers de log
    $zip_name = 'logs.zip';
    if ($zip->open($zip_name, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
        foreach ($logs_files as $log_file) {
            $zip->addFile($log_file, basename($log_file));
        }
        $zip->close();

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $zip_name . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($zip_name));
        readfile($zip_name);
        unlink($zip_name); // Supprimez le fichier zip après le téléchargement
        exit;
    } else {
        echo "Erreur lors de la création de l'archive ZIP.";
    }
} else {
    echo "Aucun log disponible à télécharger.";
}
?>