<?php
include('includes/bd.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Intégration de la police d'écriture  -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <!-- Icône de Boxincons -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Intégration Bootstrap 5  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Intégration de notre CSS -->
    <link type="text/css" rel="stylesheet" href="css/style.css">
    <title>Connexion | ITalent</title>
</head>


<body class="bg-light">

    <?php include('includes/header.php'); ?>



    <section class="">

    <?php 
    if(isset($_GET['message'])){
    echo '<div class="alert alert-danger" role="alert">'.htmlspecialchars($_GET['message']).'</div>'; 
    }
    ?>


    <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
        <div class="container">
        <div class="row gx-lg-5 align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
            <h1 class="my-5 display-3 fw-bold ls-tight">
                <span class="text-primary">ITalent</span>
                <br>
                Vous revoila !
            </h1>

            <p class="text-secondary">
            Reseignez vos identifiants pour vous connecter et accéder à tous vos services
            <br>
            Pas encore de compte ? cliquez ci-dessous
            </p>

            <button onclick="window.location.href = 'inscription.php';" class="btn btn-primary btn-block mb-4">Inscription</button>

            

            </div>

            <div class="col-lg-6 mb-5 mb-lg-0">
            <div class="card">
                <div class="card-body py-5 px-md-5">
                <form action="verification_connexion.php" method="POST">
                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Adresse Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Votre email : " 
                        value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : '' ?>">
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Mot de passe</label>
                        <input type="password" name="password" class="form-control" placeholder="Mot de passe : ">
                    </div>


                    <button type="submit" class="btn btn-primary btn-block mb-4" value="Connexion">
                    Connexion
                    </button>

                </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>

    </section>

    <?php include('includes/footer.php');?>

</body>
</html>