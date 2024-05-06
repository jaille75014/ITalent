<?php  
    session_start(); 

    if (!isset($_SESSION['captcha'])) {
        header('location:captcha?error=Chipeur arrête de chipper !');
        exit;
    }

    if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 3) {
        header('location:index');
        exit;
    }

    include('includes/fonctions_logs.php');
    include('includes/head.php');

    $log_file = 'logs/logs.txt';
    $log_entries = [];
    if (file_exists($log_file)) {
        $log_entries = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }
?>

<!DOCTYPE html>
<html lang="fr">

<?php 
$title='Logs';
$url = 'admin_log'; //Permet de revenir sur cette page en cas d'erreurs dans les pages newsletter
include('includes/head.php');?>


<body class="bg-light">
    <?php include('includes/header.php'); ?>

    <div class="container">
        <h3>Logs du site</h3>

        <p>Nombre total d'entrées dans les logs : <?php echo count($log_entries); ?></p>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th class="text-center">Date/Heure</th>
                        <th class="text-center">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($log_entries as $log_entry) {
                        list($timestamp, $description) = explode('|', $log_entry, 2);
                        echo "<tr><td class='text-center'>$timestamp</td><td>$description</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <h5>Télécharger les logs</h5>
            <form action="download_logs.php" method="post">
                <button type="submit" class="btn btn-primary">Télécharger les logs</button>
            </form>
        </div>


    </div>

    <?php include('includes/footer.php'); ?>
</body>