<?php 
session_start(); 
if(!isset($_SESSION['captcha'])){
    header('location:captcha.php?error=Chipeur arrête de chipper !');
    exit;
}
    

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
    
    $q='INSERT INTO CAPTCHA (question,answer,user_id) VALUES (:question,:answer,:user_id);';
    $req=$bdd->prepare($q);
    $result=$req->execute([
        'question'=> $_POST['question'],
        'answer'=> $_POST['answer'],
        'user_id'=> $_SESSION['user_id']
        ]);  


    header('location: captcha_admin.php');
    exit;
} 


// Si suppresion d'une question
if(isset($_POST['delete'])){
    $q='DELETE FROM CAPTCHA WHERE question=:question ;';
    $req3=$bdd->prepare($q);
    $req3->execute([
        'question'=>$_POST['delete']
    ]); 
}


// Requête pour le tableau de questions

$q='SELECT question,answer,user_id FROM CAPTCHA;';
$req=$bdd->prepare($q);
$req->execute();  


?>

<!DOCTYPE html>
<html lang="fr">

<?php 
    $title='Gestion Captcha';
    $url = 'captcha_admin.php'; //Permet de revenir sur cette page en cas d'erreurs dans les pages newsletter
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

            <h3 class="text-center" >Table des questions</h3>

            <table class="table table-striped my-5">
                <tr>
                    <th>Question</th>
                    <th>Réponse</th>
                    <th>Nom créateur</th>
                    <th>Commande</th>
                </tr>
                <?php 
                    while($result=$req->fetch(PDO::FETCH_ASSOC)){
                       echo '<tr>';
                        foreach($result as $index=>$value){
                            if($index!='user_id'){
                                echo '<td>'.$value.'</td>';
                                if ($index=='question') $questKeep=$value;
                                
                            } else {
                                echo '<td>';
                                $q='SELECT lastname, firstname FROM users WHERE user_id='.$value;
                                $req2=$bdd->prepare($q);
                                $req2->execute(); 
                                $result2=$req2->fetch(PDO::FETCH_ASSOC);
        
                                foreach($result2 as $index2=>$value2){
                                    echo $value2.' ';
                                }
                                echo '</td>';
                            }
                            
                        }
                        echo '<td>

                        <form method="post">
                            <input type="hidden" name="delete" value="'.$questKeep.'">
                            <button type="submit" class="btn btn-danger">
                                Suppresion
                            </button>
                        </form>

                            </td>';
                        
                        
                        echo '</tr>';
                    }
                    
                    
                
                
                ?>
            </table>

            

        </div>
    </main>

    <?php include('includes/footer.php');?>
</body>
</html>