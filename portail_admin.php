<!DOCTYPE html>
<html lang="en">
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
    <link type="text/css" rel="stylesheet" href="CSS/style.css">
    <title>Admin</title>
</head>
<body>
    <?php include('includes/header.php'); ?>
<style>
    
</style>
    <main class="admin">
        <div class="container-fluid">
            <?php 
            if(isset($GET['message'])) {
                echo '<p>' . htmlspecialchars($GET['message']) . '</p>';
            }
            ?>
        <form action="verification_connexion_admin.php" method="POST">
            <input type="email" name="email" class="form-control" placeholder="votre email">
            <input type="password" name="password" class="form-control" placeholder="votre mot de passe">
            <input type="submit">
        </form>
        </div>
    </main>
</body>
</html>