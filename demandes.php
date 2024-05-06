<?php
session_start();
include("includes/bd.php");
include("includes/header_location.php");
if(!isset($_SESSION['statut']) || $_SESSION['statut'] != 3) {
    redirectFailure('connexion' , 'Vous n\'avez pas les droits pour accéder à cette page');
}


?>
<html>
<?php 
$title='Demandes de débannissements';
$url = 'demande'; // Permet de revenir sur cette page en cas d'erreurs dans les pages newsletter
include('includes/head.php');?>
<body class="bg-light">
    <?php
        include("includes/header.php");
    ?>
    <main>

    <?php 
    if(isset($_GET['messageFailure'])){
    echo '<div class="alert alert-danger" role="alert">'.htmlspecialchars($_GET['messageFailure']).'</div>'; 
    }
    if(isset($_GET['messageSuccess'])){
        echo '<div class="alert alert-success" role="alert">'.htmlspecialchars($_GET['messageSuccess']).'</div>'; 
        }
    ?>

    <div class="container">
        
        <h1 class="text-center">Demandes de <span class="text-primary">débannissements</span></h1>
            
        
        <div class="row">
            <div class="col-12 my-4">
                <?php
                    $select = 'SELECT user_id,firstname,lastname,message,date FROM BAN_REQUEST';
                    $res = $bdd->query($select);
                    if ($res->rowCount() > 0) {
                        echo '<table class="text-center table table-striped">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>Id User</th>';
                        echo '<th>Nom</th>';
                        echo '<th>Prénom</th>';
                        echo '<th>Message</th>';
                        echo '<th>Date</th>';
                        echo '<th>Actions</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td>' . $row['user_id'] . '</td>';
                            echo '<td>' . $row['lastname'] . '</td>';
                            echo '<td>' . $row['firstname'] . '</td>';
                            echo '<td>' . $row['message'] . '</td>';
                            echo '<td>' . $row['date'] . '</td>';
                            echo '<td><a href="back/check_ban?id_user=' . $row['user_id'] . '&admin=1">Débannir</a></td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        echo 'Aucune demande de débannissement pour le moment';
                    }
                ?>
            </div>
        </div>
        
        <h1 class="text-center">Utilisateurs <span class="text-primary">bannis</span></h1>
         
        <div class="row">
            <div class="col-12 my-4">
                <?php
                    $select = 'SELECT BAN.user_id,lastname,firstname, reason, date_ban FROM BAN INNER JOIN USERS ON BAN.user_id=USERS.user_id';
                    $res = $bdd->query($select);
                    if ($res->rowCount() > 0) {
                        echo '<table class="table table-striped">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th class="text-center">Id User</th>';
                        echo '<th class="text-center">Lastname</th>';
                        echo '<th class="text-center">Firstname</th>';
                        echo '<th class="text-center">Raison</th>';
                        echo '<th class="text-center">Date</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td class="text-center">' . $row['user_id'] . '</td>';
                            echo '<td class="text-center">' . $row['lastname'] . '</td>';
                            echo '<td class="text-center">' . $row['firstname'] . '</td>';
                            echo '<td class="text-center">' . $row['reason'] . '</td>';
                            echo '<td class="text-center">' . $row['date_ban'] . '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        echo 'Aucun utilisateur banni pour le moment';
                    }
                ?>
            </div>
        </div>  
    </div>
    </main>
    <?php include('includes/footer.php'); ?>
</body>
</html>