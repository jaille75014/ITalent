<?php
include('includes/bd.php');
$mailCount = $_GET['mailCount'];
$requete = $bdd->prepare('SELECT 
                        NEWSLETTER.title, NEWSLETTER.body, NEWSLETTER.send_date, USERS.firstname, USERS.lastname 
                        FROM NEWSLETTER 
                        INNER JOIN USERS ON 
                        NEWSLETTER.user_id = USERS.user_id 
                        ORDER BY NEWSLETTER.send_date DESC LIMIT :mailCount, 10');
$requete->bindParam(':mailCount', $mailCount, PDO::PARAM_INT); // Indique que le paramètre est un entier
$requete->execute();
while($donnees = $requete->fetch()){
    echo '<tr>';
    echo '<td>'.$donnees['title'].'</td>';
    echo '<td>'.$donnees['body'].'</td>';
    echo '<td>'.$donnees['send_date'].'</td>';
    echo '<td>'.$donnees['firstname'].' '.$donnees['lastname'].'</td>';
    echo '</tr>';
}
?>