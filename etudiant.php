<?php
session_start();
include("includes/bd.php");
include("includes/header_location.php");
if (!isset($_SESSION['user_id'])) {
    redirectFailure('connexion', 'Vous devez être connecté pour accéder à cette page.');
}

$req_publications = $bdd->query("SELECT * FROM PUBLICATIONS");
$req_storys = $bdd->query("SELECT * FROM STORYS WHERE expiration >= CURDATE()"); // CURDATE() = date actuelle 

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

    <body>

        <?php include('includes/header.php'); ?>

        <div class="container mt-4">

            <!-- Affichage storys -->
            <div class="row mb-4" id="storys">
                <?php afficherStorys($req_storys); ?>
            </div>

            <!-- Affichage publications -->
            <div class="row" id="publications">
                <?php 
                while ($publication = $req_publications->fetch()) {
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
                            <form action="back/ajouter_publication" method="POST" id="ajouterPublicationForm">
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

        
        <script>
            // Script JS : ajouter publication / rechargement de la page
            document.getElementById("ajouterPublicationForm").addEventListener("submit", function (event) {
                event.preventDefault(); // Empêcher l'envoi du formulaire par défaut

                // Récupérer données du formulaire
                var formData = new FormData(this);

                // Requête AJAX pour ajouter publication
                var ajt = new XMLHttpRequest();
                ajt.open("POST", "back/ajouter_publication", true);
                ajt.onload = function () {
                    if (ajt.status === 200) {
                        // Réussie > recharger la page
                        window.location.reload();
                    }
                };
                ajt.send(formData);
            });

        </script>
        
        <?php 
        include("includes/footer.php");
        ?>
    <script src="js/load.js"></script>
    </body>

</html>