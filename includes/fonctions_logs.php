<?php
// Fonction qui écrit une ligne dans le fichier log.txt
function writeLogLine($success, $email){
    // Fuseau horaire Français
    date_default_timezone_set('Europe/Paris');

    // Ouverture du flux log.txt
    $log = fopen($success ? '../logs/log_reussies.txt' : '../logs/log_echouées.txt', 'a+');

    // Création de la ligne à ajouter
    // AAAA/mm/jj - h/m/s - tentative de connexion échoué de email
    $line = date("Y/m/d - H:i:s") . '- Tentative de connexion ' . ($success ? 'réussie' : 'échouée') . ' de : ' . $email . "\r";

    // Ajouter la ligne au flux ouvert
    fputs($log,$line);

    // Fermeture du flux
    fclose($log);
}

// Fonction pour enregistrer une visite de page
function writeVisitLog($page){
    // Fuseau horaire Français
    date_default_timezone_set('Europe/Paris');

    // Ouverture du flux log_visites.txt
    $log = fopen('../logs/log_visites.txt', 'a+');

    // Création de la ligne à ajouter
    // AAAA/mm/jj - h/m/s - Visite de la page 'page'
    $line = date("Y/m/d - H:i:s") . '- Visite de la page : ' . $page . "\r";

    // Ajouter la ligne au flux ouvert
    fputs($log,$line);

    // Fermeture du flux
    fclose($log);
}

?>