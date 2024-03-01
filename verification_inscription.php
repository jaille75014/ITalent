<?php 

if (isset($_POST['email'])&& !empty($_POST['email'])){
    setcookie('email', $_POST['email'], time()+30*24*3600); // Cookie expire dans 30 jours
    
}

// if(!isset($_POST['email_pro']) || empty($_POST['email_pro'])
//     || !isset($_POST['email']) || empty($_POST['email'])){
//         header("location: inscription.php?message=Woah, tentez au moins de vous inscrire honêtement !" ); // Redirection vers connexion.php
//         exit; //Interrompt le code
//     }


if(isset($_POST['email'])){

    


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

            header("location: inscription.php?messageFailure=Vous devez remplir tous les champs !" ); // Redirection vers connexion.php
            exit; //Interrompt le code
    }

    if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        header('location: inscription.php?messageFailure=Votre email est invalide :('); 
        exit;
    }

    if (strlen($_POST['password'])<8){
        header('location: inscription.php?messageFailure=Votre mot de passe doit être d\'au moins 8 caractères.'); 
        exit;
    }

    include('includes/bd.php');
    $q= 'SELECT user_id FROM USERS WHERE email=:email';
    $req=$bdd->prepare($q);
        $req->execute([
        'email'=>$_POST['email'], 
        ]);
    $results=$req->fetchAll();
    if (!empty($results)){
        header('location: inscription.php?messageFailure=Email déjà utilisé :((('); 
        exit;
    }

    $salt = 'SANANESL3PLUSBEAUDUMONDEETDELESGIJEPENSEQUILA49ANS';
    $mdp_salt = $_POST['password'] . $salt;
    // Hashage du mot de passe
    $password = hash('sha512', $mdp_salt); 

    $q= 'INSERT INTO USERS (lastname,firstname,email,password,tel,zip,city,statut,email_check) VALUES (:lastname,:firstname,:email,:password,:tel,:zip,:city,:statut,:email_check)';
    $req=$bdd->prepare($q);
    $result=$req->execute([
        'lastname'=>$_POST['lastname'], 
        'firstname'=>$_POST['firstname'], 
        'email'=>$_POST['email'], 
        'password'=>$password,
        'tel'=>$_POST['phone'], 
        'zip'=>$_POST['zip'], 
        'city'=>$_POST['city'],
        'statut' => 1,
        'email_check' => 0
        ]);    

    if ($result){
        header('location: verification_email.php?mail=' . $_POST['email']);
        exit;
    } else {
        header('location: inscription.php?messageFailure=Erreur lors de la création du compte, veuillez recommencer.');
        exit;
    }




} else if(isset($_POST['email_pro']) ){

    


    if(!isset($_POST['lastname'])
        || empty($_POST['lastname'])
        || !isset($_POST['firstname'])
        || empty ($_POST['firstname'])
        || !isset($_POST['email_pro'])
        || empty ($_POST['email_pro'])
        || !isset($_POST['name_factory'])
        || empty ($_POST['name_factory'])
        || !isset($_POST['password'])
        || empty ($_POST['password'])
        || !isset($_POST['city'])
        || empty ($_POST['city'])
        || !isset($_POST['zip'])
        || empty ($_POST['zip'])){

            header("location: inscription.php?messageFailure=Vous devez remplir tous les champs !" ); // Redirection vers connexion.php
            exit; //Interrompt le code
    }


    if (!filter_var($_POST['email_pro'],FILTER_VALIDATE_EMAIL)){
        header('location: inscription.php?messageFailure=Votre email est invalide :('); 
        exit;
    }

    if (strlen($_POST['password'])<8){
        header('location: inscription.php?messageFailure=Votre mot de passe doit être d\'au moins 8 caractères.'); 
        exit;
    }

    include('includes/bd.php');
    $q= 'SELECT user_id FROM USERS WHERE email=:email';
    $req=$bdd->prepare($q);
        $req->execute([
        'email'=>$_POST['email'], 
        ]);
    $results=$req->fetchAll();
    if (!empty($results)){
        header('location: inscription.php?messageFailure=Email déjà utilisé :((('); 
        exit;
    }

    $salt = 'SANANESL3PLUSBEAUDUMONDEETDELESGIJEPENSEQUILA49ANS';
    $mdp_salt = $_POST['password'] . $salt;
    // Hashage du mot de passe
    $password = hash('sha512', $mdp_salt); 

    $q= 'INSERT INTO USERS (lastname,firstname,email,password,zip,city,name_factory,statut,email_check) VALUES (:lastname,:firstname,:email,:password,:zip,:city,:name_factory,:statut,:email_check)';
    $req=$bdd->prepare($q);
    $result=$req->execute([
        'lastname'=>$_POST['lastname'], 
        'firstname'=>$_POST['firstname'], 
        'email'=>$_POST['email_pro'], 
        'password'=>$password, 
        'zip'=>$_POST['zip'], 
        'city'=>$_POST['city'],
        'name_factory'=>$_POST['name_factory'],
        'statut' => 2,
        'email_check' => 0
        ]);    

    if ($result){
        header('location: verification_email.php?mail:'.$_POST['email']);
        exit;
    } else {
        header('location: inscription.php?messageFailure=Erreur lors de la création du compte, veuillez recommencer.');
        exit;
    }

} 













?>