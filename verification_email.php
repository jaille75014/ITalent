<?php 
session_start();
include('includes/bd.php');

$rand_verification_email = rand(100000, 999999);



echo $rand_verification_email;
$to = $GET['mail'];
$subject = "Confirmation de votre inscription";
$message = 'Bonjour, nous vous remercions de faire confiance à Italent pour la recherche de votre prochain emploi !
Nous avons juste besoin d\'une petite vérification de votre part pour que vous puissiez vous connecter. 
Copiez ce code pour vérifier votre identité et retournez sur Italent !
Code de vérification :'  . $rand_verification_email; 
$headers = "Content-Type: text/plain; charset=utf-8\r\n";
$headers = "FROM: contact@italent.site\n\r";
if(mail($to, $subject, $message, $headers))
    echo 'Un mail a été envoyé, regardez votre boite mail nous vous avons envoyé un code';
else
    echo 'Erreur';

?>