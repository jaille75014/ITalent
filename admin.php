<?php 
    session_start(); 
    if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 3) {
        header('location:index.php');
        exit;
    }
    
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

        header('Location: admin.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Admin | ITalent</title>
    <meta name="Description" content="ITalent, la révolution de la recherche d'emplois pour les étudiants en Informatique.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Intégration de la police d'écriture  -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <!-- Icône de Boxincons -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Intégration Bootstrap 5  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Intégration de notre CSS -->
    <link type="text/css" rel="stylesheet" href="css/style.css">

</head>

<body class="bg-light">

    <div class="container">

        <h3>Rechercher un utilisateur :</h3>

        <div class="mb-3">
            <form method="post" class="form-inline">
                <div class="form-group mr-2">
                    <label for="user_id" class="mr-2">ID :</label>
                    <input type="text" name="user_id" id="user_id" class="form-control" value="<?php echo $user_id; ?>">
                </div>
                <div class="form-group mr-2">
                    <label for="email" class="mr-2">Email :</label>
                    <input type="text" name="email" id="email" class="form-control" value="<?php echo $email; ?>">
                </div>
                <div class="form-group mr-2">
                    <label for="lastname" class="mr-2">Nom :</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo $lastname; ?>">
                </div>
                <div class="form-group mr-2">
                    <label for="firstname" class="mr-2">Prénom :</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo $firstname; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Rechercher</button>
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
                            <td class="text-center"><?php if($user['statut'] == '1') {
                                echo "Etudiant";
                                } else if ($user['statut'] == '2') {
                                    echo "Recruteur";
                                } else {
                                    echo "Admin"; }?></td>
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
                                <form class="d-flex" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                    <input type="text" name="raison_suppression" class="form-control me-2" placeholder="Raison :" required>
                                    <button type="submit" class="btn btn-primary">Valider</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
    

        </div>
    </main>

    <?php include('includes/footer.php');?>

</body>
</html>