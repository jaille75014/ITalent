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
$title = 'CV';
$width = $pdf->GetStringWidth($title) + 6;
$pdf->SetX((210 - $width) / 2); // 210 pour A4
$pdf->Cell($width, 10, $title, 0, 1, 'C');
$pdf->Cell(59,10,'',0,1);

$pdf->SetFont('Helvetica','',12);
$pdf->Cell(71,5,'Adresse :',0,0);
$pdf->Cell(59,5,'',0,0);
$pdf->Cell(59,5,'Informations :',0,1);

$pdf->SetFont('Helvetica','',10);

if(empty($user_info)) {
    $pdf->Cell(0,10,'Informations de l\'utilisateur non disponibles',0,1);
} else {
    $user_info_first = $user_info[0];

    $pdf->Cell(130,5,'France, FR',0,0);
    $pdf->Cell(25,5,'Nom : ',0,0);
    $pdf->Cell(34,5,iconv('UTF-8', 'windows-1252', $user_info_first['lastname']),0,1);

    $pdf->Cell(130,5,iconv('UTF-8', 'windows-1252', $user_info_first['city']) . ', ' . $user_info_first['zip'],0,0);
    $pdf->Cell(25,5,iconv('UTF-8', 'windows-1252', 'Prénom').' : ',0,0);
    $pdf->Cell(34,5,iconv('UTF-8', 'windows-1252', $user_info_first['firstname']),0,1);

    $pdf->Cell(130,5,'',0,0);
    $pdf->Cell(25,5,'Email : ',0,0);
    $pdf->Cell(34,5,$user_info_first['email'],0,1);

    $pdf->Cell(130,5,'',0,0);
    $pdf->Cell(25,5,iconv('UTF-8', 'windows-1252', 'Téléphone').' : ',0,0);
    $pdf->Cell(34,5,$user_info_first['tel'],0,1);
}

$pdf->SetFont('Helvetica','B',15);
$pdf->Cell(130,5,iconv('UTF-8', 'windows-1252', 'Mes Compétences').' : ',0,0);
$pdf->Cell(59,5,'',0,0);
$pdf->SetFont('Helvetica','B',10);
$pdf->Cell(189,10,'',0,1);

$pdf->Cell(50,10,'',0,1);

$pdf->SetFont('Helvetica','B',10);

/* Titre du tableau */
$pdf->Cell(20,6,iconv('UTF-8', 'windows-1252', 'N°').' : ',1,0, 'C');
$pdf->Cell(80,6,iconv('UTF-8', 'windows-1252', 'Compétence').' : ',1,0, 'C');
$pdf->Cell(50,6,'Niveau',1,0, 'C');
$pdf->Cell(39,6,iconv('UTF-8', 'windows-1252', 'Validité').' : ',1,1, 'C');

/* Contenu du tableau */

$pdf->SetFont('Helvetica','',10);
if(empty($user_info)) {
    $pdf->Cell(0,10,'Aucunes compétences',0,1);
} else {
    $counter = 1;
    foreach ($user_info as $row) {
        $pdf->Cell(20,6,$counter++,1,0, 'C');
        $pdf->Cell(80,6,iconv('UTF-8', 'windows-1252', $row['competence_name']),1,0, 'C');
        $pdf->Cell(50,6,$row['level'],1,0, 'C');
        $pdf->Cell(39,6,$row['validity'],1,1, 'C');
    }
}


if(isset($_POST['signatureBase64']) && !empty($_POST['signatureBase64'])){
    
    $image = $_POST['signatureBase64'];
    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $imageDecode = base64_decode($image);

    $imageFileName = '../temp_image.png';

    file_put_contents($imageFileName, $imageDecode);

    // Obtenir les dimensions de la page
    $signatureWidth = 80; // Largeur signature
    $signatureHeight = 40; // Hauteur signature

    $signatureX = $pdf->GetPageWidth() - $signatureWidth - 20; // Position de départ de la signature à droite
    $signatureY = $pdf->GetPageHeight() - $signatureHeight - 30; // Marge en bas

    // tab pour la signauture
    $pdf->SetXY($signatureX, $signatureY - 10); // Position du tableau
    $pdf->Cell($signatureWidth, $signatureHeight + 20, '', 1, 1); // Créer le tableau

    // Ajouter le titre "Signature"
    $title = 'Signature';
    $titleWidth = $pdf->GetStringWidth($title); // Largeur du titre

    $pdf->SetTextColor(36, 130, 220); // Définir la couleur du texte en bleu
    $pdf->SetXY($signatureX + ($signatureWidth - $titleWidth) / 2, $signatureY - 10); // Centrer le titre dans le tableau
    $pdf->Cell($titleWidth, 10, $title, 0, 1, 'C'); // Ajouter le titre centré

    // Ajouter la signature
    $pdf->Image($imageFileName, $signatureX, $signatureY, $signatureWidth, $signatureHeight);

    unlink($imageFileName);
}


if(isset($_GET['reload']) && $_GET['reload'] == 1) {

    $q="SELECT nom FROM CV WHERE user_id=? ;";
    $req=$bdd->prepare($q);
    $req->execute([
        $user_id
    ]);
    $result=$req->fetch(PDO::FETCH_ASSOC);

    $filename = "../uploads/pdf/" . $result['nom'] . ".pdf";

    // Supprimer l'ancien fichier PDF
    if (file_exists($filename)) {
        unlink($filename);
    }
} else {
    $q2="SELECT firstname,lastname FROM USERS WHERE user_id=?;";
    $req2=$bdd->prepare($q2);
    $req2->execute([
        $user_id
    ]);
    $result2=$req2->fetch(PDO::FETCH_ASSOC);

    $salt='AHAHUTT4CHEH';
    $crypt=hash('sha256',$salt.$result2['firstname'].$result2['lastname'].$salt);

    $filename = "../uploads/pdf/" .$crypt. ".pdf";
    
    
    $q3="INSERT INTO CV (nom,user_id) VALUES(?,?)";
    $req3=$bdd->prepare($q3);
    $req3->execute([
        $crypt,
        $user_id
    ]);

}

$imagePath = '../assets/LOGO_version_minimalisé.png'; // Chemin de l'image
$imageWidth = 30; 
$imageHeight = 30; 

$imageX = 10; // Position X de l'image (10 pour une petite marge à gauche)
$imageY = $pdf->GetPageHeight() - $imageHeight - 10;

$pdf->Image($imagePath, $imageX, $imageY, $imageWidth, $imageHeight);

$pdf->Output('F', $filename);

$pdf->Output();

?>
