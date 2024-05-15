<?php 
session_start(); 
include('includes/header_location.php');
if(!isset($_SESSION['captcha'])){
    redirectFailure('captcha', 'Chipeur arrête de chipper !');
}
    

if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 1) {
    redirectFailure('index', 'Vous n\'avez pas les droits pour accéder à cette page.');
} 

if (!isset($_POST['competenceTest']) || $_SESSION['statut'] != 1) {
    redirectFailure('index', 'Vous n\'avez pas les droits pour accéder à cette page.');
} 

include('includes/bd.php'); // Connexion à la base de données

// Récupérer l'id de la compétencec choisi par l'utilisateur (sert pour la requête permettant de récupérer tte les questions)
$q='SELECT competence_id FROM COMPETENCES WHERE name=:name;';
$req=$bdd->prepare($q);
$req->execute([
    'name'=>$_POST['competenceTest']
]); 

$result=$req->fetch(PDO::FETCH_ASSOC);
foreach($result as $index=>$value){
    $competenceId=$value;
}

// Maintenant qu'on a l'id de la compétence, on peut récupérer l'ensemble des questions
$q2='SELECT question,answerCorrect,answer1,answer2,answer3,answer4 FROM QUESTIONS WHERE competence_id=:competence_id;';
$req2=$bdd->prepare($q2);
$req2->execute([
    'competence_id'=> $competenceId
]);
?>


<!DOCTYPE html>

<html>


<?php 
    include('includes/fonctions_logs.php');

    $title='Examen';
    $url = 'exam'; // Utilisé pour revenir sur cette page en cas d'erreurs dans les pages newsletter
    include('includes/head.php');

    writeVisitLog($url);
?>

    <body class="bg-light">
        
        
        <?php include('includes/header.php');?>

        <main>
            <div class="container">

                <h1 class="text-center">Examen de : <span class="text-primary"><?= $_POST['competenceTest']?></span></h1>
                <!-- <div class="time">
                <div class="circle">
                <div class="dots min_dot"></div>
                <svg>
                    <circle cx="70" cy="70" r="70"></circle>
                    <circle cx="70" cy="70" r="70" id="mm"></circle>
                </svg>
                <div class="minutes">00<span>Minutes</span></div>
                </div>
                </div>
            
                -->

                <form method="post" action="back/verif_exam">
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
