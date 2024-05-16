<?php 
try {
    $bdd = new PDO('mysql:host=localhost:3306;dbname=italent', 'root', 'AJR3MOUSQUETAIRES');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur :' . $e->getMessage());
}
include('includes/phpmailer.php');

$delete_user = 'SELECT user_id, date_ban FROM BAN';
$req = $bdd->query($delete_user);
$users = $req->fetchAll(PDO::FETCH_ASSOC);
$bool = false;
foreach ($users as $user) {
    if (strtotime($user['date_ban']) < time()) { 

        $req = $bdd->prepare('DELETE FROM CONNECTS WHERE recruiter_id = :user_id');
        $req->execute([':user_id' => $user['user_id']]);

        $req = $bdd->prepare('DELETE FROM MESSAGE WHERE user_id_source = :user_id');
        $req->execute([':user_id' => $user['user_id']]);

        $req = $bdd->prepare('DELETE FROM USERS WHERE user_id = :user_id');
        $req->execute([':user_id' => $user['user_id']]);

        $req = $bdd->prepare('DELETE FROM BAN WHERE user_id = :user_id');
        $req->execute([':user_id' => $user['user_id']]);
    }
    $bool = true;
}
if($bool){
    $body = '<p>Les utilisateurs bannis ont été supprimés</p>';
} else {
    $body = '<p>Aucun utilisateur supprimé</p>';
}
//Recipients
$mail->setFrom('italent.contact.site@gmail.com', 'Italent');
$mail->addAddress('italent.contact.site@gmail.com'); // Destinataire

//Content
$mail->isHTML(true);                                  //Set email format to HTML
$mail->Subject = 'Suppression des utilisateurs banis';
$mail->Body    = $body;
$mail->AltBody = strip_tags($body);

try {
    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
} 
?>