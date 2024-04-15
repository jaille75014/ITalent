<?php
header("Content-Type: application/json");
session_start();
include("../includes/bd.php");


if (isset($_GET['competence'])&& !empty($_GET['competence'])
    && $_GET['competence']!=="Sélectionner une compétence"){
        
        
    $q='SELECT question,answer1,answer2,answer3,answer4,answerCorrect FROM QUESTIONS INNER JOIN COMPETENCES ON QUESTIONS.competence_id=COMPETENCES.competence_id WHERE name=? ;';
        $req=$bdd->prepare($q);
        $req->execute([
        htmlspecialchars($_GET['competence'])
    ]); 

    $result=$req->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
                        
}

?>