<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link type="text/css" rel="stylesheet" href="css/style.css">
        <title>Inscription | ITalent</title>
    </head>

    <body class="bg-light">
        
    <?php include('includes/header.php');?>
    <main class="inscription">


    <?php 
        if(isset($_GET['messageFailure'])){
            echo '<div class="alert alert-danger" role="alert">'.htmlspecialchars($_GET['messageFailure']).'</div>'; 
        }
    ?>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="verification_inscription.php" method="POST" enctype="multipart/form-data">
                <h1>Créer un compte étudiant</h1>
                <input type="text" name="lastname" placeholder="Nom">
                <input type="text" name="firstname" placeholder="Prénom">
                <input type="email" name="email" placeholder="Votre email" value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : '' ?>">
                <input type="tel" name="phone" pattern="[0-9]{10}" placeholder="N° de téléphone">
                <input type="password" name="password" placeholder="Mot de passe">
                <input type="text" name="city" placeholder="Ville" >
                <input type="text" name="zip"  pattern="[0-9]{5}" placeholder="Code postal, exemple : 77144">
                <input type="file" name="image" accept="image/jpeg, image/png, image/gif">
                <small id="emailHelp" class="form-text text-muted">Vous n'êtes pas obligé d'uploader une photo tout de suite</small>
                <input type="submit" class="btn btn-primary send" value="S'inscrire" name="Student">

            </form>
        </div>

        <div class="form-container sign-in">
            <form action="verification_inscription.php" method="POST" enctype="multipart/form-data">
                <h1>Créer un compte recruteur</h1>
                <input type="text" name="lastname" placeholder="Nom">
                <input type="text" name="firstname" placeholder="Prénom">
                <input type="email" name="email_pro" placeholder="Votre email">
                <input type="text" name="name_factory" placeholder="Nom de l'entreprise">
                <input type="password" name="password" placeholder="Mot de passe">
                <input type="text" name="city" placeholder="Ville">
                <input type="text" name="zip"  pattern="[0-9]{5}" placeholder="Code postal, exemple : 77144">
                <input type="file" name="image" accept="image/jpeg, image/png, image/gif">
                <small id="emailHelp" class="form-text text-muted">Vous n'êtes pas obligé d'uploader une photo tout de suite</small>
                <input type="submit" class="btn btn-primary send" value="S'inscrire" name="Recruiter">
            </form>
        </div>
    
    
    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-left">
                <h1>Bienvenue !</h1>
                <p>Remplissez ces champs pour continuer</p>
                <p>Vous êtes un recruteur ? cliquez sur RECRUTEUR</p>
                <button class="hidden"
                id="login">RECRUTEUR</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>Bienvenue !</h1>
                <p>Remplissez ces champs pour continuer</p>
                <p>Vous êtes un étudiant ? cliquez sur ÉTUDIANT</p>
                <button class="hidden"
                id="register">ÉTUDIANT</button>
            </div>
        </div>
        </div>
    </div>
        

        
    <script src="js/script.js"></script>

    </main>
    
    
    
</body>


</html>