<?php
include('includes/bd.php');
?>

<!DOCTYPE html>
<html lang="fr">
<?php 
$title='Connexion';
$url = 'connexion.php';
include('includes/head.php');?>


<body class="bg-light">

    <?php include('includes/header.php'); ?>

    <main>

    <section>
    <div class="container">

    
        <?php 
        if(isset($_GET['messageFailure'])){
        echo '<div class="alert alert-danger" role="alert">'.htmlspecialchars($_GET['messageFailure']).'</div>'; 
        }
        if(isset($_GET['messageSuccess'])){
            echo '<div class="alert alert-success" role="alert">'.htmlspecialchars($_GET['messageSuccess']).'</div>'; 
            }

        ?>
    </div>


    <div class="px-4 py-5 px-md-5 text-center text-lg-start" >
        <div class="container">
        <div class="row gx-lg-5 align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
            <h1 class="my-5 display-3 fw-bold ls-tight">
                <span class="text-primary">ITalent</span>
                <br>
                Vous revoilà !
            </h1>

            <p class="text-secondary">
            Reseignez vos identifiants pour vous connecter et accéder à tous vos services
            <br>
            Pas encore de compte ? cliquez ci-dessous
            </p>

            <a href="inscription"><button class="btn btn-primary btn-block mb-4">Inscription</button></a>

            

            </div>

            <div class="col-lg-6 mb-5 mb-lg-0">
            <div class="card">
                <div class="card-body py-5 px-md-5">
                <form action="back/verification_connexion" method="POST">
                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Adresse Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Votre email : " 
                        value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : (isset($_COOKIE['email_pro']) ? $_COOKIE['email_pro'] : '' )?>">
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
    </main>

    <?php include('includes/footer.php');?>

</body>
</html>