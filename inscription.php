<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/litera/bootstrap.min.css" integrity="sha384-enpDwFISL6M3ZGZ50Tjo8m65q06uLVnyvkFO3rsoW0UC15ATBFz3QEhr3hmxpYsn" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link type="text/css" rel="stylesheet" href="css/style.css">
        <title>Inscription | ITalent</title>
    </head>

    <body>
        <script src="js/script.js"></script>
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
                <input type="file" id="imageFile" capture="user" accept="image/*" />
                <input type="submit" value="S'inscrire">

            </form>
        </div>

        <div class="form-container sign-up">
            <form action="verification_inscription.php" method="POST">
                <h1>Créer un compte recruteur</h1>
                <input type="text" name="lastname" placeholder="Nom">
                <input type="text" name="firstname" placeholder="Prénom">
                <input type="email" name="email" placeholder="Votre email">
                <input type="text" name="name_factory" placeholder="Nom de l'entreprise">
                <input type="password" name="password" placeholder="Mot de passe">
                <input type="text" name="city" placeholder="Ville">
                <input type="text" name="zip"  inputmode="numeric" placeholder="Code postal">
                <input type="file" id="imageFile" capture="user" accept="image/*" />
                <input type="submit" value="S'inscrire">
            </form>
        </div>
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
                id="login">ÉTUDIANT</button>
            </div>
        </div>
    </div>

        

        
    
    </main>
    <footer>
        <?php include('includes/footer.php'); ?>
    </footer>
</body>


</html>