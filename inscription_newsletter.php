<?php 
session_start();
include('includes/header_location.php');
include('includes/bd.php');

$user_email = htmlspecialchars($_GET['email']);
$url = htmlspecialchars($_GET['url']);

?>

<!DOCTYPE html>
<html lang="en">

<?php 
    $title='Newsletter';
    include('includes/head.php');
?>
<body>
    <main>
        <?php 

        $newletter_check = 'SELECT newsletter FROM USERS WHERE email = :email';
        $req = $bdd->prepare($newletter_check);
        $result = $req->execute([
            'email' => $user_email
        ]);
        $results = $req->fetch(PDO::FETCH_ASSOC);

        if (!isset($_SESSION["newsletter"]) && $_SESSION["newsletter"] != 1) {
            redirectFailure($url, 'Vous n\'avez pas les droits pour accéder à cette page.');
        } else {
            if($_GET['news'] == 1 ) {
                setcookie("email", $user_email, time()+60); // On crée un cookie qui expirera 60 secondes plus tard pour des raisons de sécurité.
            } else 
            foreach ($results as $index => $value) {
                if ($value == 1){ //Si le champ newsletter est déjà rempli
                    redirectSuccess($url, 'Vous êtes déjà inscrit à notre newsletter !');
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
                        <form id="form_code" action="<?php echo 'inscription_newsletter?news=2&email=' . $user_email . '&url=' . $url ?>" method="POST">                                
                        <div class="form-group my-4">
                                    <label for="uname1">email</label>
                                    <input type="email" class="form-control form-control-lg rounded-0" id="email" name="email" value="<?= $user_email ?>" onFocus="this.value='';">
                                </div>
                                <div class="form-group my-4">
                                    <label>Vous pouvez encore changer d'avis !</label><br>
                                    <input type="radio" class="btn-check" name="yes" id="success-outlined" autocomplete="off">
                                    <label class="btn btn-outline-success" for="success-outlined">Je souhaite toujours m'inscrire</label>
                                    <input type="radio" class="btn-check" name="no" id="danger-outlined" autocomplete="off">
                                    <label class="btn btn-outline-danger" for="danger-outlined">J'ai changé d'avis</label>
                                </div>
                                <input type="submit" class="btn btn-success btn-lg float-right my-4" value="Valider">
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
                if(isset($_POST['no']) && !empty($_POST['no'])){
                    redirectSuccess($url, 'Vous avez changé d\'avis, vous n\'êtes pas inscrit à notre newsletter');
                }
            
                $email_db = 'SELECT email FROM USERS where email = :email';
                $req = $bdd->prepare($email_db);
                $result = $req->execute([
                    'email' => $user_email
                ]);
                $results = $req->fetch(PDO::FETCH_ASSOC);
            
                $email_formulaire = $_POST['email'];
            
                if($results['email'] == $email_formulaire) {
                    $pull_newsletter = 'UPDATE USERS SET newsletter = :newsletter WHERE email = :email'; 
                    $req=$bdd->prepare($pull_newsletter);
                    $result=$req->execute([
                        'newsletter' => 1,
                        'email' => $email_formulaire
                    ]);
                }
                redirectSuccess($url, 'Vous êtes maintenant inscrit à notre newsletter ! MERCI !');
            } else {
                header('location: inscription_newsletter?messageFailure=Une erreure s\'est produite, vérifiez que vous avez bien écrit votre email&news=1&mail=' . $user_email . '&url=' . $url);
                exit;
            }
        }
        ?>
    </main>
</body>
</html>