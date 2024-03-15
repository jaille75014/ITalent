<?php 
    session_start(); 
    include('includes/bd.php');

    include('includes/log_functions.php');
    writeVisitLog('admin.php');
?>

<!DOCTYPE html>
<html lang="fr">

<?php 
$title='Messagerie';
include('includes/head.php');?>

<body class="bg-light">

    <?php include('includes/header.php');?>

    <main class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <h3>Utilisateurs</h3>
                <ul class="list-group" id="user-list">
                    <?php 
                        $users_query = $bdd->query("SELECT user_id, firstname, lastname FROM USERS");
                        while ($user = $users_query->fetch(PDO::FETCH_ASSOC)) {
                            echo '<li class="list-group-item user-item" data-user-id="' . $user['user_id'] . '">' . $user['firstname'] . ' ' . $user['lastname'] . '</li>';
                        }
                    ?>
                </ul>
            </div>
            <div class="col-md-8">
                <div id="chat-box">
                    <h3>Sélectionnez un utilisateur pour commencer la discussion</h3>
                </div>
                <form id="message-form" class="mt-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="message-input" placeholder="Entrez votre message">
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    
    <?php include('includes/footer.php');?>

    <script src="js/messages.js"></script>
</body>

</html>