<!DOCTYPE html>
<html lang="fr">

<?php 
$title='Inscription';
$url = 'inscription'; // Utilisé pour revenir sur cette page en cas d'erreurs dans les pages newsletter
include('includes/head.php');?>

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
            <form action="back/verification_inscription" method="POST" enctype="multipart/form-data">
                <h1>Créer un compte étudiant</h1>
                <input type="text" name="lastname" placeholder="Nom">
                <input type="text" name="firstname" placeholder="Prénom">
                <input type="email" name="email" placeholder="Votre email" value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : '' ?>">
                <input type="tel" name="phone" pattern="[0-9]{10}" placeholder="N° de téléphone">
                <div class="input">
                <input type="password" name="password" class="pass" placeholder="Mot de passe">
                <img src="assets/eye-slash.svg" alt="oeil" class="eye" onclick="togglePasswordVisibility(this)"/> 
                </div>
                <input type="text" name="city" placeholder="Ville" >
                <input type="text" name="zip"  pattern="[0-9]{5}" placeholder="Code postal, exemple : 77144">
                <input type="file" name="image" accept="image/jpeg, image/png, image/gif">
                <small id="emailHelp" class="form-text text-muted">Vous n'êtes pas obligé d'uploader une photo tout de suite</small>
                <button type="submit" class="btn btn-primary col-12 py-2 send" name="Student">S'inscrire</button>

            </form>
        </div>

        <div class="form-container sign-in">
            <form action="back/verification_inscription" method="POST" enctype="multipart/form-data">
                <h1>Créer un compte recruteur</h1>
                <input type="text" name="lastname" placeholder="Nom">
                <input type="text" name="firstname" placeholder="Prénom">
                <input type="email" name="email_pro" placeholder="Votre email">
                <input type="text" name="name_factory" placeholder="Nom de l'entreprise">
                <div class="position-relative"">
                <input type="password" name="password" class="pass" placeholder="Mot de passe">
                <img src="assets/eye-slash.svg" alt="eye" class="eye position-absolute" style="right: 10px; top: 70%; transform: translateY(-50%);" onclick="togglePasswordVisibility(this)" />
                </div>
                <input type="text" name="city" placeholder="Ville">
                <input type="text" name="zip"  pattern="[0-9]{5}" placeholder="Code postal, exemple : 77144">
                <input type="file" name="image" accept="image/jpeg, image/png, image/gif">
                <small id="emailHelp" class="form-text text-muted">Vous n'êtes pas obligé d'uploader une photo tout de suite</small>
                <button type="submit" class="btn btn-primary col-12 py-2 send" name="Recruiter">S'inscrire</button>
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