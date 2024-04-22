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
include('includes/fonctions_logs.php');
writeVisitLog('competence_admin');

include('includes/bd.php'); // Connexion à la base de données
    
// AJOUT DE COMPÉTENCES

if(isset($_POST['addCompetence'])&& !empty($_POST['addCompetence'])){
    $q='INSERT INTO COMPETENCES (name) VALUES (:name);';
    $req=$bdd->prepare($q);
    $req->execute([
        'name'=>$_POST['addCompetence']
    ]);
}

// TABLEAU DES COMPÉTENCES

$q2='SELECT competence_id,name FROM COMPETENCES ;';
$req2=$bdd->prepare($q2);
$req2->execute();  

// LISTE DE COMPÉTENCES
$q3='SELECT name FROM COMPETENCES ;';
$req3=$bdd->prepare($q3);
$req3->execute(); 


// SUPPRESSION DE QUESTIONS

if(isset($_POST['delete'])){
    $q9='DELETE FROM QUESTIONS WHERE question=:question ;';
    $req9=$bdd->prepare($q9);
    $req9->execute([
        'question'=>$_POST['delete']
    ]); 
}

// LISTE DE COMPÉTENCES V2 (pour le tableau de questions)
$q6='SELECT name FROM COMPETENCES ;';
$req6=$bdd->prepare($q6);
$req6->execute(); 






?>

<!DOCTYPE html>
<html>
    <?php 
    $title='Gestion Compétence';
    $url = 'competence_admin'; //Permet de revenir sur cette page en cas d'erreurs dans les pages newsletter
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
                    while($result2=$req2->fetch(PDO::FETCH_ASSOC)){
                       echo '<tr>';
                        foreach($result2 as $index2=>$value2){
                            
                            echo '<td>'.$value2.'</td>';                      
                        }
                    
                        
                        echo '</tr>';
                    }

                ?>
            </table>

            
                    

            <div class="row my-5">
                
                

                <div class="col-12 col-md-6">
                    <h2 class="text-center">Ajouter des questions</h2>
                    <p class="mt-5">Veuillez sélectionner une compétence, puis entrer une question et 4 réponses possibles. Il doit y en avoir une de bonne, que vous devez entrer à nouveau dans le dernier champ.</p>

                </div>
                <div class="col-12 col-md-6">
                        <label class="form-label" for="selectCompetence">Compétence :</label>
                        <select id="selectCompetence" class="form-select">
                            <option selected>Sélectionner une compétence</option>
                            <?php 
                            while($result3=$req3->fetch(PDO::FETCH_ASSOC)){
                                foreach($result3 as $index3=>$value3){
                                    echo '<option value="'. $value3 .'">'. $value3.'</option>';                   
                                }
                            }

                        ?>
                        
                        </select>
                        <label class="form-label mt-4" for="question">Question :</label>
                        <input type="text" id="question" placeholder="Entrer la question à ajouter" class="form-control mb-4">
                        
                        <label class="form-label" for="answer1">Réponse 1 :</label>
                        <input type="text" id="answer1" placeholder="Entrer une des propositions de réponses à la question" class="form-control mb-4">
                        
                        <label class="form-label" for="answer2">Réponse 2 :</label>
                        <input type="text" id="answer2" placeholder="Entrer une des propositions de réponses à la question" class="form-control mb-4">
                       
                        <label class="form-label" for="answer3">Réponse 3 :</label>
                        <input type="text" id="answer3" placeholder="Entrer une des propositions de réponses à la question" class="form-control mb-4">
                        
                        <label class="form-label" for="answer4">Réponse 4 :</label>
                        <input type="text" id="answer4" placeholder="Entrer une des propositions de réponses à la question" class="form-control mb-4">
                       
                        <label class="form-label" for="answerCorrect">Réponse correct :</label>
                        <input type="text" id="answerCorrect" placeholder="Entrer la proposition correct" class="form-control mb-4">
                        
                        <button onclick="addQuestionsToCompetence()" type="submit" class="btn btn-primary">Envoyer</button>
                </div>
                <div id="result" class="mt-4"></div> <!-- Permet d'afficher le résultat de l'ajout de questions. -->

            </div>
            
            <h3 class="text-center" >Table des questions</h3>
            <label class="form-label" for="selectCompetence2">Compétence dont vous voulez afficher les questions :</label>
            <select id="selectCompetence2" class="form-select mb-5" name="competenceScroll2" onchange="selectCompetence()">
                <option selected>Sélectionner une compétence</option>
                <?php 
                while($result6=$req6->fetch(PDO::FETCH_ASSOC)){
                    foreach($result6 as $index6=>$value6){
                        echo '<option value="'. $value6 .'">'. $value6.'</option>';                   
                    }
                }
                ?>

                </select>

            
                <div id="tableQuestions"></div>
                
                        
        


            


                
            

        </main>

        <script src="js/load.js"></script>

    <?php include('includes/footer.php');?>
    </body>
</html>

