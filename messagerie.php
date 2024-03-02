<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie | ITalent</title>
    <!-- Intégration Bootstrap 5  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Intégration de notre CSS -->
    <link type="text/css" rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include('includes/header.php');?>

    <div class="container-fluid chat-container">
        <div class="col-md-4 user-list">
            <h4>Tous les utilisateurs</h4>
            <ul class="list-group">
                <?php while($utilisateur = $recupUtilisateurs->fetch()) { ?>
                    <li class="list-group-item"><a href="?user_id=<?= $utilisateur['user_id'] ?>"><?= $utilisateur['firstname'] . ' ' . $utilisateur['lastname'] ?></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="col-md-8 message-box">
            <h4>Messages</h4>
            <?php 
                if(isset($_GET['user_id'])) {
                    $getid = $_GET['user_id'];
                    // Vérification si le paramètre 'user_id' est numérique avant de l'utiliser
                    if(is_numeric($getid)) {
                        $recupUser = $bdd->prepare('SELECT * FROM users WHERE user_id = ?');
                        $recupUser->execute(array($getid));
                        $utilisateur = $recupUser->fetch();

                        if($utilisateur) {
                            ?>
                            <h5>Conversation avec <?= $utilisateur['firstname'] . ' ' . $utilisateur['lastname'] ?></h5>
                            <section>
                                <?php 
                                    $recupMessages = $bdd->prepare('SELECT * FROM MESSAGE WHERE (user_id_source = ? AND user_id_target_id = ?) OR (user_id_source = ? AND user_id_target_id = ?)');
                                    $recupMessages->execute(array($_SESSION['user_id'], $getid, $getid, $_SESSION['user_id']));
                                    while($message = $recupMessages->fetch()) {
                                        ?>
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <p class="card-text"><?= $message['content']; ?></p>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                ?>
                            </section>
                            <?php
                        } else {
                            echo "Utilisateur non trouvé";
                        }
                    } else {
                        echo "Paramètre 'user_id' invalide";
                    }
                } else {
                    echo "Sélectionnez un utilisateur pour voir la conversation";
                }
            ?>
        </div>
    </div>

    <div class="container">
        <form method="post" action="">
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>

</body>
</html>