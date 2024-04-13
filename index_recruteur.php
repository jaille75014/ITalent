<?php 
    session_start(); 
    include('includes/header_location.php');
    include('includes/fonctions_logs.php');
    include("includes/bd.php");
    if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 2) {
        redirectFailure('index.php', 'Vous n\'avez pas les droits pour accéder à cette page.');
    }
    if(!isset($_SESSION['captcha'])){
        redirectFailure('captcha.php', 'Chipeur arrête de chipper !');
    } 
    
    // Requete pour récuperer le nom, prénom, la ville, le numéro de téléphone, l'email, l'image et le nom du job
$get_infos = 'SELECT USERS.user_id, USERS.lastname, USERS.firstname, USERS.city, USERS.tel, USERS.email, USERS.image, JOBS.name FROM USERS INNER JOIN JOBS ON USERS.student_job = JOBS.id WHERE USERS.statut = 1 LIMIT 20';
$req = $bdd->prepare($get_infos);
$req->execute();
$donnees = $req->fetchAll(PDO::FETCH_ASSOC);

// mélanger les users
shuffle($donnees);

    
    
?>

<!DOCTYPE html>
<html>

<?php 
$title='Recruteur';
$url = 'index_recruteur.php'; //Permet de revenir sur cette page en cas d'erreurs dans les pages newsletter
include('includes/head.php');?>

    <body class="bg-light">

    <?php include('includes/header.php');?>

    <main class="bg-light">

    <div class="banner-recruiter">
        <img src="assets/banner_recruteur.jpg" alt="Bannière recruteur">
        <h1>ESPACE RECRUTEUR</h1>
        <p>Chercher des étudiants que vous souhaitez en filtrant vos recherches pour pouvoir discuter avec eux</p>
        <div class="search-container">
            <div id="searchForm" class="d-flex justify-content-center align-items-end">
                <div class="form-group">
                    <input type="text" class="form-control" id="competence" name="competence" placeholder="Compétence">
                </div>
                <div class="form-group">
                    <select class="form-control" id="niveau" name="niveau">
                        <option value="">Niveau</option>
                        <option value="Débutant">Débutant</option>
                        <option value="Intermédiaire">Intermédiaire</option>
                        <option value="Avancé">Avancé</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="poste" name="poste" placeholder="Poste">
                </div>
            </div>
        </div>
    </div>
   


        <div class="row py-5 gy-4">
            <h1 class="text-center">CV Etudiants</h1>
        </div>

        <div class="list">
        <?php foreach ($donnees as $user): ?>
            <div class="line">
                <div class="user">
                    <div class="profile">
                        <img src="<?= $user['image'] ?>" alt="photo de profil">
                    </div>
                    <div class="details">
                        <h1 class="name"><?=$user['lastname'] . ' ' . $user['firstname']?></h1>
                        <h3 class="username"><?php $user['email'] ?></h3>
                    </div>
                </div>
                <div class="status">
                    <span></span>
                    <p><?= $user['name'] == 0 ? 'Type de contrat non précisé' : $user['name']; ?></p>                
                </div>
                <div class="location">
                    <p><?= $user['city'] ?></p>
                </div>
                <div class="phone">
                    <p><?= $user['phone'] ?></p>
                </div>
                <div class="contact">
                    <a href="messagerie.php?user_id=<?= $user['user_id'] ?>" class="btn btn-primary">Contacter</a>
                </div>
                <div class="action">
                    <div class="icon">
                        <input type="hidden" id="user_followed" value="<?= $user['user_id'] ?>">
                        <input type="hidden" id="user_follower" value="<?= $_SESSION['user_id'] ?>">
                        <button onclick="follow()"><i class="bi bi-person-fill-add"></i></button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <script src="js/script.js"></script>


        <script src="js/script.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
        
        </main>

        <?php include('includes/footer.php');?>
    
    </body>
</html>