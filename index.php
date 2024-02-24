<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>ITalent | Accueil</title>
    <meta name="Description" content="ITalent, la révolution de la recherche d'emplois pour les étudiants en Informatique.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Intégration de la police d'écriture  -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <!-- Icône de Boxincons -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Intégration Bootstrap 5  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Intégration de notre CSS -->
    <link type="text/css" rel="stylesheet" href="CSS/style.css">

</head>

    <body class="bg-light">

        <?php include('includes/header.php');?>

        <main class="bg-light">
        <section class="pt-5" id="Top"></section>
        <div class="container py-5 pt-5">
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
                <div class="col-12 col-md-5 my-5 text-center ">
                    <h2>Étudiant</h2>
                    <ul class="list-group mt-4">
                        <li class="list-group-item">Certification de vos compétences</li>
                        <li class="list-group-item">Création de CV sur mesure en 1 clic</li>
                        <li class="list-group-item">Interaction avec les recruteurs</li>
                        <li class="list-group-item">Posts et storys pour mettre en avant vos expériences </li>
                        <li class="list-group-item">Inscription simple et rapide</li>
                    </ul>
                </div>

                <div class="col-12 col-md-5 offset-md-2 my-5 text-center ">
                    <h2>Recruteur</h2>
                    <ul class="list-group mt-4">
                        <li class="list-group-item">Recherche efficiente de talents</li>
                        <li class="list-group-item">Engage la discussion avec les étudiants</li>
                        <li class="list-group-item">Création rapide de compte</li>
                        <li class="list-group-item">Suivre les talents repérés</li>
                        <li class="list-group-item">Recommendations de talents</li>
                    </ul>
                </div>


           </div>

        </div>
            
                

            
  
    </main>

        <?php include('includes/footer.php');?>

    </body>
</html>