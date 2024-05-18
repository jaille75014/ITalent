<?php

session_start(); 

?>


<!DOCTYPE html>
<html>
    <?php 
    $title='Error 404';
    include('/var/www/html/includes/head.php');
    ?>

    <body class="bg-light">

        <?php include('/var/www/html/includes/header.php');?>

        <main>

            <h1 class="error text-center text-danger my-5">ERREUR 404</h1>
            <p class="text-center">La page n'existe pas !</p>


        </main>

    </body>

</html>