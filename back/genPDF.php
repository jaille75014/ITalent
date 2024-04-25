<?php
session_start();
include('../includes/bd.php');

if (!isset($_SESSION['user_id'])) {
    redirectFailure('connexion', 'Vous devez être connecté pour accéder à cette page.');
}

$title='genPDF';
$url = 'genPDF';
include('../includes/head.php');

use Dompdf\Dompdf;
use Dompdf\Options;

include('../includes/bd.php');

$sql = 'SELECT lastname, firstname FROM users';
$query = $bdd->prepare($sql);
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);

ob_start(); // Buffer de mémoire pour stocker le contenu HTML
include('pdfContent.php');
$html = ob_get_contents(); // Stocke le contenu du buffer dans une variable
ob_end_clean(); // Nettoie le buffer

include('../includes/dompdf/autoload.inc.php');

$options = new Options();
$options->set('defaultFont', 'Montserrat');

$dompdf = new Dompdf(); 
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Enregistrer le PDF dans un fichier
$output = $dompdf->output();
$file_path = 'CV.pdf';
file_put_contents($file_path, $output);

// Proposer le téléchargement du PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $file_path . '"');
readfile($file_path);
exit;
?>