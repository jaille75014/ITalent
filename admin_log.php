<?php  
include('includes/fonctions_logs.php'); 
include('includes/header_location.php');
session_start(); 

if (!isset($_SESSION['captcha'])) {
    redirectFailure('index', 'Chippeur arrête de chipper');
}

if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 3) {
    redirectFailure('index', 'Vous n\'avez pas les droits pour accéder à cette page');
}

function readLogFile($log_file) {
    $log_content = '';
    if (file_exists($log_file)) {
        $log_content = file_get_contents($log_file);
    }
    return $log_content;
}

$log_echouees_file = 'logs/log_echouées.txt';
$log_reussies_file = 'logs/log_reussies.txt';
$log_visites_file = 'logs/log_visites.txt';

$log_echouees = readLogFile($log_echouees_file);
$log_reussies = readLogFile($log_reussies_file);
$log_visites = readLogFile($log_visites_file);
?>

<!DOCTYPE html>
<html lang="fr">

    <?php 
    $title='Logs';
    $url = 'admin_log'; // Utilisé pour revenir sur cette page en cas d'erreurs dans les pages newsletter
    include('includes/head.php');
    ?>

    <body class="bg-light">
        <?php include('includes/header.php'); ?>

        <div class="container">
            <h3>Logs du site</h3>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Logs d'échecs de connexion :</h5>
                    <?php if (!empty($log_echouees)): ?>
                        <pre><?php echo htmlspecialchars($log_echouees); ?></pre>
                    <?php else: ?>
                        <pre>Aucun log d'échecs de connexion disponible.</pre>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Logs de connexions réussies :</h5>
                    <?php if (!empty($log_reussies)): ?>
                        <pre><?php echo htmlspecialchars($log_reussies); ?></pre>
                    <?php else: ?>
                        <pre>Aucun log de connexion réussie disponible.</pre>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Logs de visites de page :</h5>
                    <?php if (!empty($log_visites)): ?>
                        <pre><?php echo htmlspecialchars($log_visites); ?></pre>
                    <?php else: ?>
                        <pre>Aucun log de visite de page disponible.</pre>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-3">
                <h5>Télécharger les logs</h5>
                <form action="back/download_logs.php" method="post">
                    <button type="submit" class="btn btn-primary mb-3 mt-3">Télécharger les logs</button>
                </form>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>
    </body>

</html>