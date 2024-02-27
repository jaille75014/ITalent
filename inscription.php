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
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="verification_inscription.php" method="POST">
                <h1>Créer un compte étudiant</h1>
                <input type="text" name="lastname" placeholder="Nom">
                <input type="text" name="firstname" placeholder="Prénom">
                <input type="email" name="email" placeholder="Votre email">
                <input type="tel" name="phone" pattern="[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}" placeholder="n° de téléphone">
                <input type="password" name="password" placeholder="Mot de passe">
                <input type="text" name="city" placeholder="Ville">
                <input type="text" name="zip"  inputmode="numeric" placeholder="Code postal">
                <input type="submit" class="send" value="S'inscrire">

            </form>
        </div>

        <div class="form-container sign-in">
            <form action="verification_inscription.php" method="POST">
                <h1>Créer un compte recruteur</h1>
                <input type="text" name="lastname" placeholder="Nom">
                <input type="text" name="firstname" placeholder="Prénom">
                <input type="email" name="email" placeholder="Votre email">
                <input type="text" name="name_factory" placeholder="Nom de l'entreprise">
                <input type="password" name="password" placeholder="Mot de passe">
                <input type="text" name="city" placeholder="Ville">
                <input type="text" name="zip"  inputmode="numeric" placeholder="Code postal">
                <input type="submit" class="send" value="S'inscrire">
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