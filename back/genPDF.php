<?php
session_start();
include('../includes/bd.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login');
    exit;
}


use Dompdf\Dompdf;
use Dompdf\Options;

include('../includes/bd.php');

$sql = 'SELECT lastname, firstname FROM users';
$query = $bdd->prepare($sql);
$users =   $query->fetchAll(PDO::FETCH_ASSOC);

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

$fichier = 'CV.pdf';


$dompdf->stream($fichier);

?>