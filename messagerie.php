<?php

session_start();
if (isset($_GET['deconnexion'])) {
	session_destroy();
	header('location: connexion.php');
 }

include('includes/bd.php');

if(!$_SESSION['email']){
	header('location:index.php'); 
}
    if(isset($_GET['user_id']) and !empty($_GET['user_id'])){
		$getid = $_GET['user_id'];
		$recupUser = $bdd->prepare('SELECT * FROM users WHERE id = ?');
		$recupUser->execute(array($getid));
		if($recupUser->rowCount()>0){
			if(isset($_POST['envoyer'])){
				$message= htmlspecialchars($_POST['message']);
				$insererMessage= $bdd->prepare('INSERT INTO MESSAGE(content, user_id_target_id, user_id_source) VALUES (?,?,?)');
				$insererMessage->execute(array($message,$getid,$_SESSION['user_id']));
			}
		}else{
		echo "Aucun utlisateur trouvé";
		}

	}else{
		echo "Aucun identifiant trouvé";
	}

?>
<!DOCTYPE html>
<html>


    <head>
        <meta charset="UTF-8">
        <title>Messagerie | ITalent</title>
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


    <body> 
    
        <?php include('includes/header.php');?>

        <form method="POST" action="">
            <div class="form-group">
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="message"></textarea>
            </div>
            <br>
            <input class="btn btn-primary" type="submit" name="envoyer">
        </form>

        <section>
            <?php 
                $recupMessages = $bdd->prepare('SELECT * FROM MESSAGE WHERE user_id_target_id = ? AND user_id_source = ? OR user_id_source = ? AND user_id_target_id = ?');
                $recupMessages->execute(array($_SESSION['message_id'],$_GET['message_id'],$_GET['message_id'],$_SESSION['message_id']));
                while($message=$recupMessages->fetch()){
                    if($message['user_id_target_id'] == $_SESSION['user_id']){
                        ?>
                        <p style="text-align:right; color:red;"><?= $message['message']; ?></p>
                        <?php
                    }elseif($message['user_id_target_id'] == $getid){
                        ?>
                        <p style="text-align:left;"><?= $message['message']; ?></p>
                        <?php
                    }
                    
                }
            ?>
        </section>

    </body>
</html>