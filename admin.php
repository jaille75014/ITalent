<?php  
    session_start(); 
    if(!isset($_SESSION['captcha'])){
        header('location:captcha?error=Chipeur arrête de chipper !');
        exit;
    }
    

    if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 3) {
        header('location:index');
        exit;
    }

    if(isset($_POST['raison_suppression'])) {
        $raison = $_POST['raison_suppression'];
        $log_file = 'delete_user_log.txt';
        file_put_contents($log_file, "Utilisateur supprimé (ID: $id) - Raison: $raison\n", FILE_APPEND);
    } else {
        $raison = 'Banni par un admin sans raison spécifiée';
    }
    
    include('includes/fonctions_logs.php');
    include('includes/bd.php');
    writeVisitLog('admin.php');
    $users = $bdd->query($query)->fetchAll();

    if(isset($_POST['delete_user']) && isset($_POST['user_id'])) {
        $id = $_POST['user_id'];
        $id = htmlspecialchars($_POST['user_id']);
        
        $req_publications = $bdd->prepare('DELETE FROM PUBLICATIONS WHERE user_id = :id');
        $req_publications->execute(array(':id' => $id));
        $req_storys = $bdd->prepare('DELETE FROM STORYS WHERE user_id = :id');
        $req_storys->execute(array(':id' => $id));

        $req = $bdd->prepare('DELETE FROM USERS WHERE user_id = :id'); // Opter pour une modification du statut à 0 plutôt que la suppression
        $req = $bdd->prepare('UPDATE USERS SET statut = 0 WHERE user_id = :id'); 
        $req->execute(array(':id' => $id));

        if(isset($_POST['raison_suppression'])) {
            $raison = $_POST['raison_suppression'];
            $log_file = 'delete_user_log.txt';
            file_put_contents($log_file, "Utilisateur supprimé (ID: $id) - Raison: $raison\n", FILE_APPEND);
        }
        $req_ban = $bdd->prepare('INSERT INTO BAN (user_id, date_ban, reason) VALUES (:id, :date_ban, :reason)');
        $req_ban->execute(array(
            ':id' => $id,
            ':date_ban' => date('Y-m-d H:i:s', strtotime("+30 days")),
            ':reason' => $raison
        ));        

        header('location: admin');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="fr">

<?php 
$title='Admin';
$url = 'admin'; //Permet de revenir sur cette page en cas d'erreurs dans les pages newsletter
include('includes/head.php');?>

<body class="bg-light">

    <?php include('includes/header.php'); ?>

    <div class="container">

        <h3>Rechercher un utilisateur :</h3>

        <div class="mb-3">
            <form method="post">
                <div class="row align-items-end"> 
                    <div class="col-12 col-sm-2 col-md-1 form-group">
                        <label for="user_id">ID :</label>
                        <input type="text" oninput="search('id', 'user_id')" name="user_id" id="user_id" class="form-control" value="<?php echo $user_id; ?>">
                    </div>
                    <div class="col-12 col-sm-4 col-md-5 form-group"> 
                        <label for="email">Email :</label>
                        <input type="text" oninput="search('email', 'email')" name="email" id="email" class="form-control" value="<?php echo $email; ?>">
                    </div>
                    <div class="col-6 col-sm-3 col-md-2 form-group">
                        <label for="lastname">Nom :</label>
                        <input type="text" oninput="search('lastname', 'lastname')" name="lastname" id="lastname" class="form-control" value="<?php echo $lastname; ?>">
                    </div>
                    <div class="col-6 col-sm-3 col-md-2 form-group">
                        <label for="firstname">Prénom :</label>
                        <input type="text" oninput="search('firstname', 'firstname')" name="firstname" id="firstname" class="form-control" value="<?php echo $firstname; ?>">
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Id</th>
                        <th class="text-center">Nom</th>
                        <th class="text-center">Prénom</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Statut</th>
                        <th class="text-center">Supprimer publications</th>
                        <th class="text-center">Supprimer story</th>
                        <th class="text-center">Action</th>
                        <th class="text-center">Raison bannissement</th>
                    </tr>
                </thead>
                <tbody id="users">
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="text-center"><?php echo $user['user_id']; ?></td>
                        <td class="text-center"><?php echo $user['lastname']; ?></td>
                        <td class="text-center"><?php echo $user['firstname']; ?></td>
                        <td class="text-center"><?php echo $user['email']; ?></td>
                        <td class="text-center">
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
                                <button type="submit" class="btn btn-danger" name="delete_publications">Supprimer</button>
                            </form>
                        </td>
                        <td class="text-center">
                            <form method="post">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" class="btn btn-danger" name="delete_story">Supprimer</button>
                            </form>
                        </td>
                        <td class="text-center">
                        <form method="post">
                            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                            <button type="submit" class="btn btn-danger" name="delete_user" onclick="return confirm('Êtes-vous sûr de vouloir bannir cet utilisateur ?')">Bannir</button>
                        </form>
                        </td>
                        <td class="text-center">
                            <form class="d-flex flex-column flex-md-row" method="post">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <input type="text" name="raison_suppression" class="form-control me-md-2 mb-2 mb-md-0" placeholder="Raison :" required>
                                <button type="submit" class="btn btn-primary">Valider</button>
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