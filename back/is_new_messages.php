<?php 

include('../includes/bd.php');

$new_messages = $bdd->query('SELECT * FROM MESSAGE WHERE read_message = 0')->fetchAll();

header('Content-Type: application/json');
echo json_encode($new_messages);

?>