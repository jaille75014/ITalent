<!DOCTYPE html>
<html lang="fr">

    <?php include('../includes/head.php'); ?>

    <body>

        <div class="container">

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="mt-5">
                        <?php
                        include('../bd.php');
                        session_start();

                        if (!isset($_SESSION['user_id'])) {
                            echo "<p class='text-danger'>Vous devez être connecté pour accéder à cette page.</p>";
                        } else {
                            $user_id = $_SESSION['user_id'];

                            // Récupérer les informations de l'utilisateur
                            $user_query = "SELECT firstname, lastname, email, tel, zip, city FROM USERS WHERE user_id = :user_id";
                            $user_statement = $bdd->prepare($user_query);
                            $user_statement->bindParam(':user_id', $user_id);
                            $user_statement->execute();
                            $user_row = $user_statement->fetch(PDO::FETCH_ASSOC);

                            if ($user_row) {
                                ?>
                                <h1 class="text-center"><?= $user_row['firstname'] . ' ' . $user_row['lastname'] ?></h1>
                                <div class="mt-4">
                                    <p><strong>Email :</strong> <?= $user_row['email'] ?></p>
                                    <p><strong>Téléphone :</strong> <?= $user_row['tel'] ?></p>
                                    <p><strong>Adresse :</strong> <?= $user_row['zip'] . ' ' . $user_row['city'] ?></p>
                                </div>
                                <?php

                                // Récupérer les compétences de l'utilisateur
                                $competence_query = "SELECT name, level FROM COMPETENCES WHERE user_id = :user_id";
                                $competence_statement = $bdd->prepare($competence_query);
                                $competence_statement->bindParam(':user_id', $user_id);
                                $competence_statement->execute();
                                $competence_rows = $competence_statement->fetchAll(PDO::FETCH_ASSOC);

                                if ($competence_rows) {
                                    ?>
                                    <div class="mt-4">
                                        <h2>Compétences</h2>
                                        <ul class="list-group">
                                            <?php foreach ($competence_rows as $competence_row) : ?>
                                                <li class="list-group-item"><?= $competence_row['name'] ?> - Niveau : <?= $competence_row['level'] ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php } else {
                                    echo "<p>Pas de compétences répertoriées.</p>";
                                }
                            } else {
                                echo "<p class='text-danger'>Utilisateur non trouvé.</p>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </body>

</html>