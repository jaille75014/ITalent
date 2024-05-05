<?php

include('../includes/fpdf/fpdf.php');
include('../includes/bd.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    die("<p class='text-danger'>Vous devez être connecté pour accéder à cette page.</p>");
}

$user_id = $_SESSION['user_id'];

$query = "SELECT u.firstname, u.lastname, u.email, u.tel, u.zip, u.city, 
    c.name AS competence_name, 
    p.level, p.validity
    FROM USERS u 
    LEFT JOIN POSSESSES p ON u.user_id = p.user_id 
    LEFT JOIN COMPETENCES c ON p.competence_id = c.competence_id 
    WHERE u.user_id = :user_id";

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
$pdf->Cell(59,10,'',0,1);

$pdf->SetFont('Helvetica','B',12);
$pdf->Cell(71,5,'Adresse :',0,0);
$pdf->Cell(59,5,'',0,0);
$pdf->Cell(59,5,'Informations :',0,1);

$pdf->SetFont('Helvetica','',16);
$pdf->Cell(130,5,'France, FR',0,0);
$pdf->Cell(25,5,'Nom : ',0,0);
$pdf->Cell(34,5,$user_info['lastname'],0,1);

$pdf->Cell(130,5,$user_info['city'] . ', ' . $userInfo['zip'],0,0);
$pdf->Cell(25,5,'Prénom : ',0,0);
$pdf->Cell(34,5,$user_info['firstname'],0,1);

$pdf->Cell(130,5,'',0,0);
$pdf->Cell(25,5,'Email : ',0,0);
$pdf->Cell(34,5,$user_info['email'],0,1);

$pdf->Cell(130,5,'',0,0);
$pdf->Cell(25,5,'Téléphone : ',0,0);
$pdf->Cell(34,5,$user_info['tel'],0,1);


$pdf->SetFont('Helvetica','B',15);
$pdf->Cell(130,5,'Mes compétences',0,0);
$pdf->Cell(59,5,'',0,0);
$pdf->SetFont('Helvetica','B',10);
$pdf->Cell(189,10,'',0,1);

$pdf->Cell(50,10,'',0,1);

$pdf->SetFont('Helvetica','B',10);

/* Titre du tableau */
$pdf->Cell(20,6,'N°:',1,0, 'C');
$pdf->Cell(80,6,'Compétence',1,0, 'C');
$pdf->Cell(50,6,'Niveau',1,0, 'C');
$pdf->Cell(39,6,'Validité',1,1, 'C');

/* Contenu du tableau */

$pdf->SetFont('Helvetica','',10);
if(empty($user_info)) {
    $pdf->Cell(0,10,'Aucunes compétences',0,1);
} else {
    $counter = 1;
    foreach ($user_info as $row) {
        $pdf->Cell(20,6,$counter++,1,0, 'C');
        $pdf->Cell(80,6,$row['competence_name'],1,0, 'C');
        $pdf->Cell(50,6,$row['level'],1,0, 'C');
        $pdf->Cell(39,6,$row['validity'],1,1, 'C');
    }
}

$pdf->Output();
?> 