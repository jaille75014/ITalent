<?php
session_start();
include("includes/bd.php");
include("includes/header_location.php");

if (!isset($_SESSION['user_id'])) {
    redirectFailure('../connexion', 'Vous devez être connecté pour accéder à cette page.');
    exit;
}
if(!isset($_GET['id'])){
    redirectFailure('../profil', 'Ohh.. Une erreur s\'est produite. Nos équipes sont sur le coup ! (C\'est faux)');	
    exit;
}
$user_id = htmlspecialchars($_GET['id']);
// Récupérer les informations de l'utilisateur
$query = "SELECT firstname, lastname, city, zip, image, level, COMPETENCES.name, 
                JOBS.name AS name_job, PUBLICATIONS.image AS publication_image,
                PUBLICATIONS.description, 
                PUBLICATIONS.publi_id,
                STORYS.image AS story_image, STORYS.expiration, STORYS.story_id
        FROM USERS 
            INNER JOIN POSSESSES ON USERS.user_id = POSSESSES.user_id 
            INNER JOIN COMPETENCES ON POSSESSES.competence_id = COMPETENCES.competence_id  
            INNER JOIN JOBS ON USERS.student_job = JOBS.id
            INNER JOIN PUBLICATIONS ON USERS.user_id = PUBLICATIONS.user_id
            INNER JOIN STORYS ON USERS.user_id = STORYS.user_id
            WHERE user_id = :user_id";
$res = $bdd->prepare($query);
$res->execute(['user_id' => $user_id]);
$user = $res->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    redirectFailure('../profil', 'Ohh.. Une erreur s\'est produite. Nos équipes sont sur le coup ! (C\'est faux)');	
    exit;
}

?>
// Afficher les informations de l'utilisateur
<html>
    <?php
    include("includes/head.php");
    ?>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Profil de l'étudiant</h1>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="assets/<?php echo $user['image']; ?>" alt="Photo de profil" class="img-fluid">
                                </div>
                                <div class="col-8">
                                    <h2><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></h2>
                                    <p>Ville : <?php echo $user['city']; ?></p>
                                    <p>Code postal : <?php echo $user['zip']; ?></p>
                                    <p>Compétence : <?php echo $user['name']; ?></p>
                                    <p>Niveau : <?php echo $user['level']; ?></p>
                                    <p>Poste : <?php echo $user['name_job']; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h2>Publications</h2>
                                    <?php 
                                    foreach($user['publications'] as $publication){
                                        ?>
                                        <div class="row">
                                            <div class="col-4">
                                                <img src="assets/<?php echo $publication['image']; ?>" alt="Photo de la publication" class="img-fluid">
                                            </div>
                                            <div class="col-8">
                                                <p><?php echo $publication['description']; ?></p>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <h2>Storys</h2>
                                            <?php 
                                            foreach($user['storys'] as $story){
                                                // Convertir la date d'expiration en timestamp
                                                $expiration = strtotime($story['expiration']);
                                                // Obtenir le timestamp actuel
                                                $now = time();
                                                // Vérifier si la date d'expiration est supérieure à la date actuelle
                                                if ($expiration > $now) {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <img src="assets/<?php echo $story['image']; ?>" alt="Photo de la story" class="img-fluid">
                                                        </div>
                                                        <div class="col-8">
                                                            <p>Expiration : <?php echo $story['expiration']; ?></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= include("includes/footer.php"); ?>
    </body> 
</html>
