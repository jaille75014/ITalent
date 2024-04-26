<?php
$mdp=$_SERVER['SERVER_NAME']=='localhost'?'root':'AJR3MOUSQUETAIRES';
try {
    $bdd = new PDO('mysql:host=localhost:3306;dbname=italent', 'root', $mdp);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur :' . $e->getMessage());
}

?> 