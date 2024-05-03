<?php
session_start();
include("includes/bd.php");
include("includes/header_location.php");

if(!isset($_GET['id'])){
    redirectFailure('../index_recruteur', 'Ohh.. Une erreur s\'est produite. Nos équipes sont sur le coup ! (C\'est faux)');	
}
$user_id = htmlspecialchars($_GET['id']);

$query = "SELECT USERS.firstname, USERS.lastname, USERS.city, USERS.zip, USERS.image AS user_image, POSSESSES.level, COMPETENCES.name, 
                JOBS.name AS name_job, PUBLICATIONS.image AS publication_image,
                PUBLICATIONS.description, 
                PUBLICATIONS.publi_id,
                STORYS.image AS story_image, STORYS.expiration, STORYS.story_id
        FROM USERS 
            LEFT JOIN POSSESSES ON USERS.user_id = POSSESSES.user_id 
            LEFT JOIN COMPETENCES ON POSSESSES.competence_id = COMPETENCES.competence_id  
            INNER JOIN JOBS ON USERS.student_job = JOBS.id
            LEFT JOIN PUBLICATIONS ON USERS.user_id = PUBLICATIONS.user_id
            LEFT JOIN STORYS ON USERS.user_id = STORYS.user_id
            WHERE USERS.user_id = :user_id";
$res = $bdd->prepare($query);
$res->execute(['user_id' => $user_id]);
$user = $res->fetchAll(PDO::FETCH_ASSOC);
if (!$user) {
    redirectFailure('../index_recruteur', 'L\'utilisateur n\'a pas souhaité partager ses informations.');    
}
$firstUser = $user[0];
// Afficher les informations de l'utilisateur
?>

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
                                    <img src="assets/<?php echo $firstUser['user_image']; ?>" alt="Photo de profil">
                                </div>
                                <div class="col-8">
                                    <h2><?php echo $firstUser['firstname'] . ' ' . $firstUser['lastname']; ?></h2>
                                    <p>Ville : <?php echo $firstUser['city']; ?></p>
                                    <p>Code postal : <?php echo $firstUser['zip']; ?></p>
                                    <p>Compétence : <?php echo $firstUser['name']; ?></p>
                                    <p>Niveau : <?php echo $firstUser['level']; ?></p>
                                    <p>Poste : <?php echo $firstUser['name_job']; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h2>Publications</h2>
                                    <?php 
                                    if (!empty($firstUser['publications'])) {
                                        foreach($firstUser['publications'] as $publication){
                                            ?>
                                            <div class="row">
                                                <div class="col-4">
                                                    <img src="assets/<?php echo $publication['publication_image']; ?>" alt="Photo de la publication" class="img-fluid">
                                                </div>
                                                <div class="col-8">
                                                    <p><?php echo $publication['description']; ?></p>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        echo "<p>Cet utilisateur n'a pas de publications.</p>";
                                    }
                                    ?>
                                    <h2>Storys</h2>
                                    <?php 
                                    if (!empty($firstUser['storys'])) {
                                        foreach($firstUser['storys'] as $story){
                                            // Convertir la date d'expiration en timestamp
                                            $expiration = strtotime($story['expiration']);
                                            // Obtenir le timestamp actuel
                                            $now = time();
                                            // Vérifier si la date d'expiration est supérieure à la date actuelle
                                            if ($expiration > $now) {
                                                ?>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <img src="assets/<?php echo $story['story_image']; ?>" alt="Photo de la story" class="img-fluid">
                                                    </div>
                                                    <div class="col-8">
                                                        <p>Expiration : <?php echo $story['expiration']; ?></p>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    } else {
                                        echo "<p>Cet utilisateur n'a pas de stories.</p>";
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
