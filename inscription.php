<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/litera/bootstrap.min.css" integrity="sha384-enpDwFISL6M3ZGZ50Tjo8m65q06uLVnyvkFO3rsoW0UC15ATBFz3QEhr3hmxpYsn" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Inscription | ITalent</title>
    </head>

    <body class="inscription">
        <script src="js/script.js"></script>
    <?php include('includes/header.php');?>
    <main>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="verification_inscription.php" method="POST">
                <h1>Créer un compte étudiant</h1>
            </form>
        </div>
    </div>
    
    </main>
    <footer>
        <?php include('includes/footer.php'); ?>
    </footer>
</body>


</html>