<?php 
    session_start(); 
    
    include('includes/fonctions_logs.php');
    writeVisitLog('index.php');
?>


<!DOCTYPE html>
<html lang="fr">

<?php 
$title='Accueil';
$url = 'index.php';
include('includes/head.php');?>

    <body class="bg-light">

        <?php include('includes/header.php');?>

        <main class="bg-light">
            
            <div class="container  mt-5">
                <div class="row align-items-center my-5 gy-4">

                    <div class="col-12 col-md-6 text-center text-md-start my-5">
                        <h2>Prouve tes compétences,<br>Discute,<br>Passe un entretien et...<br>Décroche un job !</h2>
                        <h4 class="mt-3">Bienvenue chez <span class="text-primary">ITalent</span> !</h4>
                        <a href="inscription.php" class="btn btn-primary mt-3">Viens décrocher ton premier emploi !</a>
                    </div>

                    <div class="col-12 col-md-6 my-5">
                        <img alt="Logo ITalent, Le Treizième Travail d'Hercule" src="assets/LOGO_version_complète.png" width="100%">
                    </div>

                </div>

            <div class="row py-5 gy-4">
                    <h1 class="text-center"> Nos avantages</h1>
             </div>  

                <div class="row my-5 g-3">
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <img src="assets/student_picture.jpg" alt="etudiant passant un entretien" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase">Étudiants</h5>
                                <p class="card-text">Fatigués de vous inscrire sur tous les sites pour que des recruteurs vous remarquent ? <br>
                                    Venez découvrir les nombreux avantages de vous inscrire chez ITalent !
                                </p>

                                <button class="btn btn-primary" onclick="openForm()">Découvrir les avantages</button>

                                <div class="login-popup">
                                    <div class="form-popup" id="popupForm">
                                        <ul class="list-group mt-4">
                                            <li class="list-group-item">Certification de vos compétences</li>
                                            <li class="list-group-item">Création de CV sur mesure en 1 clic</li>
                                            <li class="list-group-item">Interaction avec les recruteurs</li>
                                            <li class="list-group-item">Posts et storys pour mettre en avant vos expériences</li>
                                            <li class="list-group-item">Inscription simple et rapide</li>
                                        </ul>
                                        <button type="button" class="btn btn-primary" onclick="closeForm()">Fermer</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <img src="assets/banniere_accueil.jpg" alt="Recruteur en entretien avec une personne" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase">Recruteurs</h5>
                                <p class="card-text">N'attendez plus, inscrivez vous pour recruter vos futurs alternants et stagiaires ! <br>
                                    Inscription simple et rapide !
                                </p>

                                <button class="btn btn-primary" onclick="openForm2()">Découvrir les avantages</button>

                                <div class="login-popup">
                                    <div class="form-popup" id="popupForm2">
                                        <ul class="list-group mt-4">
                                            <li class="list-group-item">Recherche efficiente de talents</li>
                                            <li class="list-group-item">Engage la discussion avec les étudiants</li>
                                            <li class="list-group-item">Création rapide de compte</li>
                                            <li class="list-group-item">Suivre les talents repérés</li>
                                            <li class="list-group-item">Recommendations de talents</li>
                                        </ul>
                                        <button type="button" class="btn btn-primary" onclick="closeForm2()">Fermer</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

           

        
            
                

        <script src="js/script.js"></script>

  
    </main>

    
        <?php include('includes/footer.php');?>
    
    </body>
</html>