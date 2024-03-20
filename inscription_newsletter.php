<?php 
session_start();
include'includes/bd.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php 
    $title='Newsletter';
    include'includes/head.php';
?>
<body>
    <main>
        <?php 

        $newletter_check = 'SELECT newsletter FROM USERS WHERE email = :email';
        $req = $bdd->prepare($newletter_check);
        $result = $req->execute([
            'email' => htmlspecialchars($_GET['email'])
        ]);
        $results = $req->fetch(PDO::FETCH_ASSOC);

        if (!isset($_SESSION["newsletter"]) && $_SESSION["newsletter"] != 1) {
            echo "<h1>Oh oh ! Si ce message apparaît, c'est que vous n'étiez pas sensé apparaître sur cette page ! 
            Retournez en arrière et réessayez.</h1>";
        } else {
            if($_GET['news'] == 1 ) {
                setcookie("email", $_GET['email'], time()+60); // On crée un cookie qui expirera 25 secondes plus tard pour des raisons de sécurité.
            } else 
            foreach ($results as $index => $value) {
                if ($value == 1){ //Si le champ newsletter est déjà rempli
                    header('location: ' . $_GET['url'] . '?messageSuccess=Vous êtes déjà inscrit à notre newsletter!');
                    exit();
                }
            }
             
            
            if($_GET['news'] == 1) {
            ?>

            
        <div class="container py-5">
            <div class="row">
            <div class="col-md-12">
                <h2 class="text-center text-white mb-4">Validation de votre inscription à la newsletter d'Italent !</h2>
                <p>Vous disposez d'une minute pour vous inscrire, sinon vous serez obligé de recommencer</p>
            <div class="row">
        <div class="col-md-6 mx-auto">


        <!-- form card login -->
            <div class="card rounded-0">
                <div class="card-header">
                <h3 class="mb-0">Validation de la newsletter</h3>
                    </div>
                        <div class="card-body">
                            <form id="form_code" action="<?php echo 'inscription_newsletter.php?news=2&email=' . htmlspecialchars($_GET['email']) . '&url=' . htmlspecialchars($_GET['url']) ?>" method="POST">
                                <div class="form-group">
                                    <label for="uname1">email</label>
                                    <input type="email" class="form-control form-control-lg rounded-0" id="email" name="email" value="<?= htmlspecialchars($_GET['email'])?>" onFocus="this.value='';">
                                </div>
                                <div class="form-group">
                                    <label>Vous pouvez encore changer d'avis !</label>
                                    <input type="radio" name="yes" class="form-control form-control-lg rounded-0" value="0" />S''inscrire
                                    <input type="radio" name="no" class="form-control form-control-lg rounded-0" value="1" />Ne pas s'inscrire<br/>
                                </div>
                                <input type="submit" class="btn btn-success btn-lg float-right my-1" value="Valider">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
            </div>
            <?php
            } else if ($_GET['news'] == 2) {
                $email_db = 'SELECT email FROM USERS where email = :email';
                $req = $bdd->prepare($email_db);
                $result = $req->execute([
                    'email' => htmlspecialchars($_GET['email'])
                ]);
                $results = $req->fetch(PDO::FETCH_ASSOC);

                $email_formulaire = $_POST['email'];

                foreach ($results as $index => $value) {
                if($value == $email_formulaire) {
                $pull_newsletter = 'UPDATE USERS SET newsletter = :newsletter WHERE email = '. $value; 
                $req=$bdd->prepare($pull_newsletter);
                $result=$req->execute([
                'newsletter' => 1
                ]);
            }
            
        }
            echo 'Inscription réussie, vous allez être redirigé';
            header('location: ' . htmlspecialchars($_GET['url']));
            exit();
            }
            else {
                echo 'Vous vous êtes trompé d\'email';
            }
        }
        ?>
    </main>
</body>
</html>