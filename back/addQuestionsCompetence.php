<?php 



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
        'name'=>htmlspecialchars($_GET['competence'])
    ]); 

    $result=$req->fetch(PDO::FETCH_ASSOC);
    
    

    $q2="INSERT INTO QUESTIONS (question,answerCorrect,answer1,answer2,answer3,answer4,competence_id) VALUES (:question,:answerCorrect,:answer1,:answer2,:answer3,:answer4,:competence_id);";
    $req2=$bdd->prepare($q2);
    $req2->execute([
        'question'=> htmlspecialchars($_GET['question']),
        'answerCorrect'=> htmlspecialchars($_GET['answerCorrect']),
        'answer1'=> htmlspecialchars($_GET['answer1']),
        'answer2'=> htmlspecialchars($_GET['answer2']),
        'answer3'=>htmlspecialchars($_GET['answer3']),
        'answer4'=> htmlspecialchars($_GET['answer4']),
        'competence_id'=> htmlspecialchars($result['competence_id'])
    ]); 

    echo "1";
} else {
    echo "0";
}

?>