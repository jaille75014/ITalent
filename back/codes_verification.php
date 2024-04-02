<?php
session_start();
include("../includes/bd.php");
include('../includes/header_location.php');


if(isset($_SESSION["code"])){

if(!isset($_GET['token']) || empty($_GET['token'])){
    redirectFailure('verification_email.php', 'Une erreur est survenue, veuillez réessayer ou regénérer un nouveau mail&again=1');
}

if($_GET['check'] == 0){

    ?>


<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">

    <!-- form card login -->
    <div class="card rounded-0">
        <div class="card-header">
        <h3 class="mb-0">Validation du code</h3>
            </div>
                <div class="card-body">
                    <form id="form_code" <?php echo 'action="codes_verification.php?id=' . htmlspecialchars($_GET['id']) . '&hour=' . date('Y-m-d H:i:s') . '&check=1&token=' . htmlspecialchars($_GET['token']) . '" '?> method="POST">
                        <div class="form-group">
                            <label>Code</label>
                            <input type="text" class="form-control form-control-lg rounded-0" name="code" value="<?php echo isset($_GET['token']) ? htmlspecialchars($_GET['token']) : '' ?>">
                        </div>
                        <input type="submit" class="btn btn-success btn-lg float-right my-1" value="Vérifier mon code">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

} else {
    $valid_token = 'SELECT value, date FROM TOKEN WHERE user_id = :id';
    $req = $bdd->prepare($valid_token);
    $req->execute([
        'id'=> htmlspecialchars($_GET['id'])
    ]);
    $result = $req->fetch(PDO::FETCH_ASSOC);

    if(isset($result)){
        if(($result['value'] == $_POST['code']) && ($result['date'] >= $_GET['date'])){

            // Supprimer le token une fois qu'il à été validé
            $delete = 'DELETE FROM TOKEN WHERE user_id = :id';
            $req = $bdd->prepare($delete);
            $req->execute([
                'id'=> htmlspecialchars($_GET['id'])
            ]);

            // Valider l'inscription dans la table USERS l'utilisateur
            $check_code = 'UPDATE USERS SET email_check = 1 WHERE user_id = :id';
            $req = $bdd->prepare($check_code);
            $req->execute([
                'id'=> htmlspecialchars($_GET['id'])
            ]);

            redirectSuccess('../connexion.php', 'Votre email a été vérifié, veuillez vous connecter');  
        } else if(($result['value'] == $_POST['code']) && ($result['date'] <= $_GET['hour'])){
            redirectFailure('verification_email.php', 'Vous êtes trop lent ! votre délais pour vérifier votre email a expiré');

        } else if (($result['value'] != $_POST['code'])){
            redirectFailure('codes_verification.php', 'Le code ne correspond pas, merci de réessayer&token=' . htmlspecialchars($_GET['token']) .'&id=' . htmlspecialchars($_GET['id']) . '&check=0&debug=' . $result['value'] . '&debug2=' . $result['date']);
        }
        
    } else {
        redirectFailure('../connexion.php', 'Aucun token trouvé à votre nom, il se peut que votre adresse mail soit déjà vérifiée, essayez de vous connecter');
    }
    }
} else {
    redirectFailure('inscription.php', 'Oh ! Avez-vous essayer de gruger l\'inscription ?');
}
?>