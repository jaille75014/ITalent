<?php

session_start(); 

?>


<!DOCTYPE html>
<html>
    <?php 
    $title='Error 403';
    include('/var/www/html/includes/head.php');
    ?>

    <body class="bg-light">

        <?php include('/var/www/html/includes/header.php');?>

        <main>

            <h1 class="error text-center text-danger my-5">ERREUR 403</h1>
            <p class="text-center">Vous n'êtes pas autorisé à accéder à cette page !</p>


        </main>

    </body>

</html>