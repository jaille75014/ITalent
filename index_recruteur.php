<?php 
    session_start(); 
    include('includes/header_location.php');
    include('includes/fonctions_logs.php');
    include("includes/bd.php");
    if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 2) {
        redirectFailure('index', 'Vous n\'avez pas les droits pour accéder à cette page.');
    }
    if(!isset($_SESSION['captcha'])){
        redirectFailure('captcha', 'Chipeur arrête de chipper !');
    } 
    
    // Get filter values from POST or GET request
    $competence_name = isset($_POST['competence']) ? $_POST['competence'] : '';
    $level = isset($_POST['level']) ? $_POST['level'] : '';
    $poste = isset($_POST['poste']) ? $_POST['poste'] : '';
    
    // Get competence_id for the given competence_name
    $competence_id_query = 'SELECT competence_id FROM COMPETENCES WHERE name LIKE :name';
    $req = $bdd->prepare($competence_id_query);
    $req->execute([
        'name'=> '%' . $competence_name . '%'
    ]);	
    $comp_id = $req->fetchAll(PDO::FETCH_ASSOC);
    $competence_id = isset($comp_id['competence_id']) ? $comp_id['competence_id'] : '';
    
    // Obtenir les informations des étudiants
    $get_infos = 'SELECT USERS.user_id, USERS.lastname, USERS.firstname, USERS.city, USERS.tel, USERS.email, USERS.image, JOBS.name, COMPETENCES.name AS competence_name FROM USERS 
    LEFT JOIN JOBS ON USERS.student_job = JOBS.id 
    LEFT JOIN POSSESSES ON USERS.user_id = POSSESSES.user_id 
    LEFT JOIN COMPETENCES ON POSSESSES.competence_id = COMPETENCES.competence_id 
    WHERE USERS.statut = 1';
    
    // Ajouter les potentielles conditions de filtre à la requête
    if (!empty($competence_id)) {
        $get_infos .= " AND POSSESSES.competence_id = " . htmlspecialchars($competence_id);
    }
    if (!empty($level)) {
        $get_infos .= " AND POSSESSES.level >= " . htmlspecialchars($level);
    }
    if (!empty($poste)) {
        $get_infos .= " AND JOBS.name LIKE '%" . htmlspecialchars($poste) . "%'";
    }

    
    $req = $bdd->prepare($get_infos);
    $req->execute();
    $donnees = $req->fetchAll(PDO::FETCH_ASSOC);

    // mélanger les users pour un affichage aléatoire. 
    shuffle($donnees);
?>

<!DOCTYPE html>
<html>

<?php 
$title='Recruteur';
$url = 'index_recruteur'; //Permet de revenir sur cette page en cas d'erreurs dans les pages newsletter
include('includes/head.php');?>

    <body class="bg-light">

    <?php include('includes/header.php');?>

    <main class="bg-light">

    <div class="banner-recruiter">
        <img src="assets/banner_recruteur.jpg" alt="Bannière recruteur">
        <h1>ESPACE RECRUTEUR</h1>
        <p>Chercher des étudiants que vous souhaitez en filtrant vos recherches pour pouvoir discuter avec eux</p>
    <div class="search-container">
        <form id="searchForm" class="d-flex justify-content-center align-items-end" method="post" action="">
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
                <select class="form-control" id="poste" name="poste">
                    <option value="">Poste</option>
                    <option value="CDD">CDD</option>
                    <option value="CDI">CDI</option>
                    <option value="Stage">Stage</option>
                    <option value="Alternance">Alternance</option>
                    <option value="Apprentissage">Apprentissage</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Filtrer">
            </div>
        </form>
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
                        <h3 class="username"><?= $user['email'] ?></h3>
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
                    <p><?= $user['tel'] ?></p>
                </div>
                <div class="contact">
                    <a href="messagerie?user_id=<?= $user['user_id'] ?>" class="btn btn-primary">Contacter</a>
                </div>
                <div class="action">
                    <div class="icon">
                        <input type="hidden" class="user_followed" value="<?= $user['user_id'] ?>">
                        <input type="hidden" class="user_follower" value="<?= $_SESSION['user_id'] ?>">
                        <button onclick="follow(this)"><i class="bi bi-person-plus my-icon"></i></button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <script src="js/script.js"></script>
        
        </main>

        <?php include('includes/footer.php');?>
    
    </body>
</html>