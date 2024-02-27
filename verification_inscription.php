<?php 

if (isset($_POST['email'])&& !empty($_POST['email'])){
    setcookie('email', $_POST['email'], time()+30*24*3600); // Cookie expire dans 30 jours
    
}

if(!isset($_POST['student']) || empty($_POST['student'])
    || !isset($_POST['recruiter']) || empty($_POST['recruiter'])){
        header("location: inscription.php?message=Woah, tentez au moins de vous inscrire honêtement !" ); // Redirection vers connexion.php
        exit; //Interrompt le code
    }


if(isset($_POST['student']) && !empty($_POST['student'])){



    if(!isset($_POST['lastname'])
        || empty($_POST['lastname'])
        || !isset($_POST['firstname'])
        || empty ($_POST['firstname'])
        || !isset($_POST['email'])
        || empty ($_POST['email'])
        || !isset($_POST['phone'])
        || empty ($_POST['phone'])
        || !isset($_POST['password'])
        || empty ($_POST['password'])
        || !isset($_POST['city'])
        || empty ($_POST['city'])
        || !isset($_POST['zip'])
        || empty ($_POST['zip'])){

            header("location: inscription.php?message=Vous devez remplir tous les champs !" ); // Redirection vers connexion.php
            exit; //Interrompt le code
    }
}













?>