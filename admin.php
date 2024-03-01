<?php 
    session_start(); 
    if (!isset($_SESSION['statut']) || $_SESSION['statut'] != 3) {
        header('location:index.php');
        exit;
    }

    include('includes/bd.php');


    // $id = $_POST['user_id'];
    // $stmt->bindValue(':id', $id);
    // $req = $bdd->prepare('DELETE FROM USERS WHERE user_id = :id');
    // $req->execute(array($_GET['user_id']));
    // $res = $stmt->execute();
    // $req->closeCursor();


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

        <?php include('includes/header.php');?>

        <main class="bg-light">
            <div class="container">

                <h1> Coucou Admin ! </h1>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <?php foreach ($users as $user): ?> -->
                            <tr>
                                <td><?php echo $user['user_id']; ?></td>
                                <td><?php echo $user['lastname']; ?></td>
                                <td><?php echo $user['firstname']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php if($user['statut'] == '1') {
                                    echo "Etudiant";
                                    } else if ($user['statut'] == '2') {
                                        echo "Recruteur";
                                    } else {
                                        echo "Admin"; }?></td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="btn btn-danger" name="delete_user">Supprimer</button>
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