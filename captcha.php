<?php 
session_start(); 

    

if (!isset($_SESSION['statut'])) {
    header('location:index.php');
    exit;
} 

include('includes/fonctions_logs.php');
writeVisitLog('captcha.php');

include('includes/bd.php'); // Connexion à la base de données


$q = 'SELECT COUNT(question_id) FROM captcha;';
$req = $bdd->prepare($q);
$req->execute();
$result = $req->fetch(PDO::FETCH_ASSOC);
foreach($result as $index => $value) $numberMax=$value;

$numberQuestion=rand(1, $numberMax);

$q = 'SELECT question,answer FROM captcha;';
$req = $bdd->prepare($q);
$req->execute();
$result = $req->fetch(PDO::FETCH_ASSOC);

for ($i=1;$i<=$numberQuestion;$i++){
    if ($i==$numberQuestion){
        $question=$result['question'];
        $answer=$result['answer'];
    } else {
        $result = $req->fetch(PDO::FETCH_ASSOC);
    }
}

if(isset($_POST['answer'])&& !empty($_POST['answer'])){
    if ($_POST['answer']== $answer){
        switch($_SESSION['statut']){
            case 1 : 
                header('location:etudiant.php');
                exit;
                break;
            case 2 : 
                header('location:index_recruteur.php');
                exit;
                break;
            case 3 : 
                header('location:admin.php');
                exit;
                break;
        }
        $_SESSION['captcha']=1;
    } else {
        header('location:captcha.php?error=Veuillez réessayer !');
        exit;
    }
}

    

?>

<!DOCTYPE html>
<html>
    <?php 
    $title='Captcha';
    include('includes/head.php')
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
                    if(isset($_GET['error'])){
                        echo '<div class="alert alert-danger" role="alert">'.htmlspecialchars($_GET['error']).'</div>'; 
                        }
                    
                    
                ?>

                <div class="row">
                    <div class="col-4 offset-4">
                        <div class="card my-5">
                            <div class="card-body">
                                <form method="post">
                                    <label for="question" class="form-label"><?= $question?></label>
                                    <input type="text" placeholder="Votre réponse" class="form-control" name="answer" id="question">
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

