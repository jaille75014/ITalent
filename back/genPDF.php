<?php
include('../includes/fpdf/fpdf.php');
include('../includes/bd.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    die("<p class='text-danger'>Vous devez être connecté pour accéder à cette page.</p>");
}

$user_id = $_SESSION['user_id'];

$query = "SELECT u.firstname, u.lastname, u.email, u.tel, u.zip, u.city, c.name AS competence_name, c.level FROM USERS u LEFT JOIN COMPETENCES c ON u.user_id = c.user_id WHERE u.user_id = :user_id";

$user_info_q = $bdd->prepare($query);
$user_info_q->bindParam(':user_id', $user_id);
$user_info_q->execute();
$user_info = $user_info_q->fetchAll(PDO::FETCH_ASSOC);

// Créer le PDF
$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Helvetica','B',16);

$pdf->Cell(71,10,'',0,0);
$pdf->Cell(59,5,'CV',0,0);
$pdf->Cell(59,19,'',0,1);

$pdf->SetFont('Helvetica','',12);
$pdf->Cell(0,10,'Informations personnelles:',0,1);

// Afficher les informations de l'utilisateur
foreach ($user_info as $row) {
    $pdf->Cell(0,10,'Nom : '. $row['firstname'] .' ' . $row['lastname'],0,1);
    $pdf->Cell(0,10,'Email : '. $row['email'],0,1);
    $pdf->Cell(0,10,'Téléphone : '. $row['tel'],0,1);
    $pdf->Cell(0,10,'Adresse : '. $row['zip'].' ' . $row['city'],0,1);

    // Afficher les compétences de l'utilisateur
    $pdf->Cell(0,10,'Compétences:',0,1);
    if (!empty($row['competence_name'])) {
        $pdf->Cell(0,10, $row['competence_name'].' - Niveau: '. $row['level'],0,1);
    } else {
        $pdf->Cell(0,10,'Pas de compétences répertoriées.',0,1);
    }
}

$pdf->Output();
?>