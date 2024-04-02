<?php 
session_start();
if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 3) {
    header('location:index.php');
    exit;
} 
if(!isset($_SESSION['captcha'])){
    header('location:captcha.php?error=Chipeur arrête de chipper !');
    exit;
}
    

include('includes/fonctions_logs.php');
writeVisitLog('newsletter_admin.php');

?>
<!DOCTYPE html>
<html lang="fr">

<?php 
    $title='Gestion Newsletter';
    include('includes/head.php');
?>

<body class="bg-light">

    <?php include('includes/header.php');?>
    <link type="text/css" rel="stylesheet" href="css/style.css">

    <main class="container newsletter_h1">
    <?php 
    if(isset($_GET['messageFailure'])){
    echo '<div class="alert alert-danger" role="alert">'.htmlspecialchars($_GET['messageFailure']).'</div>'; 
    }
    if(isset($_GET['messageSuccess'])){
        echo '<div class="alert alert-success" role="alert">'.htmlspecialchars($_GET['messageSuccess']).'</div>'; 
    }
    ?>
        <h1 class="text-center">Gestion de la <span class="text-primary">Newsletter</span></h1>

        <form action="back/edition_newsletter.php" method="POST" enctype="multipart/form-data">
            <div class="row">
            <h1 class="col-12">Envoyer un nouveau mail</h1>
            </div>
            <div class="row">
            <div class="col-6 my-4">
            <input type="text" name="header" class="form-control form-control-lg rounded-0" placeholder="Tapez le titre du mail :">
            <input class="my-4" type="file" name="image" accept="image/jpeg, image/png, image/gif"><br>
            <span>Entrez le corps de votre e-mail :</span>
            <textarea name="body_newsletter" class="form-control form-control-lg rounded-0 my-4" cols="10" rows="5"></textarea>
            </div>
            
            <div class="form-group my-4 checkbox_newsletter col-6">
                <p>Cochez des cases si vous souhaitez envoyer un mail qu'aux étudiants, recruteurs ou aux autres admins ! Sinon ne cochez rien</p><br>
                <input type="checkbox" name="etudiant">
                <label>Etudiants</label>
                <input type="checkbox" name="recruteur">
                <label>Recruteurs</label>
                <input type="checkbox" name="Admin">
                <label >Admins</label>
                <input class="col-12 my-4 btn btn-success" type="submit" value="Envoyer le mail"  class="btn btn-success btn-lg float-right my-1">
            </div>
            </div>
            
        </form>
    </main>
    <?php 
    include('includes/footer.php');
    ?>
</body>
</html>