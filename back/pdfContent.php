<!DOCTYPE html>
<html lang="fr">

    <body>

        <div class="container">

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="mt-5">
                        <?php
                        include('../includes/bd.php');
                        session_start();

                        if (!isset($_SESSION['user_id'])) {
                            echo "<p class='text-danger'>Vous devez être connecté pour accéder à cette page.</p>";
                        } else {
                            $user_id = $_SESSION['user_id'];

                            // Récupérer les informations de l'utilisateur
                            $user_info_query = "SELECT firstname, lastname, email, tel, zip, city FROM USERS WHERE user_id = :user_id";
                            $user_info_q = $bdd->prepare($user_info_query);
                            $user_info_q->bindParam(':user_id', $user_id);
                            $user_info_q->execute();
                            $user_info = $user_info_q->fetch(PDO::FETCH_ASSOC);

                            if ($user_info) {
                                ?>
                                <h1 class="text-center"><?= $user_info['firstname'] . ' ' . $user_info['lastname'] ?></h1>
                                <div class="mt-4">
                                    <p>Email : <?= $user_info['email'] ?></p>
                                    <p>Téléphone : <?= $user_info['tel'] ?></p>
                                    <p>Adresse : <?= $user_info['zip'] . ' ' . $user_info['city'] ?></p>
                                </div>
                                <?php

                                // Récupérer les compétences de l'utilisateur
                                $competences_query = "SELECT name, level FROM COMPETENCES WHERE user_id = :user_id";
                                $competences_q = $bdd->prepare($competences_query);
                                $competences_q->bindParam(':user_id', $user_id);
                                $competences_q->execute();
                                $competences = $competences_q->fetchAll(PDO::FETCH_ASSOC);

                                if ($competences) {
                                    ?>
                                    <div class="mt-4">
                                        <h2>Compétences</h2>
                                        <ul class="list-group">
                                            <?php foreach ($competences as $competence) : ?>
                                                <li class="list-group-item"><?= $competence['name'] ?> - Niveau : <?= $competence['level'] ?></li>
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