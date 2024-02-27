<?php
include('includes/bd.php');

session_start();

if (isset($_SESSION['email'])) {
    header('location:index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
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
    <title>Connexion | ITalent</title>
</head>


<body class="bg-light">

    <?php include('includes/header.php'); ?>

    <main class="admin">

        <div class="container">
            <?php 
            if(isset($_GET['message'])){
                echo '<p>'.htmlspecialchars($_GET['message']).'</p>'; 
            }
            ?>
            <form action="verification_connexion.php" method="post">
                <input type="email" name="email" placeholder="Votre email : " 
                    value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : '' ?>">
                <input type="password" name="password" placeholder="Votre mot de passe : ">
                <input type="submit" value="Connexion">
            </form>
        </div>

    </main>

    <?php include('includes/footer.php');?>

</body>
</html>