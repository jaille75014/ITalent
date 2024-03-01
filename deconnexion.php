<?php 
    session_start(); // Demarrage de la session afin de la détruire
    session_destroy(); // Destruction de la session
    
    header('location:index.php'); // Redirection vers l'accueil
    exit;
    
    
    
    
?>



