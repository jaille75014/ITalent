<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="Description" content="ITalent, la révolution de la recherche d'emplois pour les étudiants en Informatique.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/litera/bootstrap.min.css" integrity="sha384-enpDwFISL6M3ZGZ50Tjo8m65q06uLVnyvkFO3rsoW0UC15ATBFz3QEhr3hmxpYsn" crossorigin="anonymous">
    <title>ITalent | Accueil</title>
</head>

<body>

    <?php include('includes/header.php');?>

    <div class="banner">
        <div class="banner_content">
            <h2>Prouve tes compétences, <br> 
            Discute, <br>
            Passe un entretien et... <br>
            Décroche le job ! <br>
            </h2>

            <p>Bienvenue chez <span style="color: #FEE715; font-weight: bold">Italent</span> ! <br>
            LA plateforme d’emploi spécialement conçue <br>
            pour les étudiants. Ici c’est aux recruteurs de te contacter ! <br>
            Donnes nous juste ton CV, prouves tes compétences avec des tests et on se charge du reste ! <br>
            </p>

            <div class="d-grid gap-2">
                <a href="inscription.php" class="btn btn-lg btn-primary" role="button">
                    <span style="color: #FEE715;" class="btn-text">Viens décrocher ton prochain emploi !</span>
                </a>
            </div>


        </div>
    </div>


    <div class="container">
        <div class="student">
            <h3>ETUDIANT</h3>
            <ul>
                <li>Passage de compétences 1</li>
                <li>Création de CV sur mesure</li>
                <li>Interaction avec les recruteurs</li>
                <li>Posts et storys pour accroître la visibilité</li>
                <li>Inscription simple et rapide</li>
            </ul>
        </div>
        <div class="recruiter">
            <h3>RECRUTEUR</h3>
            <ul>
                <li>Recherche simple et rapide de talents</li>
                <li>Engage la discussion avec les étudiants</li>
                <li>Création de compte rapidement</li>
                <li>Abonnements aux comptes étudiants</li>
                <li>Recommendations de talents</li>
            </ul>
        </div>
    </div>








    <?php include('includes/footer.php');?>


</body>


</html>