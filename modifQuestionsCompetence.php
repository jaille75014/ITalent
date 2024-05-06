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
    && isset($_POST['answer1']) && !empty($_POST['answer1'])
    && isset($_POST['answer2']) && !empty($_POST['answer2'])
    && isset($_POST['answer3']) && !empty($_POST['answer3'])
    && isset($_POST['answer4']) && !empty($_POST['answer4'])
    && isset($_POST['answerCorrect']) && !empty($_POST['answerCorrect'])
    && isset($_POST['questionNew']) && !empty($_POST['questionNew'])){

        $q='UPDATE QUESTIONS SET question=:questionNew, answerCorrect= :answerCorrect ,answer1 = :answer1 ,answer2= :answer2,answer3 = :answer3 ,answer4 = :answer4 WHERE question= :question ;';
        $req=$bdd->prepare($q);
        $req->execute([
            "questionNew" =>htmlspecialchars($_POST['questionNew']),
            "answerCorrect" =>htmlspecialchars($_POST['answerCorrect']),
            "answer1" =>htmlspecialchars($_POST['answer1']),
            "answer2" =>htmlspecialchars($_POST['answer2']),
            "answer3" =>htmlspecialchars($_POST['answer3']),
            "answer4" =>htmlspecialchars($_POST['answer4']),
            "question" =>htmlspecialchars($_POST['question'])
        ]);

        header('location:competence_admin.php');
        exit;
}


if(!isset($_POST['question']) || empty($_POST['question'])){
    header('location:competence_admin');
    exit;
}

$q='SELECT question,answerCorrect,answer1,answer2,answer3,answer4 FROM QUESTIONS WHERE question=? ;';
$req=$bdd->prepare($q);
$req->execute([
    htmlspecialchars($_POST['question'])
]);

$result=$req->fetch(PDO::FETCH_ASSOC);

var_dump($result);

?>

<!DOCTYPE html>
<html>
    <?php 
    $title='Modification Question Compétence';
    $url = 'modifQuestionsCompetence'; //Permet de revenir sur cette page en cas d'erreurs dans les pages newsletter
    include('includes/head.php');
    writeVisitLog($url); 
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
                    <label class="form-label text-center" for="answer1">Réponse 1 : </label>
                    <input type="text" class="form-control mb-4" id="answer1" value="<?= $result['answer1']?>" name="answer1">
                    <label class="form-label" for="answer2">Réponse 2 : </label>
                    <input type="text" class="form-control mb-4" id="answer2" value="<?= $result['answer2']?>" name="answer2">
                    <label class="form-label" for="answer3">Réponse 3 : </label>
                    <input type="text" class="form-control mb-4" id="answer3" value="<?= $result['answer3']?>" name="answer3">
                    <label class="form-label" for="answer4">Réponse 4 : </label>
                    <input type="text" class="form-control mb-4" id="answer4" value="<?= $result['answer4']?>" name="answer4">

                    <label class="form-label" for="answerCorrect">Réponse Correct</label>
                    <input type="text" class="form-control mb-4" id="answerCorrect" value="<?= $result['answerCorrect']?>" name="answerCorrect">

                    <button type="submit" class="btn btn-success mb-5 text-center">Modifier</button>

                </form>
            </div>

        </main>

        <?php include('includes/footer.php');?>
    
    </body>
</html>