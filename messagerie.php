<?php
session_start();
include('includes/header_location.php');
include('includes/fonctions_logs.php');
include("includes/bd.php");

if(!isset($_SESSION['captcha'])){
    redirectFailure('captcha', 'Chipeur arrête de chipper !');
}

writeVisitLog('messagerie.php');

$result_messages = array();

// Si c'est un recruteur qui est connecté
if($_SESSION['statut'] == 2){
    $all_connections = "SELECT student_id FROM CONNECTS WHERE recruiter_id = ?";
    $is_connected = $bdd->prepare($all_connections);
    $is_connected->execute([$_SESSION['user_id']]);
    $connected = $is_connected->fetchAll(PDO::FETCH_ASSOC);
    $connected_ids = array_column($connected, 'student_id');
} else if($_SESSION['statut'] == 1){
    $all_connections = "SELECT recruiter_id FROM CONNECTS WHERE student_id = ?";
    $is_connected = $bdd->prepare($all_connections);
    $is_connected->execute([$_SESSION['user_id']]);
    $connected = $is_connected->fetchAll(PDO::FETCH_ASSOC);
    $connected_ids = array_column($connected, 'recruiter_id');
}

if (!empty($connected_ids)) {
    $ids_string = implode(',', $connected_ids); // Transforme le tableau en string pour la requête SQL, ex: '1,2,3'

    $sql_users = "SELECT user_id, firstname, lastname FROM USERS WHERE user_id IN ($ids_string)";
    $stmt_users = $bdd->query($sql_users);
    $result_users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);
} else {
    $result_users = [];
}

if (isset($_GET['user_id'])) {
    $user_id = htmlspecialchars($_GET['user_id']);
    $sql_messages = "SELECT * FROM MESSAGE WHERE (user_id_source = ? AND user_id_target_id = ?) OR (user_id_source = ? AND user_id_target_id = ?) ORDER BY date ASC";
    $stmt_messages = $bdd->prepare($sql_messages);
    $stmt_messages->execute([$_SESSION['user_id'], $user_id, $user_id, $_SESSION['user_id']]);
    $result_messages = $stmt_messages->fetchAll(PDO::FETCH_ASSOC);
}

/* ANCIENNE VERSION A SUPPRIMER SI LA NOUVELLE FONCTIONNE CAR ELLE SELECTIONNE TOUS LES UTILISATEURS

$sql_users = "SELECT user_id, firstname, lastname FROM USERS";
$stmt_users = $bdd->query($sql_users);
$result_users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);
*/

?>

<!DOCTYPE html>
<html>
    <head>
        <?php include("includes/head.php"); ?>
        <style>
            .message-box {
                border: 1px solid #ccc;
                padding: 10px;
                max-height: 400px;
                overflow-y: auto;
            }
            .received-message {
                background-color: #f0f0f0; 
                margin-right: 50%;
                padding: 10px;
                border-radius: 8px;
                margin-bottom: 10px;
            }
            .sent-message {
                background-color: #007bff;
                color: white;
                margin-left: 50%;
                padding: 10px;
                border-radius: 8px;
                margin-bottom: 10px;
                text-align: right;
            }
        </style>
    </head>


    <body>

        <?php include("includes/header.php"); 

        $url = 'messagerie'; // Permet de revenir sur cette page en cas d'erreurs dans les pages newsletter 

        if (isset($_GET['messageFailure'])): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($_GET['messageFailure']) ?>
            <?php if (isset($_GET['max_length'])): ?>
                le nombre maximum de caractères est de <?= intval($_GET['max_length']) ?>.
            <?php endif; ?>
        </div>
        <?php endif; ?>


        <div class="container mt-4">
            <div class="row">
                <div class="col-12 col-sm-4 col-lg-3">

                    <div class="users-list">
                        <h2>Utilisateurs</h2>
                        <ul class="list-group">
                            <?php foreach ($result_users as $row) : ?>
                                <li class="list-group-item">
                                    <a href="messagerie?user_id=<?= $row['user_id'] ?>" class="user-link"><?= $row['firstname'] ?> <?= $row['lastname'] ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>

                <div class="col-12 col-sm-8 col-lg-9">
                    <div class="conversation">

                        <div class="message-box">
                            <?php if (!empty($result_messages)) : ?>
                                <?php foreach ($result_messages as $message) : ?>
                                    <?php if ($message['user_id_source'] == $_SESSION['user_id']) : ?>
                                        <div class="sent-message"><?= $message['content'] ?></div>
                                    <?php else : ?>
                                        <div class="received-message"><?= $message['content'] ?></div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>


                        <div class="send-message">
                            <form action="back/envoie_message" method="post" class="d-flex">
                                <textarea name="message_content" placeholder="Votre message" class="form-control mr-2"></textarea>
                                <input type="hidden" name="user_id_target_id" value="<?= isset($user_id) ? $user_id : '' ?>">
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                            </form>
                        </div>

                    </div>
                </div>
                
            </div>
        </div>

        <?php include("includes/footer.php"); ?>

    </body>


</html>