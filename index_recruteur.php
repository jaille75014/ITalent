<?php 
    session_start(); 
    if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 2) {
        header('location:index.php');
        exit;
    } ?>

<!DOCTYPE html>
<html lang="fr">

<?php 
$title='Recruteur';
include('includes/head.php');?>

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