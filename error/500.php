<?php

session_start(); 

?>


<!DOCTYPE html>
<html>
    <?php 
    $title='Error 500';
    include('/var/www/html/includes/head.php');
    ?>

    <body class="bg-light">

        <?php include('/var/www/html/includes/header.php');?>

        <main>

            <h1 class="error text-center text-danger my-5">ERREUR 500</h1>
            <p class="text-center">Désolé, vous avez rencontré une erreur... Nous essayons de résoudre ce problème.</p>


        </main>

    </body>

</html>