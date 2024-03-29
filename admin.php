<?php  
    session_start(); 
    if(!isset($_SESSION['captcha'])){
        header('location:captcha.php?error=Chipeur arrête de chipper !');
        exit;
    }
    

    if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 3) {
        header('location:index.php');
        exit;
    }
    
    include('includes/fonctions_logs.php');
    writeVisitLog('admin.php');
    
    include('includes/bd.php');
    
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    
    $query = "SELECT * FROM USERS WHERE 1";
    
    if (!empty($user_id)) {
        $query .= " AND user_id = $user_id";
    }
    if (!empty($email)) {
        $query .= " AND email = '$email'";
    }
    if (!empty($lastname)) {
        $query .= " AND lastname = '$lastname'";
    }
    if (!empty($firstname)) {
        $query .= " AND firstname = '$firstname'";
    }
    
    $users = $bdd->query($query)->fetchAll();

    if(isset($_POST['delete_user']) && isset($_POST['user_id'])) {
        $id = $_POST['user_id'];
        
        $req_publications = $bdd->prepare('DELETE FROM PUBLICATIONS WHERE user_id = :id');
        $req_publications->execute(array(':id' => $id));

        $req_storys = $bdd->prepare('DELETE FROM STORYS WHERE user_id = :id');
        $req_storys->execute(array(':id' => $id));

        $req = $bdd->prepare('DELETE FROM USERS WHERE user_id = :id');
        $req->execute(array(':id' => $id));

        if(isset($_POST['raison_suppression'])) {
            $raison = $_POST['raison_suppression'];
            $log_file = 'delete_user_log.txt';
            file_put_contents($log_file, "Utilisateur supprimé (ID: $id) - Raison: $raison\n", FILE_APPEND);
        }

        header('location: admin.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="fr">

<?php 
$title='Admin';
$url = 'admin.php'; //Permet de revenir sur cette page en cas d'erreurs dans les pages newsletter
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
                        <input type="text" name="user_id" id="user_id" class="form-control" value="<?php echo $user_id; ?>">
                    </div>
                    <div class="col-12 col-sm-4 col-md-5 form-group"> 
                        <label for="email">Email :</label>
                        <input type="text" name="email" id="email" class="form-control" value="<?php echo $email; ?>">
                    </div>
                    <div class="col-6 col-sm-3 col-md-2 form-group">
                        <label for="lastname">Nom :</label>
                        <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo $lastname; ?>">
                    </div>
                    <div class="col-6 col-sm-3 col-md-2 form-group">
                        <label for="firstname">Prénom :</label>
                        <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo $firstname; ?>">
                    </div>
                    <div class="col-12 col-md-2 mt-3 mt-md-0">
                        <button type="submit" class="btn btn-primary w-100">Rechercher</button>
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
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="text-center"><?php echo $user['user_id']; ?></td>
                        <td class="text-center"><?php echo $user['lastname']; ?></td>
                        <td class="text-center"><?php echo $user['firstname']; ?></td>
                        <td class="text-center"><?php echo $user['email']; ?></td>
                        <td class="text-center"><?php echo $user['statut'] == '1' ? "Etudiant" : ($user['statut'] == '2' ? "Recruteur" : "Admin"); ?></td>
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
                                <button type="submit" class="btn btn-danger" name="delete_user">Bannir</button>
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

<?php include('includes/footer.php'); ?>

</body>