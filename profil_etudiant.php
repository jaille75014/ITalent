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

$q="SELECT image FROM PUBLICATIONS WHERE user_id=?;";
$resultat = $bdd->prepare($q);
$resultat->execute([$user_id]);
$publications=$res->fetchAll(PDO::FETCH_ASSOC);



// Afficher les informations de l'utilisateur
?>

<html>
    <?php
    include('includes/fonctions_logs.php');

    $title='Profil Etudiant';
    $url = 'profil_etudiant'; //Permet de revenir sur cette page en cas d'erreurs dans les pages newsletter
    include('includes/head.php');

    writeVisitLog($url);
    ?>
    <body>
        <?php include('includes/header.php');?>
        <div class="container my-5">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-5">Profil de l'étudiant</h1>
                    <div class="card mb-5">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 imgprofile">
                                    <img src="<?php echo $firstUser['user_image']; ?>" alt="Photo de profil">
                                </div>
                                <div class="col-8">
                                    <h3><?php echo $firstUser['firstname'] . ' ' . $firstUser['lastname']; ?></h3>
                                    <p>Ville : <?php echo $firstUser['city']; ?></p>
                                    <p>Code postal : <?php echo $firstUser['zip']; ?></p>
                                    <p>Poste : <?php echo $firstUser['name_job']; ?></p>
                                </div>
                            </div>
                            <?php
                            $q2 = 'SELECT name,level,validity FROM POSSESSES INNER JOIN COMPETENCES ON COMPETENCES.competence_id=POSSESSES.competence_id WHERE POSSESSES.user_id = ? ;';
                        $req2=$bdd->prepare($q2);
                        $req2->execute([
                            $user_id
                        ]);
                        $competences = $req2->fetchAll(PDO::FETCH_ASSOC);

                        if(!empty($competences)){
                            echo '
                            
                            
                            <h3 class="text-center mt-5" >Ses compétences : </h3>

                            <div class="table-responsive">

                            <table class="table table-striped my-5 text-center">
                            <thead>
                            <tr>
                                <th>Compétence</th>
                                <th>Note</th>
                                <th>Date de passage</th>
                            </tr>
                            </thead>
                            <tbody>
                            ';
                            

                            foreach ($competences as $competence) {
                                echo '
                                    <tr>
                                        <td>'.$competence['name'].'</td>
                                        <td>'.$competence['level'].'</td>
                                        <td>'.$competence['validity'].'</td>
                                    </tr>
                                
                                ';
                            }

                            echo '</tbody></table></div';

                        }
                        ?>

                </table>

                            <div class="row">
                                <div class="col-12">
                                    <h3 class="text-center mb-5">Publications :</h3>
                                    <?php 
                                        foreach($publications as $publication){
                                            echo '<div class="row">
                                                <div class="col-4">
                                                    <img src="'.$publication['image'].'" alt="Photo de la publication" class="img-fluid">
                                                </div>
                                                <div class="col-8">
                                                    <p>'.$publication['description'].'</p>
                                                </div>
                                            </div>';

                                            echo $publication['image'];
                                        }
                                    ?>
                                        </div>
                                    </div>
                                    <h3 class="text-center">Storys : </h3>
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
                                                        <img src="uploads/storys/<?php echo $story['story_image']; ?>" alt="Photo de la story" class="img-fluid">
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
