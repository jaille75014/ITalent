<?php
session_start();
$_SESSION['code'] = '1';
include('../includes/bd.php');
include('../includes/phpmailer.php');
include('../includes/header_location.php');

function executeQuery($bdd, $query, $params) {
    $req = $bdd->prepare($query);
    $req->execute($params);
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

function sendEmail($mail, $email, $rand_verification_email, $id_user) {
    //Recipients
    $mail->setFrom('italent.contact.site@gmail.com', 'Italent');
    $mail->addAddress(htmlspecialchars($email)); // Destinataire

    $body = '<p>Bonjour, nous vous remercions de faire confiance à Italent pour la recherche de votre prochain emploi ! <br><br>
    Nous avons juste besoin d\'une petite vérification de votre part pour que vous puissiez vous connecter. <br>
    Copiez ce code : <br></p>
    <h3>' . $rand_verification_email . '</h3>
    <p>Et cliquez sur ce lien pour vérifier votre identitée : <a href="https://italent.site/back/codes_verification.php?id=' . $id_user . '&token=' . $rand_verification_email . '&check=0">Clique vite !</a><br>
    <b>Attention !</b> Ce lien n\'est valable que pendant 1h! </p>';

    //Attachments :
    $mail->addAttachment('../assets/LOGO_version_complète.png', "LOGO_version_complète.png");

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Confirmation de votre inscription';
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);

    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    } 
}

$rand_verification_email = rand(1000000, 9999999); // Genère une valeur à 7 chiffres
$result = executeQuery($bdd, 'SELECT user_id FROM USERS WHERE email = :email', ['email' => htmlspecialchars($_GET['message'])]);
$id_user = $result;

$date = date('Y-m-d H:i:s', time() + 60*60); // Rajoute une heure pour stocker l'expiration

executeQuery($bdd, 'INSERT INTO TOKEN (value, date, user_id) values (:value, :date, :user_id)', 
    [
        'value' => $rand_verification_email, 
        'date' => $date, 
        'user_id' => $id_user
    ]);

sendEmail($mail, $_GET['message'], $rand_verification_email, $id_user);

if(isset($_GET['reload'])){
    $result = executeQuery($bdd, 'SELECT email_check FROM USERS WHERE email = :email', ['email'=> htmlspecialchars($_GET['message'])]);
    if($result['email_check'] = 1){
        redirectSuccess('../connexion.php', 'Votre email a été vérifié, veuillez vous connecter');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Intégration de la police d'écriture  -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
<!-- Intégration Bootstrap 5  -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- Intégration de notre CSS -->
<link type="text/css" rel="stylesheet" href="../css/style.css">
    <title>Verification</title>
</head>
<body>
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center mb-4">Code de vérification envoyé, consultez votre boite mail ! Lorsque votre email aura été vérifié, revenez sur cette page...</h2>
        </div>
    </div>
</div>>
<script>
    function auto_reload()
    {
        window.location = 'https://italent.site/back/verification_email.php?reload=1';  //your page location
    }

    // Reload the page every 10 seconds.
    var timer = setInterval(auto_reload, 10000);
</script> 
</body>
</html>
