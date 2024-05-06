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
                    $select = 'SELECT * FROM BAN_REQUEST';
                    $res = $bdd->query($select);
                    if ($res->rowCount() > 0) {
                        echo '<table class="table table-striped">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th class="text-center">Id</th>';
                        echo '<th class="text-center">Nom</th>';
                        echo '<th class="text-center">Prénom</th>';
                        echo '<th class="text-center">Email</th>';
                        echo '<th class="text-center">Message</th>';
                        echo '<th class="text-center">Date</th>';
                        echo '<th class="text-center">Actions</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td class="text-center">' . $row['user_id'] . '</td>';
                            echo '<td class="text-center">' . $row['name'] . '</td>';
                            echo '<td class="text-center">' . $row['lastname'] . '</td>';
                            echo '<td class="text-center">' . $row['email'] . '</td>';
                            echo '<td class="text-center">' . $row['message'] . '</td>';
                            echo '<td class="text-center">' . $row['date'] . '</td>';
                            echo '<td class="text-center"><a href="back/check_ban?id_user=' . $row['user_id'] . '&admin=1">Débannir</a></td>';
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
                    $select = 'SELECT id, reason, date_ban FROM BAN';
                    $res = $bdd->query($select);
                    if ($res->rowCount() > 0) {
                        echo '<table class="table table-striped">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th class="text-center">Id</th>';
                        echo '<th class="text-center">Raison</th>';
                        echo '<th class="text-center">Date</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td class="text-center">' . $row['id'] . '</td>';
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