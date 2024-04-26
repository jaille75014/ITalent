<?php

try {
    $bdd = new PDO('mysql:host=localhost:3306;dbname=italent', 'root', 'AJR3MOUSQUETAIRES');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur :' . $e->getMessage());
}

?> 