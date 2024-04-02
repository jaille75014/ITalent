<?php
function redirectFailure($location, $message) { //Fonction de redirection avec message d'erreur
    header("location: $location?messageFailure=$message");
    exit;
}

function redirectSuccess($location, $message) { //Fonction de redirection avec message de succès
    header("location: $location?messageSuccess=$message");
    exit;
}

?>