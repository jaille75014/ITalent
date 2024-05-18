<?php 
session_start();
include('includes/header_location.php');
if(isset($_SESSION['statut']) && !isset($_SESSION['captcha'])){
    redirectFailure('captcha', 'Chippeur arrête de chipper');
}

?>


<!DOCTYPE html>
<html>
    <?php     
    include('includes/bd.php');
    include('includes/fonctions_logs.php');
    

    $title='Accueil';
    $url = 'index'; // Utilisé pour revenir sur cette page en cas d'erreurs dans les pages newsletter
    include('includes/head.php');

    writeVisitLog($url);
    ?>

    <body class="bg-light">
        <?php include('includes/header.php');?>
        <main>

            <?php 
            $url = 'index'; //Permet de revenir sur cette page en cas d'erreurs dans les pages newsletter
            if(isset($_GET['messageFailure'])){
                echo '<div class="alert alert-danger" role="alert">'.htmlspecialchars($_GET['messageFailure']).'</div>'; 
            }
            if(isset($_GET['messageSuccess'])){
                echo '<div class="alert alert-success" role="alert">'.htmlspecialchars($_GET['messageSuccess']).'</div>'; 
            }
            ?>


            <div class="container mt-5">


                <div class="d-flex justify-content-center">
                    <div class="row align-items-center my-5 gy-4">
                        <div class="col-12 col-md-6 text-center text-md-start my-5">
                            <h2>Prouve tes compétences,<br>Discute,<br>Passe un entretien et...<br>Décroche un job !</h2>
                            <h4 class="mt-3">Bienvenue chez <span class="text-primary">ITalent</span> !</h4>
                            <a href="inscription" class="btn btn-primary mt-3">Viens décrocher ton premier emploi !</a>
                        </div>
                        <div class="col-12 col-md-6 my-5">
                            <img alt="Logo ITalent, Le Treizième Travail d'Hercule" src="assets/LOGO_version_complète.png"
                                width="100%">
                        </div>
                    </div>
                </div>

                <div class="row py-5 gy-4">
                    <h1 class="text-center"> Nos avantages</h1>
                </div>


                <div class="d-flex justify-content-center">
                    <div class="row">

                        <div class="col-md-6 mb-4 pe-md-5">
                            <div class="flip-card">
                                <div class="flip-card-inner">
                                    <div class="flip-card-front">
                                        <img src="assets/student_picture.jpg" alt="etudiant passant un entretien">
                                        <h5 class="mt-3">Étudiants</h5>
                                        <p class="card-text">Fatigués de vous inscrire sur tous les sites pour que des
                                            recruteurs vous remarquent ? <br> Venez découvrir les nombreux avantages d'ITalent !
                                        </p>
                                    </div>
                                    <div class="flip-card-back">
                                        <ul>
                                            <li>Certification de vos compétences</li>
                                            <li>Création de CV sur mesure en 1 clic</li>
                                            <li>Interaction avec les recruteurs</li>
                                            <li>Posts et storys pour mettre en avant vos expériences</li>
                                            <li>Inscription simple et rapide</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4 ps-md-5">
                            <div class="flip-card">
                                <div class="flip-card-inner">
                                    <div class="flip-card-front">
                                        <img src="assets/banniere_accueil.jpg" alt="Recruteur en entretien avec une personne">
                                        <h5 class="mt-3">Recruteurs</h5>
                                        <p>N'attendez plus, inscrivez-vous pour recruter vos futurs alternants et stagiaires
                                            ! <br> Inscription simple et rapide !</p>
                                    </div>
                                    <div class="flip-card-back">
                                        <ul>
                                            <li>Recherche efficiente de talents</li>
                                            <li>Engage la discussion avec les étudiants</li>
                                            <li>Création rapide de compte</li>
                                            <li>Suivre les talents repérés</li>
                                            <li>Recommendations de talents</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            
        </main>

        <?php include('includes/footer.php');?>

    </body>

</html>
