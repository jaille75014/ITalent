<?php 
session_start();
//include("includes/bd.php");
/* $req = 'SELECT date_ban, reason FROM BAN WHERE id = ' . $_SESSION['user_id'];
$res = $bdd->query($req);
if ($res->rowCount() > 0) {
    $row = $res->fetch(PDO::FETCH_ASSOC);
    $banDate = $row['date_ban'];
    $reason = $row['reason'];
} else {
    $banDate = "Banni indéfiniment";
    $reason = "Inconnue";
}


            <p>Votre compte a été suspendu et sera définitivement supprimé le : <?= $banDate ?></p>
            <p>Raison : <?= $reason ?></p>

            <h2>Que faire ?</h2>
            <p>Si vous pensez que le bannissement de votre compte est injustifié, vous pouvez remplir ce formulaire pour contacter les administrateurs :</p>
        
*/
?>
<html>
    <?php 
    include("includes/head.php");
    ?>
    <body>
        <main>

        <div class="container_perso">
            <div class="img">
                <img src="assets/undraw_personalization_re_grty.svg" alt="photo">
            </div>
        <div class="container_perso">
        <form action="back/request_unban" class="form_perso" method="POST">
            <img class="avatar" src="assets/undraw_pic_profile_re_7g2h.svg" alt="Photo de profile">
            <h1>Ohh.. Vous avez été banni !</h1>
            <div class="input-div one">
                <div class="i">
                    <i class="fas fa-user"></i>
                </div>
            <div>
                <h5>Votre email</h5>
                <input type="text" class="input">
            </div>
            </div>
            <div class="input-div two">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                <div>
                    <h5>Votre requête</h5>
                    <input type="text" class="input">
                </div>
            </div>
            <input type="submit" class="btn" value="Envoyer">
        </form>
        </div>
        </div>
        <script src="js/script.js"></script> 
        </main>
    </body>
</html>