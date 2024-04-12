<!DOCTYPE html>
<html>
<?php 

include("includes/bd.php");
$title='Blabla';
include("includes/head.php");
// Requete pour récuperer le nom, prénom, la ville, le numéro de téléphone, l'email, l'image et le nom du job
$req = $bdd->prepare('SELECT USERS.lastname, USERS.firstname, USERS.city, USERS.phone, USER.email, USERS.image, JOBS.name FROM USERS WHERE status = 1 INNER JOIN JOBS ON USERS.student_job = JOBS.id');
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
                    <p>Alternance</p>
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
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main> 
</body> 
</html>