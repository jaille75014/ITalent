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

            <!-- La suite de section est un code moche temporaire afin que le footer ne passe pas au-dessus du header (comme sorti du flux), à virer quand la page sera complète -->

            <section class="pt-5" id="Top">
                <section class="pt-5" id="Top">
                    <section class="pt-5" id="Top">
                    </section>
                </section>
            </section>



                <?php 
                    if(isset($_GET['message'])){
                        echo '<p>'.htmlspecialchars($_GET['message']).'</p>'; 
                    }
                ?>
            </div>
        </main>

        <?php include('includes/footer.php');?>

    </body>
</html>