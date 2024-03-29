<?php
session_start();
$_SESSION['code'] = '1';
include('../includes/bd.php');

include('../includes/phpmailer.php');

    $rand_verification_email = rand(1000000, 9999999); // Genère une valeur à 7 chiffres
    $select_id = 'SELECT user_id FROM USERS WHERE email = :email';
    $req = $bdd->prepare($select_id);
    $result = $req->execute([
        'email' => htmlspecialchars($_GET['message'])
    ]);
    $result = $req->fetch(PDO::FETCH_ASSOC);

    $id_user = $result;
    $date = date('Y-m-d H:i:s', strtotime('1 hour')); // Add one hour to the actual date

    $token = 'INSERT INTO TOKEN (value, date, user_id) values (:value, :date, :user_id)';
    $req=$bdd->prepare($token);
    $result=$req->execute([
        'value' => $rand_verification_email,
        'date' => $date,
        'user_id' => $id_user
        ]);


    //Recipients
    $mail->setFrom('italent.contact.site@gmail.com', 'Italent');
    $mail->addAddress(htmlspecialchars($_GET['message'])); // Destinataire

    $body = '<p>Bonjour, nous vous remercions de faire confiance à Italent pour la recherche de votre prochain emploi ! <br><br>
    Nous avons juste besoin d\'une petite vérification de votre part pour que vous puissiez vous connecter. <br>
    Cliquez sur ce lien pour vérifier votre identitée : <a href="https://italent.site/back/codes_verification.php?id=' . $id_user . '&token=' . $rand_verification_email . '&check=0">Clique vite !</a><br>
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
?>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center text-white mb-4">Code de vérification envoyé, consultez votre boite mail !</h2>
            <div class="row">
                <div class="col-md-6 mx-auto">
                </div>
            </div>
        </div>
    </div>
</div>