<?php 

session_start();
include("../includes/bd.php");

if (isset($_GET['competence']) && !empty($_GET['competence'])
&& isset($_GET['question']) && !empty($_GET['question'])
&& isset($_GET['answer1']) && !empty($_GET['answer1'])
&& isset($_GET['answer2']) && !empty($_GET['answer2'])
&& isset($_GET['answer3']) && !empty($_GET['answer3'])
&& isset($_GET['answer4']) && !empty($_GET['answer4'])
&& isset($_GET['answerCorrect']) && !empty($_GET['answerCorrect']) ){
    
    $q='SELECT competence_id FROM COMPETENCES WHERE name=:name;';
    $req=$bdd->prepare($q);
    $req->execute([
        'name'=>$_GET['competence']
    ]); 

    $result=$req->fetch(PDO::FETCH_ASSOC);
    foreach($result as $index4=>$value4){
        $competenceName=$value4;
    }

    $q2='INSERT INTO QUESTIONS (question,answerCorrect,answer1,answer2,answer3,answer4,competence_id) VALUES (:question,:answerCorrect,:answer1,:answer2,:answer3,:answer4,:competence_id);';
    $req2=$bdd->prepare($q2);
    $req2->execute([
        'question'=> $_GET['question'],
        'answerCorrect'=> $_GET['question'],
        'answer1'=> $_GET['answer1'],
        'answer2'=> $_GET['answer2'],
        'answer3'=>$_GET['answer3'],
        'answer4'=> $_GET['answer4'],
        'competence_id'=> $competenceName
    ]); 

    echo "1";
} else {
    echo "0";
}

?>