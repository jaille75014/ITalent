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
foreach($result as $index => $value) $number=$value;

$id_question=rand(1, $number);


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

                    echo $id_question;
                    
                ?>


                
            </div>

        </main>

    <?php include('includes/footer.php');?>
    </body>
</html>

