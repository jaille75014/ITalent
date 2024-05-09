<?php
    session_start(); // On démarre la session AVANT toute chose
    include("includes/bd.php");
    
    if (!isset($_SESSION['user_id'])) {
        redirectFailure('connexion', 'Vous devez être connecté pour accéder à cette page.');
    }

    $user_id = $_SESSION['user_id'];

    $req_user_publications = $bdd->prepare("SELECT image, description FROM PUBLICATIONS WHERE user_id = ?");
    $req_user_publications->execute([$user_id]);

    $req_storys = $bdd->prepare("SELECT image, expiration FROM STORYS WHERE expiration >= CURDATE()"); // CURDATE() = date actuelle 

    function afficherStorys($req_storys) {
        while ($story = $req_storys->fetch()) {
            echo '<div class="col-md-2">';
            echo '<img src="' . $story['image'] . '" class="img-fluid rounded-circle" alt="Story">';
            echo '</div>';
        }
    }
?>


<!DOCTYPE html>
<html lang="fr">

    <?php
    include('includes/fonctions_logs.php');

    $title='Accueil étudiant';
    $url = 'etudiant'; // Utilisé pour revenir sur cette page en cas d'erreurs dans les pages newsletter
    include('includes/head.php');

    writeVisitLog($url);
    ?>

    <body class="bg-light">

        <?php include('includes/header.php'); ?>
        <main class="mb-5">
        <div class="container mt-4">

            <!-- Affichage storys -->
            <div class="row mb-4" id="storys">
                <?php afficherStorys($req_storys); ?>
            </div>

            <!-- Affichage publications de l'utilisateur -->
            <div class="row" id="user_publications">
                <?php 
                while ($publication = $req_user_publications->fetch()) {
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo $publication['image']; ?>" class="card-img-top" alt="Publication">
                            <div class="card-body">
                                <p class="card-text"><?php echo $publication['description']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>


            <!-- Formulaire d'ajout publication -->
            <div class="row mt-4">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ajouter une nouvelle publication</h5>
                            <form action="back/ajouter_publication.php" method="POST" id="ajouterPublicationForm" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        </main>

        <script>
            addPubliRefresh();
        </script>
        
        <?php 
        include("includes/footer.php");
        ?>
    <script src="js/load.js"></script>
    </body>

</html>