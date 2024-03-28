<?php
include("../includes/bd.php");

if(!isset($_GET['token']) || empty($_GET['token'])){
    header('location: verification_email.php?messageFailure=Une erreure est survenue, veuillez réessayer ou regénérer un nouveau mail&again=1');
    exit;
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
    $valid_token = 'SELECT value, hour FROM TOKEN WHERE id_user = :id';
    $req = $bdd->prepare($valid_token);
    $req->execute([
        'id'=> htmlspecialchars($_GET['id'])
    ]);
    $result = $req->fetch(PDO::FETCH_ASSOC);

    if(isset($result)){
        if(($result['value'] == $_POST['code']) && ($result['hour'] >= $_GET['hour'])){

            // Supprimer le token une fois qu'il à été validé
            $delete = 'DELETE FROM TOKEN WHERE id_user = :id';
            $req = $bdd->prepare($delete);
            $req->execute([
                'id'=> htmlspecialchars($_GET['id'])
            ]);

            // Valider l'inscription dans la table USERS l'utilisateur
            $check_code = 'UPDATE USERS SET email_check = 1 WHERE id_user = :id';
            $req = $bdd->prepare($delete);
            $req->execute([
                'id'=> htmlspecialchars($_GET['id'])
            ]);

            header('location: ../connexion.php?messageSuccess=Votre email a été vérifié, veuillez vous connecter');
            exit;  
        } else if(($result['value'] == $_POST['code']) && ($result['hour'] <= $_GET['hour'])){
            header('location: verification_email.php?messageFailure=Vous êtes trop lent ! votre délais pour vérifier votre email a expiré');
            exit;
        } else if (($result['value'] != $_POST['code'])){
            header('location: codes_vérification.php?messageFailure=Le code ne correspond pas, merci de réessayer&token=' . htmlspecialchars($_GET['token']) .'&id=' . htmlspecialchars($_GET['id']) . '&check=0');
            exit;
        }
        
    } else {
        header('location: ../connexion.php?messageFailure=Aucun token trouvé à votre nom, il se peut que votre adresse mail soit déjà vérifiée, essayez de vous connecter');
        exit;
    }
}
























    $q = 'SELECT email_number FROM USERS WHERE email = :email';
    $req = $bdd->prepare($q);
    $result = $req->execute([
        'email' => htmlspecialchars($_POST['email'])
    ]);
    $results = $req->fetch();
        // Vérifie si le code correspond à celui inscrit dans la bdd
        if ($_POST['code'] == $results['email_number']) {
            // Si c'est le cas, on valide l'email
            $q = 'UPDATE USERS SET email_check = 1 WHERE email = :email';
            $req = $bdd->prepare($q);
            $result = $req->execute([
                'email' => htmlspecialchars($_POST['email'])
            ]);  
            header('location: ../connexion.php?messageSuccess=Inscription valide, veuillez vous connecter');
            exit;
        } else {
            header('location: verification_email.php?messageFailure=Erreur lors de l\'ecriture du code');
            exit;
        }
        
?>