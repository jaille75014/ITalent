<?php
session_start();

include("../includes/bd.php");

if(isset($_GET['question'])&&!empty($_GET['question'])){
    $q='DELETE FROM QUESTIONS WHERE question=?';
    $req=$bdd->prepare($q);
    $req->execute([
        htmlspecialchars($_GET['question'])
    ]);
}

?>