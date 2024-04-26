<?php 
    session_start();

    if (isset($_POST['answer1']) && !empty($_POST['answer1'])
    && isset($_POST['answer1Correct']) && !empty($_POST['answer1Correct'])

    && isset($_POST['answer2']) && !empty($_POST['answer2'])
    && isset($_POST['answer2Correct']) && !empty($_POST['answer2Correct'])

    && isset($_POST['answer3']) && !empty($_POST['answer3'])
    && isset($_POST['answer3Correct']) && !empty($_POST['answer3Correct'])

    && isset($_POST['answer4']) && !empty($_POST['answer4'])
    && isset($_POST['answer4Correct']) && !empty($_POST['answer4Correct'])

    && isset($_POST['answer5']) && !empty($_POST['answer5'])
    && isset($_POST['answer5Correct']) && !empty($_POST['answer5Correct'])

    && isset($_POST['answer6']) && !empty($_POST['answer6'])
    && isset($_POST['answer6Correct']) && !empty($_POST['answer6Correct'])

    && isset($_POST['answer7']) && !empty($_POST['answer7'])
    && isset($_POST['answer7Correct']) && !empty($_POST['answer7Correct'])

    && isset($_POST['answer8']) && !empty($_POST['answer8'])
    && isset($_POST['answer8Correct']) && !empty($_POST['answer8Correct'])

    && isset($_POST['answer9']) && !empty($_POST['answer9'])
    && isset($_POST['answer9Correct']) && !empty($_POST['answer9Correct'])

    && isset($_POST['answer10']) && !empty($_POST['answer10'])
    && isset($_POST['answer10Correct']) && !empty($_POST['answer10Correct'])
    
    && isset($_POST['competenceTest']) && !empty($_POST['competenceTest'])){

        $score=0;
        if($_POST['answer1']==$_POST['answer1Correct']) $score+=10;
        if($_POST['answer2']==$_POST['answer2Correct']) $score+=10;
        if($_POST['answer3']==$_POST['answer3Correct']) $score+=10;
        if($_POST['answer4']==$_POST['answer4Correct']) $score+=10;
        if($_POST['answer5']==$_POST['answer5Correct']) $score+=10;

        if($_POST['answer6']==$_POST['answer6Correct']) $score+=10;
        if($_POST['answer7']==$_POST['answer7Correct']) $score+=10;
        if($_POST['answer8']==$_POST['answer8Correct']) $score+=10;
        if($_POST['answer9']==$_POST['answer9Correct']) $score+=10;
        if($_POST['answer10']==$_POST['answer10Correct']) $score+=10;


        if ($score>=50){

            if ($score<=60) $newScore=1;
            else if ($score<=70) $newScore=2;
            else if ($score<=80) $newScore=3;
            else if ($score<=90) $newScore=4;
            else $newScore=5;

            include('../includes/bd.php');


            $q='SELECT competence_id FROM COMPETENCES WHERE name=:name';
            $req=$bdd->prepare($q);
            $req->execute([
                'name'=>$_POST['competenceTest']
            ]);
            $result=$req->fetch(PDO::FETCH_ASSOC);
            foreach($result as $index => $value) $id_competence=$value;

            $q2='INSERT INTO POSSESSES (competence_id,user_id,level,validity) VALUES(:competence_id,:user_id,:level,:validity);';
            $req2=$bdd->prepare($q2);
            $req2->execute([
                'competence_id'=> $id_competence,
                'user_id' => $_SESSION['user_id'],
                'level' => $newScore,
                'validity'=> date("Y/m/d")
            ]);




            header('location:../profil?messageSuccess=Félicitation ! Vous avez eu un taux de réussite de '.$score.', pour une note de '.$newScore.'/5 ! La compétence a été ajouté à votre profil.');
            exit;
        } else {
            header('location:../profil?messageFailure=Dommage... Vous avez eu un taux de réussite de '.$score.'%, ce n\'est pas suffisant pour ajouter cette compétence à votre profil.');
            exit;
        }
    } else {
        header('location:../profil?messageFailure=Problème lors de l\'examen.');
        exit;
    }



?>