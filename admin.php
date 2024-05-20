<?php  
include('includes/header_location.php');
    session_start(); 
    if(!isset($_SESSION['captcha'])){
        redirectFailure('captcha', 'Chippeur arrête de chipper');
    }
    

    if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 3) {
        redirectFailure('index', 'Vous n\'avez pas les droits pour accéder à cette page');
    }

    $id = isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : null;

    if(isset($_POST['raison_suppression'])) {
        $raison = $_POST['raison_suppression'];
        $log_file = 'delete_user_log.txt';
        if($id) {
            file_put_contents($log_file, "Utilisateur supprimé (ID: $id) - Raison: $raison\n", FILE_APPEND);
        }
    } else {
        $raison = 'Banni par un admin sans raison spécifiée';
    }
    
    include('includes/bd.php');
    $select_users = 'SELECT user_id, lastname, firstname, email, statut FROM USERS WHERE 1';
    $users = $bdd->query($select_users)->fetchAll();


    if(isset($_POST['delete_user']) && $id) {
        
        $req_publications = $bdd->prepare('DELETE FROM PUBLICATIONS WHERE user_id = :id');
    $req_publications->execute([
        ':id' => $id
    ]);
        $req_storys = $bdd->prepare('DELETE FROM STORYS WHERE user_id = :id');
        $req_storys->execute([':id' => $id]);

        $req = $bdd->prepare('UPDATE USERS SET statut = 0 WHERE user_id = :id'); 
        $req->execute([':id' => $id]);

        if(isset($_POST['raison_suppression'])) {
            $raison = $_POST['raison_suppression'];
            $log_file = 'delete_user_log.txt';
            file_put_contents($log_file, "Utilisateur supprimé (ID: $id) - Raison: $raison\n", FILE_APPEND);
        }
        $req_ban = $bdd->prepare('INSERT INTO BAN (date_ban, reason, user_id) VALUES (:date_ban, :reason, :user_id)');
        $req_ban->execute([
            ':date_ban' => date('Y-m-d H:i:s', strtotime("+30 days")),
            ':reason' => $raison,
            ':user_id'=>$id
        ]);  
        
        redirectSuccess('admin', 'Utilisateur banni avec succès');
    }
?>

<!DOCTYPE html>
<html lang="fr">

<?php 
    include('includes/fonctions_logs.php');

    $title='Admin';
    $url = 'admin'; // Utilisé pour revenir sur cette page en cas d'erreurs dans les pages newsletter
    include('includes/head.php');

    writeVisitLog($url);
?>

<body class="bg-light">

    <?php include('includes/header.php'); ?>

    <div class="container">

        <h3>Rechercher un utilisateur :</h3>

        <div class="mb-3">
            <form method="post">
                <div class="row align-items-end"> 
                    <div class="col-12 col-sm-2 col-md-1 form-group">
                        <label for="user_id">ID :</label>
                        <input type="text" oninput="search('id', 'user_id')" name="user_id" id="user_id" class="form-control" ?>
                    </div>
                    <div class="col-12 col-sm-4 col-md-5 form-group"> 
                        <label for="email">Email :</label>
                        <input type="text" oninput="search('email', 'email')" name="email" id="email" class="form-control" ?>
                    </div>
                    <div class="col-6 col-sm-3 col-md-2 form-group">
                        <label for="lastname">Nom :</label>
                        <input type="text" oninput="search('lastname', 'lastname')" name="lastname" id="lastname" class="form-control"?>
                    </div>
                    <div class="col-6 col-sm-3 col-md-2 form-group">
                        <label for="firstname">Prénom :</label>
                        <input type="text" oninput="search('firstname', 'firstname')" name="firstname" id="firstname" class="form-control" ?>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle text-center">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Supprimer publications</th>
                        <th>Supprimer story</th>
                        <th>Raison bannissement</th>
                    </tr>
                </thead>
                <tbody id="users">
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['user_id']; ?></td>
                        <td><?php echo $user['lastname']; ?></td>
                        <td><?php echo $user['firstname']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                        <?php 
                            switch ($user['statut']) {
                                case '1':
                                    echo "Etudiant";
                                    break;
                                case '2':
                                    echo "Recruteur";
                                    break;
                                case '3':
                                    echo "Admin";
                                    break;
                                default:
                                    echo "Banni temporairement";
                                    break;
                                }
                            ?>
                        </td>
                        <td class="text-center">
                            <form method="post">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" class="btn btn-warning" name="delete_publications">Supprimer</button>
                            </form>
                        </td>
                        <td class="text-center">
                            <form method="post">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" class="btn btn-warning" name="delete_story">Supprimer</button>
                            </form>
                        </td>
                        <td class="text-center">
                        <form method="post">
                            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <input type="text" name="raison_suppression" class="form-control" placeholder="Raison :" required>
                                <button type="submit" class="btn btn-danger mt-2" name="delete_user" onclick="return confirm('Êtes-vous sûr de vouloir bannir cet utilisateur ?')">Bannir</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="js/load.js"></script>

<?php include('includes/footer.php'); ?>

</body>