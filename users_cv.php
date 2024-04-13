<!DOCTYPE html>
<html>
<?php 

include("includes/bd.php");
$title='Blabla';
include("includes/head.php");
// Requete pour récuperer le nom, prénom, la ville, le numéro de téléphone, l'email, l'image et le nom du job
$get_infos = 'SELECT USERS.user_id, USERS.lastname, USERS.firstname, USERS.city, USERS.phone, USERS.email, USERS.image, JOBS.name FROM USERS INNER JOIN JOBS ON USERS.student_job = JOBS.id WHERE USERS.status = 1 LIMIT 20';
$req = $bdd->prepare($get_infos);
$req->execute();
$donnees = $req->fetchAll(PDO::FETCH_ASSOC);

// mélanger les users
shuffle($donnees);

?>
<body>
<?php include("includes/header.php"); ?>   
<main>
    <div class="list">
        <?php foreach ($donnees as $user): ?>
            <div class="line">
                <div class="user">
                    <div class="profile">
                        <img src="<?= $user['image'] ?>" alt="" width="50px" height="50px">
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
                    <a href="#" class="btn btn-primary">Contacter</a>
                </div>
                <div class="action">
                    <div class="icon">
                        <input type="hidden" id="user_followed" value="<?= $user['user_id'] ?>">
                        <input type="hidden" id="user_follower" value="<?= $_SESSION['user_id'] ?>">
                        <button onclick="follow()"><i class="bi bi-person-fill-add"></i></button>
                    </div>
                </div>
            </div>
            <button id="loadUsers" class="btn btn-primary " onclick="loadMoreUsers()">Charger plus de Candidats</button> <!-- Bouton pour charger plus de candidats -->
        <?php endforeach; ?>
    </div>
    <script src="js/script.js"></script>
</main> 
</body> 
</html>