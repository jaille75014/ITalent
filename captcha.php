<?php 
session_start(); 
include('includes/header_location.php');

if (!isset($_SESSION['statut'])) {
    header('location: index');
    exit;
} 

include('includes/bd.php'); // Connexion à la base de données

if(isset($_POST['answer'])&& !empty($_POST['answer'])){
    if ($_POST['answer']== $_POST['correctAnswer']){
        $_SESSION['captcha']=1;
        switch($_SESSION['statut']){
            case 1 : 
                header('location: etudiant');
                exit;
            case 2 : 
                header('location: index_recruteur');
                exit;
            case 3 : 
                header('location: admin');
                exit;
        }
        
    } else {
        redirectFailure('captcha', 'Erreur, veuillez réessayer');
    }
}



$q = 'SELECT question, answer FROM CAPTCHA ORDER BY RAND() LIMIT 1;';
$req = $bdd->prepare($q);
$req->execute();
$result = $req->fetch(PDO::FETCH_ASSOC);

$question=$result['question'];
$answer=$result['answer'];
    

?>

<!DOCTYPE html>
<html>
    <?php 
    include('includes/fonctions_logs.php');

    $title='Captcha';
    $url = 'captcha'; // Utilisé pour revenir sur cette page en cas d'erreurs dans les pages newsletter
    include('includes/head.php');

    writeVisitLog($url);
    ?>

    <body class="bg-light">

        <?php include('includes/header.php');?>

        <main>

            <div class="container">
                <h1 class="text-center my-5">Plus qu'une dernière étape ! </h1>
                <?php 
                    if(isset($_GET['messageSuccess'])){
                        echo '<div class="alert alert-success" role="alert">'.htmlspecialchars($_GET['messageSuccess']).'</div>'; 
                    }
                    if(isset($_GET['messageFailure'])){
                        echo '<div class="alert alert-danger" role="alert">'.htmlspecialchars($_GET['messageFailure']).'</div>'; 
                        }
                    
                    
                ?>

                <div class="row">
                    <div class="col-8 offset-2 col-md-4 offset-md-4">
                        <div class="card my-5">
                            <div class="card-body">
                                <form method="post">
                                    <label for="question" class="form-label"><?= $question?></label>
                                    <input type="text" placeholder="Votre réponse" class="form-control" name="answer" id="question">
                                    <input type="hidden" value="<?= $answer ?>" name="correctAnswer">
                                    <button class="btn btn-primary mt-4" type="submit">Soumettre</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
                


                
            </div>

        </main>

    <?php include('includes/footer.php');?>
    </body>
</html>

