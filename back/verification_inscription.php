<?php 

include('../includes/header_location.php');
include('../includes/bd.php');


if (isset($_POST['email'])&& !empty($_POST['email'])){
    setcookie('email', $_POST['email'] , time()+30*24*3600,'/'); // Cookie expire dans 30 jours
} else if (isset($_POST['email_pro']) && !empty($_POST['email_pro'])){
    setcookie('email', $_POST['email_pro'], time()+ 30*24*3600,'/');
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

            redirectFailure('../inscription', 'Vous devez remplir tous les champs !'); // Redirection vers connexion.php
    }

    if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        redirectFailure('../inscription', 'Votre email est invalide :('); 
    }

    if (strlen($_POST['password'])<8){
        redirectFailure('../inscription', 'Votre mot de passe doit être d\'au moins 8 caractères.'); 
    }


    if($_FILES['image']['error']!=4){ // Si un fichier a été uploadé

        // Vérification de son type
        $acceptable=['image/png','image/jpeg','image/gif'];
        if(!in_array($_FILES['image']['type'],$acceptable)){ // Permet de savoir si une valeur est dans un tableau, renvoie true si c'est le cas et non si ce n'est pas le cas
            redirectFailure('../inscription', 'Le fichier doit être un jpeg, png ou gif, ne manipule pas mon code !'); 
        }
        $maxSize=2*1024*1024;
        // Vérification de sa taille
        if($_FILES['image']['size']>$maxSize){ //  On vérifie si la taille est supérieur à 2Mo
            redirectFailure('../inscription', 'Le fichier doit être inférieur à 2Mo!'); 
        }

        if(!file_exists('assets/uploads')){  // Permet de savoir si un fichier / dossier existe, renvoie true si il existe
            mkdir('../assets/uploads'); // Crée le fichier uploads là où on est
        }
        // Enregistrement du fichier sur le serveur
        $from=$_FILES['image']['tmp_name']; // Enplacement temporaire du fichier


        $array=explode('.',$_FILES['image']['name']); //Transformer une chaîne de caractère selon un séparateur, fonction implode() pour concaténer des éléments d'un tableau selon un séparateur
        $ext=end($array); // Récupérer le dernier élément du tableau
        $fileName='image-'.time().'.'.$ext;
        // Risque de doublon si 2 personnes s'inscrit à la même seconde avec la même extension


        $to='../assets/uploads/'.$fileName; // Nom original du fichier
        move_uploaded_file($from,$to);
        $image = 'UPDATE USERS
        SET image = :image
        WHERE email = \''. htmlspecialchars($_POST['email']).'\'';
        $req=$bdd->prepare($image);
            $result=$req->execute([
                'image' => $fileName
                ]);
    }

    $q= 'SELECT user_id FROM USERS WHERE email=:email';
    $req=$bdd->prepare($q);
        $req->execute([
        'email'=>$_POST['email'], 
        ]);
    $results=$req->fetchAll();
    if (!empty($results)){
        redirectFailure('../inscription', 'Email déjà utilisé :(((');
    }

    $salt = 'SANANESL3PLUSBEAUDUMONDEETDELESGIJEPENSEQUILA49ANS';
    $mdp_salt = $_POST['password'] . $salt;
    // Hashage du mot de passe
    $password = hash('sha512', $mdp_salt); 

    $q= 'INSERT INTO USERS (lastname,firstname,email,password,tel,zip,city,statut,email_check) VALUES (:lastname,:firstname,:email,:password,:tel,:zip,:city,:statut,:email_check)';
    $req=$bdd->prepare($q);
    $result=$req->execute([
        'lastname'=>htmlspecialchars($_POST['lastname']), 
        'firstname'=>htmlspecialchars($_POST['firstname']), 
        'email'=>$_POST['email'], 
        'password'=>$password,
        'tel'=>htmlspecialchars($_POST['phone']), 
        'zip'=>htmlspecialchars($_POST['zip']), 
        'city'=>htmlspecialchars($_POST['city']),
        'statut' => 1,
        'email_check' => 0
        ]);    

    if ($result){
        header('location: verification_email?message=' . $_POST['email']);
        exit;
    } else {
        redirectFailure('../inscription?', 'Erreur lors de la création du compte, veuillez recommencer.');
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

        redirectFailure('../inscription', 'Vous devez remplir tous les champs !'); // Redirection vers connexion.php
    }


    if (!filter_var($_POST['email_pro'],FILTER_VALIDATE_EMAIL)){
        redirectFailure('../inscription', 'Votre email est invalide :('); 
    }

    if (strlen($_POST['password'])<8){
        redirectFailure('../inscription', 'Votre mot de passe doit être d\'au moins 8 caractères.'); 
    }


    if($_FILES['image']['error']!=4){ // Si un fichier a été uploadé

        // Vérification de son type
        $acceptable=['image/png','image/jpeg','image/gif'];
        if(!in_array($_FILES['image']['type'],$acceptable)){ // Permet de savoir si une valeur est dans un tableau, renvoie true si c'est le cas et non si ce n'est pas le cas
            redirectFailure('../inscription', 'Le fichier doit être un jpeg, png ou gif, ne manipule pas mon code !');
        }
        $maxSize=2*1024*1024;
        // Vérification de sa taille
        if($_FILES['image']['size']>$maxSize){ //  On vérifie si la taille est supérieur à 2Mo
            redirectFailure('../inscription', 'Le fichier doit être inférieur à 2Mo!'); 
        }

        if(!file_exists('assets/uploads')){  // Permet de savoir si un fichier / dossier existe, renvoie true si il existe
            mkdir('../assets/uploads'); // Crée le fichier uploads là où on est
        }
        // Enregistrement du fichier sur le serveur
        $from=$_FILES['image']['tmp_name']; // Enplacement temporaire du fichier


        $array=explode('.',$_FILES['image']['name']); //Transformer une chaîne de caractère selon un séparateur, fonction implode() pour concaténer des éléments d'un tableau selon un séparateur
        $ext=end($array); // Récupérer le dernier élément du tableau
        $fileName='image-'.time().'.'.$ext;
        // Risque de doublon si 2 personnes s'inscrit à la même seconde avec la même extension


        $to='../assets/uploads/'.$fileName; // Nom original du fichier
        move_uploaded_file($from,$to);
        $image = 'UPDATE USERS
        SET image = :image
        WHERE email = \''. htmlspecialchars($_POST['email_pro']).'\'';
        $req=$bdd->prepare($image);
            $result=$req->execute([
                'image' => $fileName
                ]);
    }


    $q= 'SELECT user_id FROM USERS WHERE email=:email';
    $req=$bdd->prepare($q);
        $req->execute([
        'email'=>$_POST['email_pro'], 
        ]);
    $results=$req->fetchAll();
    if (!empty($results)){
        redirectFailure('../inscription', 'Email déjà utilisé :((('); 
    }

    $salt = 'SANANESL3PLUSBEAUDUMONDEETDELESGIJEPENSEQUILA49ANS';
    $mdp_salt = $_POST['password'] . $salt;
    // Hashage du mot de passe
    $password = hash('sha512', $mdp_salt); 

    $q= 'INSERT INTO USERS (lastname,firstname,email,password,zip,city,name_factory,statut,email_check) VALUES (:lastname,:firstname,:email,:password,:zip,:city,:name_factory,:statut,:email_check)';
    $req=$bdd->prepare($q);
    $result=$req->execute([
        'lastname'=>htmlspecialchars($_POST['lastname']), 
        'firstname'=>htmlspecialchars($_POST['firstname']), 
        'email'=>$_POST['email_pro'], 
        'password'=>$password, 
        'zip'=>htmlspecialchars($_POST['zip']), 
        'city'=>htmlspecialchars($_POST['city']),
        'name_factory'=>htmlspecialchars($_POST['name_factory']),
        'statut' => 2,
        'email_check' => 0
        ]);    

    if ($result){
        header('location: verification_email?message='.$_POST['email_pro']);
        exit;
    } else {
        redirectFailure('../inscription', 'Erreur lors de la création du compte, veuillez recommencer.');
    }

}

?>