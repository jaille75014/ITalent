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

// LISTE DE COMPÉTENCES
$q2='SELECT name FROM competences ;';
$req3=$bdd->prepare($q2);
$req3->execute(); 


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

            <h3 class="text-center" >Table des questions</h3>

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
                        <select id="selectCompetence" class="form-select">
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
                        <input type="text" name="question" placeholder="Entrer le nom de la compétence à ajouter" class="form-control mb-4" id="question">
                        <label class="form-label" for="answer1">Réponse 1 :</label>
                        <input type="text" name="answer1" placeholder="Entrer le nom de la compétence à ajouter" class="form-control mb-4" id="answer1">
                        <label class="form-label" for="answer2">Réponse 2 :</label>
                        <input type="text" name="answer2" placeholder="Entrer le nom de la compétence à ajouter" class="form-control mb-4" id="answer2">
                        <label class="form-label" for="answer3">Réponse 3 :</label>
                        <input type="text" name="answer3" placeholder="Entrer le nom de la compétence à ajouter" class="form-control mb-4" id="answer3">
                        <label class="form-label" for="answer4">Réponse 4 :</label>
                        <input type="text" name="answer4" placeholder="Entrer le nom de la compétence à ajouter" class="form-control mb-4" id="answer4">
                        <label class="form-label" for="answerCorrect">Réponse correct :</label>
                        <input type="text" name="answerCorrect" placeholder="Entrer le nom de la compétence à ajouter" class="form-control mb-4" id="answerCorrect">
                        <button type="submit" class="btn btn-primary">Envoyer</button>

                    </form>
                </div>

            </div>

                
            </div>

        </main>

    <?php include('includes/footer.php');?>
    </body>
</html>

