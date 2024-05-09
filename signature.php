<?php
session_start(); 
include('includes/header_location.php');
include('includes/bd.php'); 

if (!isset($_SESSION['user_id'])) {
    redirectFailure('connexion', 'Vous devez être connecté pour accéder à cette page.');
}


if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 1) {
    header('location:index');
    exit;
} 


if(!isset($_SESSION['captcha'])){
    header('location:captcha?error=Chipeur arrête de chipper !');
    exit;
}

?>


<!DOCTYPE html>
<html lang="fr">

<?php 
    include('includes/fonctions_logs.php');

    $title='Signature';
    $url = 'signature'; // Utilisé pour revenir sur cette page en cas d'erreurs dans les pages newsletter
    include('includes/head.php');

    writeVisitLog($url);
?>

<body class="bg-light">

    <?php include('includes/header.php');?>

    <main>
        <div class="container">

            
            <h3 class="text-center my-5" >Votre <span class="text-primary"> signature </span> : </h3>

            <div class="row justify-content-around">
                <div class="col-12 col-md-4">
                    <p>Veuillez signer le document qui sera généré, cela permettra d'attester votre accord à la diffusion de vos données personnelles à tout recruteur le désirant.</p>
                </div>
                <div class="col-12 col-md-4 ">
                    <canvas id="signatureCanva" width="400" height="200" class="bg-white"></canvas>
                    <form id="signatureFormulaire" action="back/genPDF<?=$_GET['reload']=='1'?'?reload=1':'' ;?>" method="post">
                        <input type="hidden" id="signatureBase64" name="signatureBase64">
                        <button class="btn btn-primary my-5" type="button" onclick="saveSignature()">Enregistrer</button>
                    </form>
                </div>
            </div>
            

        </div>

<script src="js/canva.js"></script>