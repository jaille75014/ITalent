<?php 
session_start(); 

    

if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 3) {
    header('location:index.php');
    exit;
} 
include('includes/fonctions_logs.php');
writeVisitLog('captcha_admin.php');

include('includes/bd.php'); // Connexion à la base de données

// AJOUT DE QUESTIONS

if(isset($_POST['question']) && !empty($_POST['question']) &&
isset($_POST['answer'])&& !empty($_POST['answer']) ){
    
    $q='INSERT INTO captcha (question,answer,user_id) VALUES (:question,:answer,:user_id);';
    $req=$bdd->prepare($q);
    $result=$req->execute([
        'question'=> $_POST['question'],
        'answer'=> $_POST['answer'],
        'user_id'=> $_SESSION['user_id']
        ]);  


    header('location:captcha_admin.php');
    exit;
} 


?>

<!DOCTYPE html>
<html lang="fr">

<?php 
    $title='Gestion Captcha';
    include('includes/head.php');
?>

<body class="bg-light">

    <?php include('includes/header.php');?>

    <main>
        <div class="container">

        
            <h1 class="text-center">Gestion du système de <span class="text-primary">Captcha</span></h1>

            <div class="row my-5">
                <div class="col-12 col-md-6">
                    <h2 class="text-center">Ajouter des questions</h2>

                </div>

                <div class="col-12 col-md-6">
                    <form method="post" >
                        <input type="text" name="question" placeholder="Entrer une question" class="form-control mb-4">
                        <input type="text" name="answer"placeholder="Entrer la réponse attendue" class="form-control mb-4">
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>

            

        </div>
    </main>

    <?php include('includes/footer.php');?>
</body>
</html>