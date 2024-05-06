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

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Logs d'erreur Apache :</h5>
                <?php if (!empty($apache_error_logs)): ?>
                    <?php
                    $log_entries = explode("\n", $apache_error_logs);
                    ?>
                    <div class="accordion" id="logAccordion">
                        <?php foreach ($log_entries as $index => $log_entry): ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="logHeading<?php echo $index; ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#logCollapse<?php echo $index; ?>" aria-expanded="false" aria-controls="logCollapse<?php echo $index; ?>">
                                        Log <?php echo $index + 1; ?>
                                    </button>
                                </h2>
                                <div id="logCollapse<?php echo $index; ?>" class="accordion-collapse collapse" aria-labelledby="logHeading<?php echo $index; ?>" data-bs-parent="#logAccordion">
                                    <div class="accordion-body">
                                        <?php echo htmlspecialchars($log_entry); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>Aucun log d'erreur Apache disponible.</p>
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