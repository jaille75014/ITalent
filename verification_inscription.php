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

        if ($result) {
            // Import PHPMailer classes
            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\SMTP;
            use PHPMailer\PHPMailer\Exception;
            // Load Composer's autoloader
            require 'vendor/autoload.php';
        
            // Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
        
            $rand_verification_email = rand(100000, 999999);
            $email = htmlspecialchars($_POST['email']);
            
            $q = "UPDATE USERS SET email_number = '$rand_verification_email' WHERE email = '$email'";
        
            try {
                // SMTP configuration
                $mail->SMTPDebug = 1; 
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'italent.contact.site@gmail.com';
                $mail->Password   = 'amlgyldqoziafkuu';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;
        
                // Email content
                $mail->setFrom('italent.contact.site@gmail.com', 'Italent');
                $mail->addAddress($email);
                $body = '<p>Bonjour, ...'; // Email body content
                $mail->addAttachment('assets/LOGO_version_complète.png', "LOGO_version_complète.png");
                $mail->isHTML(true);
                $mail->Subject = 'Confirmation de votre inscription';
                $mail->Body = $body;
                $mail->AltBody = strip_tags($body);
                $mail->send();
        
                // Display verification form
                ?>
                <h1>Vous y êtes presque !</h1>
                <p>Nous vous avons envoyé un mail de confirmation...</p>
                <p>Renseignez le code à 6 chiffres :</p>
                <form method="POST">
                    <input type="text" name="code" placeholder="Entrez le code :">
                    <input type="submit" value="Vérifier le code">
                </form>
                <?php
        
                if (isset($_POST['code'])) {
                    $q = "SELECT email_number FROM USERS WHERE email = '$email'";
                    // Fetch email_number from database
                    // Execute query and compare the code
                    if ($code == $email_number) {
                        // Update email_check field in the database
                        $q = "UPDATE USERS SET email_check = 1 WHERE email = '$email'";
                        header('location: connexion.php?messageSuccess=Inscription valide, veuillez vous connecter');
                        exit;
                    } else {
                        header('location: inscription.php?messageFailure=Réessayez !');
                        exit;
                    } 
                }
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                exit;
            }
        } else {
            header('location: inscription.php?message=Erreur lors de la création du compte, veuillez recommencer.');
            exit;
        }

?>