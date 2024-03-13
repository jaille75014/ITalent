<?php 
    session_start(); 
    if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 2q) {
        header('location:index.php');
        exit;
    } ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Accueil | ITalent</title>
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
    <link type="text/css" rel="stylesheet" href="css/style.css">

</head>

    <body class="bg-light">

    <?php include('includes/header.php');?>

    <main class="bg-light">

    <div class="banner-recruiter">
        <img src="assets/banner_recruteur.jpg" alt="Bannière recruteur">
        <h1>ESPACE RECRUTEUR</h1>
        <p>Chercher des étudiants que vous souhaitez en filtrant vos recherches pour pouvoir discuter avec eux</p>
        <div class="search-container">
            <form id="searchForm">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" id="competence" name="competence" placeholder="Compétences">
                    </div>
                    <div class="form-group col-md-4">
                        <select class="form-control" id="niveau" name="niveau">
                            <option value="">Sélectionner le niveau</option>
                            <option value="Débutant">Débutant</option>
                            <option value="Intermédiaire">Intermédiaire</option>
                            <option value="Avancé">Avancé</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" id="poste" name="poste" placeholder="Poste">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </form>
        </div>
    </div>




   


        <div class="row py-5 gy-4">
            <h1 class="text-center">CV Etudiants</h1>
        </div>

        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">CV de ... (nom de l'étudiant)</h5>
                    <p class="card-text">Tinder card avec pdf dedans</p>
                    <object class="card-body" data="SyllabusDuProjet.pdf" type="application/pdf">
                        <p>CV de <a href="SyllabusDuProjet.pdf">nom étudiant</a></p>
                    </object>
                </div>
            </div>
        </div>


        <script src="js/script.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
        
        </main>

        <?php include('includes/footer.php');?>
    
    </body>
</html>