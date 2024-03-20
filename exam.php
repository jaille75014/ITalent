<?php 
session_start(); 
if(!isset($_SESSION['captcha'])){
    header('location:captcha.php?error=Chipeur arrête de chipper !');
    exit;
}
    

if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 1) {
    header('location:index.php');
    exit;
} 

if (!isset($_POST['competenceTest']) || $_SESSION['statut'] != 1) {
    header('location:profil.php');
    exit;
} 

include('includes/fonctions_logs.php');
writeVisitLog('captcha_admin.php');

include('includes/bd.php'); // Connexion à la base de données

// Récupérer l'id de la compétencec choisi par l'utilisateur (sert pour la requête permettant de récupérer tte les questions)
$q='SELECT competence_id FROM competences WHERE name=:name;';
$req=$bdd->prepare($q);
$req->execute([
    'name'=>$_POST['competenceTest']
]); 

$result=$req->fetch(PDO::FETCH_ASSOC);
foreach($result as $index=>$value){
    $competenceId=$value;
}

// Maintenant qu'on a l'id de la compétence, on peut récupérer l'ensemble des questions
$q2='SELECT question,answerCorrect,answer1,answer2,answer3,answer4 FROM questions WHERE competence_id=:competence_id;';
$req2=$bdd->prepare($q2);
$req2->execute([
    'competence_id'=> $competenceId
]);

$url = 'exam.php'; //Permet de revenir sur cette page en cas d'erreurs dans les pages newsletter


?>


<!DOCTYPE html>

<html>


<?php 
$title='Examen';
include('includes/head.php');?>

    <body class="bg-light">
        
        
        <?php include('includes/header.php');?>

        <main>
            <div class="container">

                <h1 class="text-center">Examen de : <span class="text-primary"><?= $_POST['competenceTest']?></span></h1>

                <form method="post" action="back/verif_exam.php">
                <?php 
                $numberQuestion=1;

                while($result2=$req2->fetch(PDO::FETCH_ASSOC)){
                    
                    foreach($result2 as $index2=>$value2){
                        if($index2=='question'){
                            echo '
                            <label class="form-label mt-4" for="answer">'.$value2.'</label>
                            <select id="answer" name="answer'.$numberQuestion.'" class="form-select mb-4" >
                            <option selected>Sélectionnez la bonne réponse </option>';
                        } else if ($index2=='answerCorrect')  {
                            $correct=$value2;
                        }else {
                            echo '<option value="'. $value2 .'">'. $value2.'</option>';
                        }
                        
                                    
                    }
                    echo '</select>
                    <input type="hidden" name="answer'.$numberQuestion.'Correct" value="'.$correct.'">';
                    $numberQuestion++;
                }
                ?>
                <input type="hidden" value="<?=$_POST['competenceTest']?>" name="competenceTest" >
                <button class="btn btn-primary mb-5">Soumettre</button>
                </form>

            </div>
        </main>
        <?php include('includes/footer.php');?>
    </body>
</html>
