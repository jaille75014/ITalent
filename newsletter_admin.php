<?php 
session_start();
if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 3) {
    header('location:index.php');
    exit;
} 
include('includes/fonctions_logs.php');
writeVisitLog('captcha_admin.php');

?>
<!DOCTYPE html>
<html lang="fr">

<?php 
    $title='Gestion Newsletter';
    include('includes/head.php');
?>

<body class="bg-light">*

    <?php include('includes/header.php');?>

    <main class="container">
    <?php 
    if(isset($_GET['messageFailure'])){
    echo '<div class="alert alert-danger" role="alert">'.htmlspecialchars($_GET['messageFailure']).'</div>'; 
    }
    if(isset($_GET['messageSuccess'])){
        echo '<div class="alert alert-success" role="alert">'.htmlspecialchars($_GET['messageSuccess']).'</div>'; 
    }
    ?>
        <h1>Gestion de la newsletter</h1>

        <form action="back/edition_newsletter.php" method="POST" enctype="multipart/form-data">
            <h1>Envoyer un nouveau mail</h1>
            <div class="col-6">
            <input type="text" name="header" class="form-control form-control-lg rounded-0" placeholder="Tapez le titre du mail :">
            <input type="file" name="image" accept="image/jpeg, image/png, image/gif">
            </div>
            <div class="col-6">
                <span>Entrez le corps de votre e-mail :</span>
            <textarea name="body_newsletter" class="form-control form-control-lg rounded-0" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group my-4">
                <p>Cochez une des trois cases si vous souhaitez envoyer un mail qu'aux étudiants, recruteurs ou aux autres admins !</p><br>
                <input type="radio" class="btn-check" name="etudiant" autocomplete="off">
                <label class="btn btn-outline-success">Etudiants</label>
                <input type="radio" class="btn-check" name="recruteur" autocomplete="off">
                <label class="btn btn-outline-success">Recruteurs</label>
                <input type="radio" class="btn-check" name="Admin" autocomplete="off">
                <label class="btn btn-outline-success">Admins</label>
            </div>
            <input class="col-12" type="submit" value="Envoyer le mail"  class="btn btn-success btn-lg float-right my-1">
        </form>
    </main>
    <?php 
    include('includes/footer.php');
    ?>
</body>
</html>