<?php
session_start();
$_SESSION['code'] = '1';
include('../includes/bd.php');
include('../includes/phpmailer.php');
include('../includes/header_location.php');

function generateReloadUrl($message) {
    $host = $_SERVER['HTTP_HOST'];
    $newLocation = strpos($host, 'italent.site') !== false // vérifie si la chaîne 'italent.site' est contenue dans $host. Si c'est le cas, strpos retourne 
                                                            //l'index de début de la sous-chaîne dans la chaîne principale, qui sera toujours un nombre non négatif. 
                                                            //Si la sous-chaîne n'est pas trouvée, strpos retourne false.
        ? 'https://italent.site/back/verification_email.php?reload=1&message=' . $message
        : 'https://213.32.89.122/back/verification_email.php?reload=1&message=' . $message;
    return $newLocation;
}

if(isset($_GET['reload'])){
    $select_check = 'SELECT email_check FROM USERS WHERE email = :email';
    $req = $bdd->prepare($select_check);
    $req->execute(
    ['email'=> htmlspecialchars($_GET['message'])]);
    $result = $req->fetch(PDO::FETCH_ASSOC);
    
    if($result['email_check'] == 1){
        redirectSuccess('../connexion.php', 'Votre email a été vérifié, veuillez vous connecter');
    } else {
        $reloadUrl = generateReloadUrl($_GET['message']);
        ?>
        <script>
            function auto_reload()
            {
                window.location = '<?php echo $reloadUrl; ?>';
            }

            // Check if the page should be reloaded.
            var urlParams = new URLSearchParams(window.location.search);
            var reload = urlParams.get('reload');

            // Si le paramètre 'reload' n'est pas défini ou est défini à '1', rechargez la page après 10 secondes.
            if (reload === null || reload === '1') {
                setTimeout(auto_reload, 10000);
            }
        </script> 
            <?php
        }
    } else {

    $email = htmlspecialchars($_GET['message']);
    $rand_verification_email = rand(1000000, 9999999); // Genère une valeur à 7 chiffres
    $select_id = 'SELECT user_id FROM USERS WHERE email = :email';
    $req = $bdd->prepare($select_id);
    $req->execute([
        'email' => htmlspecialchars($_GET['message'])
    ]);
    $result = $req->fetch(PDO::FETCH_ASSOC);
    $id_user = $result['user_id'];

    $date = date('Y-m-d H:i:s', time() + 60*60); // Rajoute une heure pour stocker l'expiration

    //Recipients
    $mail->setFrom('italent.contact.site@gmail.com', 'Italent');
    $mail->addAddress(htmlspecialchars($_GET['message'])); // Destinataire

    $serverName = $_SERVER['SERVER_NAME'];

    $body = '<p>Bonjour, nous vous remercions de faire confiance à Italent pour la recherche de votre prochain emploi ! <br><br>
    Nous avons juste besoin d\'une petite vérification de votre part pour que vous puissiez vous connecter. <br>
    Copiez ce code : <br></p>
    <h3>' . $rand_verification_email . '</h3>
    <p>Et cliquez sur ce lien pour vérifier votre identitée : <a href="https://' . $serverName . '/back/codes_verification.php?id=' . $id_user . '&token=' . $rand_verification_email . '&check=0">Clique vite !</a><br>
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
        echo '<p>Un email vient de vous être envoyé, vérifiez vos email et revennez sur cette page lorsque vous aurez terminé !</p>';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    } 


    $insert_token = 'INSERT INTO TOKEN (value, date, user_id) values (:value, :date, :user_id)';
    $req = $bdd->prepare($insert_token);
    $req->execute(
        [
            'value' => $rand_verification_email, 
            'date' => $date, 
            'user_id' => $id_user
        ]);
        $result = $req->fetch(PDO::FETCH_ASSOC);
        ///var_dump($result);
}

?>

<!DOCTYPE html>
<html lang="fr">
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
</div>
<?php 
$reloadUrl = generateReloadUrl($_GET['message']);
?>
        <script>
            function auto_reload()
            {
                window.location = '<?php echo $reloadUrl; ?>';
            }

            // Check if the page should be reloaded.
            var urlParams = new URLSearchParams(window.location.search);
            var reload = urlParams.get('reload');

            // Si le paramètre 'reload' n'est pas défini ou est défini à '1', rechargez la page après 10 secondes.
            if (reload === null || reload === '1') {
                setTimeout(auto_reload, 10000);
            }
        </script> 
</body>
</html>
