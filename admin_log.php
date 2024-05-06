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

    function readApacheErrorLog($log_file) {
        $log_content = '';
        if (file_exists($log_file)) {
            $log_content = file_get_contents($log_file);
        }
        return $log_content;
    }

    $apache_error_log_file = '/var/log/apache2/error.log';

    $apache_error_logs = readApacheErrorLog($apache_error_log_file);
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

        <p>Logs d'erreur Apache :</p>
        <pre><?php echo htmlspecialchars($apache_error_logs); ?></pre>


        <div class="mt-3">
            <h5>Télécharger les logs</h5>
            <form action="back/download_logs.php" method="post">
                <button type="submit" class="btn btn-primary">Télécharger les logs</button>
            </form>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
</body>