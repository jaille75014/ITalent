<?php 

include("../includes/bd.php");
if(isset($_GET['followed']) && isset($_GET['follower'])){
    $followed = $_GET['followed'];
    $follower = $_GET['follower'];
    $insert_connects = 'INSERT INTO CONNECTS (student_id, recruiteur_id) VALUES (:followed, :follower)';
    $query = $bdd->prepare($insert_connects);
    $success = $query->execute([
        'followed' => $followed,
        'follower' => $follower
    ]);
    if($success){
        http_response_code(201); // Created
    } else{
        http_response_code(500); // Internal server error
        
        echo "Error: " . $query->errorInfo()[2];
    }   
} else{
http_response_code(400); // Bad request
} 

?>