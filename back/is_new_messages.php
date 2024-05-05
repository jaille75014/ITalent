<?php 
session_start();
include('../includes/bd.php');

$user_id = $_SESSION['user_id'];

$new_messages = $bdd->prepare('SELECT count(*) FROM MESSAGE WHERE read_message = 0 AND user_id_target_id = ?');
$new_messages->execute([$user_id]);
$new_messages = $new_messages->fetchColumn();


header('Content-Type: application/json');
echo json_encode($new_messages);

?>