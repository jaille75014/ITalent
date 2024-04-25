<?php 
session_start(); 


if(!isset($_SESSION['captcha'])){
    header('location:captcha?error=Chipeur arrête de chipper !');
    exit;
}
    

if (!isset($_SESSION['statut'])) {
    header('location:index');
    exit;
} 

include('includes/bd.php'); // Connexion à la base de données

include('includes/fonctions_logs.php');
writeVisitLog('competence_admin');

if (isset($_POST['question']) && !empty($_POST['question'])
    && isset($_POST['answer']) && !empty($_POST['answer'])
    && isset($_POST['questionNew']) && !empty($_POST['questionNew'])){

        $q='UPDATE CAPTCHA SET question=:questionNew, answer= :answer  WHERE question= :question ;';
        $req=$bdd->prepare($q);
        $req->execute([
            "answer" =>htmlspecialchars($_POST['answer']),
            "question" =>htmlspecialchars($_POST['question']),
            "questionNew" =>htmlspecialchars($_POST['questionNew'])
        ]);

        header('location:captcha_admin.php');
        exit;
}


if(!isset($_POST['question']) || empty($_POST['question'])){
    header('location:competence_admin');
    exit;
}

$q='SELECT question,answer FROM CAPTCHA WHERE question=? ;';
$req=$bdd->prepare($q);
$req->execute([
    htmlspecialchars($_POST['question'])
]);

$result=$req->fetch(PDO::FETCH_ASSOC);




?>

<!DOCTYPE html>
<html>
    <?php 
    $title='Modification Question Captcha';
    $url = 'modifQuestionsCompetence'; //Permet de revenir sur cette page en cas d'erreurs dans les pages newsletter
    include('includes/head.php');
    ?>

    <body class="bg-light">

        <?php include('includes/header.php');?>

        <main>

            <div class="container">

                <h1 class="text-center">Modification des <span class="text-primary">Questions</span></h1>

                <h3 class="text-center my-5"><?= $result['question'];?></h3>
                
                <form method="post">

                    <input type="hidden" value="<?= $result['question'];?>" name="question">

                    <label class="form-label text-center" for="questionNew">Question :</label>
                    <input type="text" class="form-control mb-4" id="questionNew" value="<?= $result['question']?>" name="questionNew">
                    <label class="form-label text-center" for="answer">Réponse :</label>
                    <input type="text" class="form-control mb-4" id="answer" value="<?= $result['answer']?>" name="answer">

                    <button type="submit" class="btn btn-success mb-5 text-center">Modifier</button>

                </form>
            </div>

        </main>

        <?php include('includes/footer.php');?>
    
    </body>
