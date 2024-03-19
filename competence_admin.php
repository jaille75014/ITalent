<?php 
session_start(); 

    

if (!isset($_SESSION['statut'])) {
    header('location:index.php');
    exit;
} 

include('includes/fonctions_logs.php');
writeVisitLog('captcha.php');

include('includes/bd.php'); // Connexion à la base de données
    
// AJOUT DE COMPÉTENCES

if(isset($_POST['addCompetence'])&& !empty($_POST['addCompetence'])){
    $q='INSERT INTO competences (name) VALUES (:name);';
    $req=$bdd->prepare($q);
    $req->execute([
        'name'=>$_POST['addCompetence']
    ]);
}

// TABLEAU DES COMPÉTENCES

$q='SELECT competence_id,name FROM competences ;';
$req2=$bdd->prepare($q);
$req2->execute();  
$result3=$req2->fetch(PDO::FETCH_ASSOC);

// LISTE DE COMPÉTENCES
$q2='SELECT name FROM competences ;';
$req3=$bdd->prepare($q2);
$req3->execute(); 

// AJOUTER DES QUESTIONS 
if (isset($_POST['competenceScroll']) && !empty($_POST['competenceScroll'])
&& isset($_POST['question']) && !empty($_POST['question'])
&& isset($_POST['answer1']) && !empty($_POST['answer1'])
&& isset($_POST['answer2']) && !empty($_POST['answer2'])
&& isset($_POST['answer3']) && !empty($_POST['answer3'])
&& isset($_POST['answer4']) && !empty($_POST['answer4'])
&& isset($_POST['answerCorrect']) && !empty($_POST['answerCorrect']) ){


    $q3='SELECT competence_id FROM competences WHERE name=:name;';
    $req4=$bdd->prepare($q3);
    $req4->execute([
        'name'=>$_POST['competenceScroll']
    ]); 

    $result3=$req4->fetch(PDO::FETCH_ASSOC);
    foreach($result3 as $index3=>$value3){
        $competenceName=$value3;
    }
    
    $q4='INSERT INTO questions (question,answerCorrect,answer1,answer2,answer3,answer4,competence_id) VALUES (:question,:answerCorrect,:answer1,:answer2,:answer3,:answer4,:competence_id);';
    $req5=$bdd->prepare($q4);
    $req5->execute([
        'question'=> $_POST['question'],
        'answerCorrect'=> $_POST['answerCorrect'],
        'answer1'=> $_POST['answer1'],
        'answer2'=> $_POST['answer2'],
        'answer3'=> $_POST['answer3'],
        'answer4'=> $_POST['answer4'],
        'competence_id'=> $competenceName
    ]); 



}

// LISTE DE COMPÉTENCES V2 (pour le tableau de questions)
$q5='SELECT name FROM competences ;';
$req6=$bdd->prepare($q2);
$req6->execute(); 



?>

<!DOCTYPE html>
<html>
    <?php 
    $title='Gestion Compétence';
    include('includes/head.php')
    ?>

    <body class="bg-light">

        <?php include('includes/header.php');?>

        <main>

            <div class="container">
            <h1 class="text-center">Gestion des <span class="text-primary">Compétences</span></h1>

            <div class="row my-5">
                <div class="col-12 col-md-6">

                    <h2 class="text-center">Ajouter une compétence</h2>


                </div>    

                <div class="col-12 col-md-6">
                    <form method="post" >
                        <label class="form-label" for="inputNameCompetence">Nom de la compétence :</label>
                        <input type="text" name="addCompetence" placeholder="Entrer le nom de la compétence à ajouter" class="form-control mb-4" id="inputNameCompetence">
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>


                </div>            
            
            </div>

            <h3 class="text-center" >Table des compétences</h3>

            <table class="table table-striped my-5">
                <tr>
                    <th>ID Compétence</th>
                    <th>Nom Compétence</th>
                </tr>
                <?php 
                    while($result=$req2->fetch(PDO::FETCH_ASSOC)){
                       echo '<tr>';
                        foreach($result as $index=>$value){
                            
                            echo '<td>'.$value.'</td>';                      
                        }
                    
                        
                        echo '</tr>';
                    }

                ?>
            </table>
                    

            <div class="row my-5">

                <div class="col-12 col-md-6">
                    <h2 class="text-center">Ajouter des questions</h2>
                    
                </div>
                <div class="col-12 col-md-6">
                    <form method="post">
                        <label class="form-label" for="selectCompetence">Compétence :</label>
                        <select id="selectCompetence" class="form-select" name="competenceScroll">
                            <option selected>Sélectionner une compétence</option>
                            <?php 
                            while($result2=$req3->fetch(PDO::FETCH_ASSOC)){
                                foreach($result2 as $index2=>$value2){
                                    echo '<option value="'. $value2 .'">'. $value2.'</option>';                   
                                }
                            }

                        ?>
                        </select>
                        <label class="form-label mt-4" for="question">Question :</label>
                        <input type="text" name="question" placeholder="Entrer la question à ajouter" class="form-control mb-4" id="question">
                        <label class="form-label" for="answer1">Réponse 1 :</label>
                        <input type="text" name="answer1" placeholder="Entrer une des propositions de réponses à la question" class="form-control mb-4" id="answer1">
                        <label class="form-label" for="answer2">Réponse 2 :</label>
                        <input type="text" name="answer2" placeholder="Entrer une des propositions de réponses à la question" class="form-control mb-4" id="answer2">
                        <label class="form-label" for="answer3">Réponse 3 :</label>
                        <input type="text" name="answer3" placeholder="Entrer une des propositions de réponses à la question" class="form-control mb-4" id="answer3">
                        <label class="form-label" for="answer4">Réponse 4 :</label>
                        <input type="text" name="answer4" placeholder="Entrer une des propositions de réponses à la question" class="form-control mb-4" id="answer4">
                        <label class="form-label" for="answerCorrect">Réponse correct :</label>
                        <input type="text" name="answerCorrect" placeholder="Entrer la proposition correct" class="form-control mb-4" id="answerCorrect">
                        <button type="submit" class="btn btn-primary">Envoyer</button>

                    </form>
                </div>

            </div>
            
            <h3 class="text-center" >Table des questions</h3>
            <form>
                <label class="form-label" for="selectCompetence">Compétence :</label>
                <select id="selectCompetence" class="form-select" name="competenceScroll">
                    <option selected>Sélectionner une compétence</option>
                    <?php 
                    while($result4=$req6->fetch(PDO::FETCH_ASSOC)){
                        foreach($result4 as $index4=>$value4){
                            echo '<option value="'. $value4 .'">'. $value4.'</option>';                   
                        }
                    }
                    ?>

                </select>
            </form>
            <table class="table table-striped my-5">
                <tr>
                    <th>Question</th>
                    <th>Réponse 1</th>
                    <th>Réponse 2</th>
                    <th>Réponse 3</th>
                    <th>Réponse 4</th>
                    <th>Bonne réponse</th>
                    <th>Commande</th>
                </tr>
                <?php 
                   

                ?>
            </table>


                
            </div>

        </main>

    <?php include('includes/footer.php');?>
    </body>
</html>

