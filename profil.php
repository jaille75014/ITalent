<?php
session_start(); 
include('includes/header_location.php');
include('includes/bd.php'); 

if (!isset($_SESSION['user_id'])) {
    redirectFailure('connexion', 'Vous devez être connecté pour accéder à cette page.');
}

if(!isset($_SESSION['captcha'])){
    header('location:captcha?error=Chipeur arrête de chipper !');
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM USERS WHERE user_id = ?";
$stmt = $bdd->prepare($query);
$stmt->execute([$user_id]);
$userInfo = $stmt->fetch();

$queryPublications = "SELECT * FROM PUBLICATIONS WHERE user_id = ? ORDER BY publi_id DESC";
$stmtPublications = $bdd->prepare($queryPublications);
$stmtPublications->execute([$user_id]);
$publications = $stmtPublications->fetchAll();

$queryStorys = "SELECT * FROM STORYS WHERE user_id = ? AND expiration > NOW() ORDER BY story_id DESC";
$stmtStorys = $bdd->prepare($queryStorys);
$stmtStorys->execute([$user_id]);
$storys = $stmtStorys->fetchAll();

$select_post = "SELECT name FROM JOBS";
$req_post = $bdd->prepare($select_post);
$req = $req_post->execute();
$infos_job = $req_post->fetchAll();



// LISTE DE COMPÉTENCES
$q3='SELECT name FROM COMPETENCES ;';
$req3=$bdd->prepare($q3);
$req3->execute(); 

$url = 'profil'; //Permet de revenir sur cette page en cas d'erreurs dans les pages newsletter et codes_verification
?>

<!DOCTYPE html>
<html>
    <?php
    include('includes/fonctions_logs.php');

    $title='Profil';
    $url = 'profil';
    include('includes/head.php');

    writeVisitLog($url);
    ?>
    <body class="bg-light">
        <?php include('includes/header.php'); ?>

        <main class=" pt-5">

            <div class="container mt-5">
            <?php 
            if(isset($_GET['messageFailure'])){
                echo '<div class="alert alert-danger" role="alert">'.htmlspecialchars($_GET['messageFailure']).'</div>'; 
            }
            if(isset($_GET['messageSuccess'])){
                echo '<div class="alert alert-success" role="alert">'.htmlspecialchars($_GET['messageSuccess']).'</div>'; 
            }
    ?>
                <div class="row">

                    <div class="col-12 mb-5">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h2 class="card-title">Profil de <?php echo htmlspecialchars($userInfo['firstname']) . ' ' . htmlspecialchars($userInfo['lastname']); ?></h2>
                                <form action="back/modif_profil" method="POST">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="firstname" class="form-label">Prénom</label>
                                            <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($userInfo['firstname']); ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="lastname" class="form-label">Nom</label>
                                            <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($userInfo['lastname']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userInfo['email']); ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tel" class="form-label">Téléphone</label>
                                            <input type="tel" class="form-control" id="tel" name="tel" value="<?php echo htmlspecialchars($userInfo['tel']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">Nouveau mot de passe</label>
                                            <input type="password" class="form-control" name="password" placeholder="Votre mot de passe" id="password">
                                            <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirmez votre mot de passe" id="confirm_password">
                                        </div>
                                    </div>
                                    <?php if ($userInfo['statut'] == '1'): ?>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="job" class="form-label">Poste recherché</label>
                                            <select id="job" class="form-select" name="job" required>
                                                <option selected>Sélectionner un poste</option>
                                                <?php foreach ($infos_job as $info_job): ?>
                                                    <option value="<?php echo $info_job['name']; ?>" <?php if ($userInfo['job'] == $info_job['name']) { echo 'selected'; } ?>><?php echo htmlspecialchars($info_job['name']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <button type="submit" class="btn btn-primary">Sauvegarder les modifications</button>
                                </form>
                                <?php 

                                

                                
                                
                                if ($userInfo['statut'] == '1'){
                                    $q="SELECT nom FROM CV WHERE user_id=?;";
                                    $req=$bdd->prepare($q);
                                    $req->execute([
                                        $user_id
                                    ]);
                                    $result=$req->fetch(PDO::FETCH_ASSOC);
                                    

                                    if (!empty($result)){
                                        $filename = '../uploads/pdf/' . $result['nom'] . '.pdf';
                                        $public_url = "https://italent.site/uploads/pdf/" . $result['nom'] . ".pdf";
                                        

                                        echo '<a href="'.$public_url.'" target="_blank" class="btn btn-primary mt-3">Afficher le CV</a>';
                                        echo '<a id="signature" href="" class="btn btn-primary mt-3 mx-3" target="_blank">Regénérer le CV en PDF</a>';
                                    } else {
                                        echo '<a id="signature" href="" target="_blank" class="btn btn-primary mt-3">Télécharger le CV en PDF</a>';                                        
                                    }


                                }
                                    
                                        
                                    ?>

                                <script>
                                    let a=document.getElementById("signature");
                                    let screenWidth = window.innerWidth;
                                    if(a.innerHTML=="Regénérer le CV en PDF"){
                                        if(screenWidth>=426 && screenWidth<=768 ){
                                        a.href="signature?reload=1";
                                        } else {
                                        a.href="back/genPDF?reload=1";
                                        }
                                    } else {
                                        if(screenWidth>=426 && screenWidth<=1024 ){
                                            a.href="signature";
                                        } else {
                                            a.href="back/genPDF";
                                        }
                                    }
                                    
                                </script>
                                        
                                    
                                <a href="back/supp_compte" class="btn btn-danger mt-3" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">Supprimer mon compte</a>
                            </div>
                        </div>
                    </div>


                    <div class="container mt-5">
                        <h3 class="section-title">Storys</h3>
                        <div class="story-bar">
                            <div class="mb-3">
                                <h4>Ajouter une Story</h4>
                                <form action="back/ajout_story" method="POST" enctype="multipart/form-data">
                                    <input type="file" name="image_story" accept="image/\*" required>
                                    <button type="submit" class="btn btn-primary">Publier</button>
                                </form>
                            </div>
                            <?php foreach ($storys as $story): ?>
                                <div class="story-circle me-3 position-relative">
                                    <img src="<?php echo htmlspecialchars('uploads/storys/' . $story['image']); ?>" alt="Image de story" style="width: 100px; height: 100px;"> 
                                    <a href="back/supp_story?story_id=<?php echo $story['story_id']; ?>" class="btn btn-danger btn-sm position-absolute top-0 end-0" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette story ?');">X</a>
                                </div>
                            <?php endforeach; ?>


                        </div>
                    </div>

                    <div class="col-12 mb-4 mt-5">
                        <h3>Publications</h3>
                        <div class="row">
                            <div class="mb-4">
                                <h4>Ajouter une Publication</h4>
                                <form action="back/ajout_publi" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <input type="file" name="image_publication" accept="image/*" required>
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="description" class="form-control" placeholder="Description"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Publier</button>
                                </form>
                            </div>

                            <?php foreach ($publications as $publication): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 position-relative">
                                        <img src="<?php echo htmlspecialchars($publication['image']); ?>" class="card-img-top" alt="Image de publication">
                                        <div class="card-body">
                                            <p class="card-text"><?php echo htmlspecialchars($publication['description']); ?></p>
                                            <a href="back/supp_publi?publi_id=<?php echo $publication['publi_id']; ?>" class="btn btn-danger btn-sm position-absolute top-0 end-0" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette publication ?');">X</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>



                </div>

                
                
                <?php 
                // Si la session est celle d'un étudiant
                if($_SESSION['statut'] == 1){
                $q2 = 'SELECT name,level,validity FROM POSSESSES INNER JOIN COMPETENCES ON COMPETENCES.competence_id=POSSESSES.competence_id WHERE POSSESSES.user_id = ? ;';
                $req2=$bdd->prepare($q2);
                $req2->execute([
                    $_SESSION['user_id']
                ]);
                $competences = $req2->fetchAll(PDO::FETCH_ASSOC);

                if(!empty($competences)){
                    echo '
                    
                    
                    <h3 class="text-center" >Vos compétences</h3>

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
                
                <h3 class="text-center" >Ajouter une compétence à votre CV</h3>

                <form method="post" action="exam">
                    <label class="form-label" for="selectCompetence">Compétence que vous voulez tester:</label>
                    <select id="selectCompetence" class="form-select" name="competenceTest">
                        <option selected>Sélectionner une compétence</option>
                        <?php 
                        while($result3=$req3->fetch(PDO::FETCH_ASSOC)){
                            foreach($result3 as $index=>$value){
                                echo '<option value="'. $value .'">'. $value.'</option>';                   
                            }
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary my-4">Envoyer</button>
                </form>
                <?php
                }
                ?>
            </div>
        </main>

        <script src="js/script.js"></script>
        
        <?php include('includes/footer.php'); ?>
    </body>
</html>