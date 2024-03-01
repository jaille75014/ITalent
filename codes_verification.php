<?php
include("includes/bd.php");
    if(!isset($_POST['code'])
    || empty($_POST['code'])){
        header('location: verification_email.php?message=Vous vous êtes trompé dans l\'écriture du code ou de votre email');
        exit;
    }
        $q = 'SELECT email_number FROM USERS WHERE email = ' . htmlspecialchars($_POST['email']); 
        echo $q;
        // Vérifie si le code correspond à celui inscrit dans la bdd
        if($_POST['code'] == $q){
            // Si c'est le cas, on valide l'email
            $q = 'INSERT INTO USERS (email_check) VALUES (1) WHERE email =' . htmlspecialchars($_POST['email']);
            header('location: connexion.php?messageSuccess=Inscription valide, veuillez vous connecter');
            exit;
        } else {
            /*
            header('location: inscription.php?messageFailure=Reessaye !');
            exit;
        }
        */
?>