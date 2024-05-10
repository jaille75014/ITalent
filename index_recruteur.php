<?php 
    session_start(); 
    include('includes/header_location.php');
    include("includes/bd.php");
    if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 2) {
        redirectFailure('index', 'Vous n\'avez pas les droits pour accéder à cette page.');
    }
    if(!isset($_SESSION['captcha'])){
        redirectFailure('captcha', 'Chipeur arrête de chipper !');
    } 


    $competence_name = isset($_POST['competence']) ? htmlspecialchars($_POST['competence']) : '';
    $level = isset($_POST['niveau']) ? htmlspecialchars($_POST['niveau']) : '';
    $poste = isset($_POST['poste']) ? htmlspecialchars($_POST['poste']) : '';

    $_SESSION['filters'] = [
        'competence' => $competence_name,
        'level' => $level,
        'poste' => $poste
    ];

    if (!empty($competence_name) || !empty($level)) {
        $competence_id_query = 'SELECT competence_id FROM COMPETENCES WHERE name LIKE :name';
        $req = $bdd->prepare($competence_id_query);
        $req->execute([
            'name'=> '%' . $competence_name . '%'
        ]);	
        $comp_ids = $req->fetchAll(PDO::FETCH_ASSOC);
        
        $competence_ids = array_column($comp_ids, 'competence_id');
        
        $level = intval($level);
    }
    
    // Obtenir les informations des étudiants
    $get_infos = 'SELECT USERS.user_id, USERS.lastname, USERS.firstname, USERS.city, USERS.tel, USERS.email, USERS.image, JOBS.name AS job_name, COMPETENCES.name AS competence_name FROM USERS 
        LEFT JOIN JOBS ON USERS.student_job = JOBS.id 
        LEFT JOIN POSSESSES ON USERS.user_id = POSSESSES.user_id 
        LEFT JOIN COMPETENCES ON POSSESSES.competence_id = COMPETENCES.competence_id 
        WHERE USERS.statut = 1';
        
    // Ajouter les potentielles conditions de filtre à la requête
    if (!empty($competence_ids)) {
        $get_infos .= " AND POSSESSES.competence_id IN (" . implode(',', array_map('intval', $competence_ids)) . ")";
    }
    if (!empty($level)) {
        $get_infos .= " AND POSSESSES.level >= " . $level;
    }
    if (!empty($poste)) {
        $get_infos .= " AND JOBS.name LIKE '%" . htmlspecialchars($poste) . "%'";
    }
    
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // (int) verifie que c'est un nombre pour éviter les injections
    $users_per_page = 5; // Affiche 5 users par page
    $offset = ($page - 1) * $users_per_page; // cette ligne permet de définir le nombre de users à afficher par page

    $get_infos .= " LIMIT $users_per_page OFFSET $offset";

    
    $req = $bdd->prepare($get_infos);
    $req->execute();
    $donnees = $req->fetchAll(PDO::FETCH_ASSOC);

    // Générer une clé unique pour chaque combinaison de filtres
    $filter_key = md5($competence_name . $level . $poste);

    // Avant de mélanger les utilisateurs, vérifiez si l'ordre des utilisateurs est déjà stocké dans une variable de session
    if (!isset($_SESSION['user_order'][$filter_key])) {
        shuffle($donnees);
        // Stockez l'ordre des utilisateurs dans une variable de session
        $_SESSION['user_order'][$filter_key] = array_column($donnees, 'user_id');
    } else {
        // Trier les utilisateurs en fonction de l'ordre stocké dans la variable de session
        usort($donnees, function ($a, $b) use ($filter_key) {
            return array_search($a['user_id'], $_SESSION['user_order'][$filter_key]) - array_search($b['user_id'], $_SESSION['user_order'][$filter_key]);
        });
    }

    $total_pages_query = "SELECT COUNT(*) FROM USERS 
    LEFT JOIN JOBS ON USERS.student_job = JOBS.id 
    LEFT JOIN POSSESSES ON USERS.user_id = POSSESSES.user_id 
    LEFT JOIN COMPETENCES ON POSSESSES.competence_id = COMPETENCES.competence_id 
    WHERE USERS.statut = 1";

    if (!empty($competence_ids)) {
        $total_pages_query .= " AND POSSESSES.competence_id IN (" . implode(',', array_map('intval', $competence_ids)) . ")";
    }
    if (!empty($level)) {
        $total_pages_query .= " AND POSSESSES.level >= " . $level;
    }
    if (!empty($poste)) {
        $total_pages_query .= " AND JOBS.name LIKE '%" . $poste . "%'";
    }

    $req = $bdd->prepare($total_pages_query);
    $req->execute();
    $total_users = $req->fetchColumn();
    $total_pages = ceil($total_users / $users_per_page);
?>

<!DOCTYPE html>
<html>

<?php 
    include('includes/fonctions_logs.php');

    $title='Recruteur';
    $url = 'index_recruteur'; // Utilisé pour revenir sur cette page en cas d'erreurs dans les pages newsletter
    include('includes/head.php');

    writeVisitLog($url);
?>

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
                    <option value="3">Débutant</option>
                    <option value="4">Intermédiaire</option>
                    <option value="5">Avancé</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" id="poste" name="poste">
                    <option value="">Poste</option>
                    <option value="CDD">CDD</option>
                    <option value="CDI">CDI</option>
                    <option value="Stage">Stage</option>
                    <option value="Alternance">Alternance</option>
                    <option value="Professionnalisation">Professionnalisation</option>
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

        
        <?php foreach ($donnees as $user): ?>
            <div class="list">
            <div class="row align-items-center line">
                <div class="col-2">
                    <div class="col-3 profile">
                        <a href="profil_etudiant?id=<?= $user['user_id'] ?>" title="Voir le profil">
                        <img src="<?= $user['image'] ?>" alt="photo de profil">
                        </a>
                    </div>
                    <div class="col-9">
                        <p class="name"><?=$user['lastname'] . ' ' . $user['firstname']?></p>
                        <p class="username"><?= $user['email'] ?></p>
                    </div>
                </div>
                <div class="col-2">
                    <span></span>
                    <p><?= empty($user['job_name']) ? 'Type de contrat non précisé' : $user['job_name']; ?></p>                 
                </div>
                <div class="col-2">
                    <p><?= $user['city'] ?></p>
                </div>
                <div class="col-2">
                    <?php 
                    $filename = "uploads/pdf/cv_" . $user['user_id'] . ".pdf";
                    $pdf_url = "http://italent.site/uploads/pdf/cv_" . $user['user_id'] . ".pdf";

                    if (file_exists($filename)): ?>
                        <a href="<?php echo $pdf_url; ?>" class="btn btn-info">Voir le CV en PDF</a>
                    <?php else: ?>
                        <p>L'utilisateur n'a pas de CV</p>
                    <?php endif; ?>
                </div>
                <div class="col-2">
                    <a href="messagerie?user_id=<?= $user['user_id'] ?>" class="btn btn-primary">Contacter</a>
                </div>
                <div class="col-2">
                    <div class="icon">
                        <input type="hidden" class="user_followed" value="<?= $user['user_id'] ?>">
                        <input type="hidden" class="user_follower" value="<?= $_SESSION['user_id'] ?>">
                        <button onclick="follow(this)"><i class="bi bi-person-plus my-icon"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; 

        $start = $page;
        $end = min($total_pages, $page + 2); // Affiche 3 pages à la fois, a chaque fois qu'on passe a la page suivante, il affiche 1 pages suivantes
        
        if ($page > 1) {
            echo "<button class='btn btn-primary' onclick=\"location.href='index_recruteur.php?page=" . ($page - 1) . "'\">Précédent</button> ";
        }
        
        for ($i = $start; $i <= $end; $i++) {
        $class = $i == $page ? "btn btn-primary mx-5 py-2" : "btn btn-primary";
        echo "<button class='$class' onclick=\"location.href='index_recruteur?page=$i'\">$i</button> ";
        }
        ?>
    
    <script src="js/script.js"></script>
    <script src="js/load.js"></script>
        
        </main>

        <?php include('includes/footer.php');?>
    
    </body>
</html>