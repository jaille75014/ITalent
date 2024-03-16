<?php
include("includes/bd.php");
if(!isset($_POST['code']) || empty($_POST['code']) || !isset($_POST['email']) || empty($_POST['email'])){
    header('location: verification_email.php?message=Vous vous êtes trompé dans l\'écriture du code ou de votre email');
    exit;
    }
    $q = 'SELECT email_number FROM USERS WHERE email = :email';
    $req = $bdd->prepare($q);
    $result = $req->execute([
        'email' => htmlspecialchars($_POST['email'])
    ]);
    $results = $req->fetch();
        // Vérifie si le code correspond à celui inscrit dans la bdd
        if ($_POST['code'] == $results['email_number']) {
            // Si c'est le cas, on valide l'email
            $q = 'UPDATE USERS SET email_check = 1 WHERE email = :email';
            $req = $bdd->prepare($q);
            $result = $req->execute([
                'email' => htmlspecialchars($_POST['email'])
            ]);  
            header('location: ../connexion.php?messageSuccess=Inscription valide, veuillez vous connecter');
            exit;
        } else {
            header('location: verification_email.php?messageFailure=Erreur lors de l\'ecriture du code');
            exit;
        }
        
?>