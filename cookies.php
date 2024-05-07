<!DOCTYPE html>
<html lang="fr">
<?php 
    include('includes/fonctions_logs.php');

    $title='Cookies';
    $url = 'cookies'; // Utilisé pour revenir sur cette page en cas d'erreurs dans les pages newsletter
    include('includes/head.php');

    writeVisitLog($url);
?>
<body>
    <?php 
    include('includes/header.php'); ?>

    <main class="container">
    <h1 class="text-center my-4">Politique d'utilisation des <span class="text-primary">Cookies</span></h1>

    <picture>
        <img src="assets/cookies.webp" alt="Image de cookies sur internet">
        <style>
            picture{
                display: flex;
                justify-content: center;
            }
            </style>
    </picture>

<p>Bienvenue sur Italent ! Comme de nombreux autres sites Web, nous utilisons des cookies pour améliorer votre expérience en ligne. 
    Cette politique explique ce que sont les cookies, comment nous les utilisons et comment vous pouvez les gérer.</p>

<h2 class="text-center">Qu'est-ce qu'un <span class="text-primary">cookie ?</span></h2>

<p>Un cookie est un petit fichier texte placé sur votre ordinateur ou appareil mobile lorsque vous visitez un site Web. Il permet au site de se souvenir de vos actions et préférences 
    (telles que votre nom d'utilisateur, la langue choisie, la taille de la police et d'autres préférences d'affichage) sur une période de temps donnée. Cela signifie que vous n'avez
     pas besoin de saisir ces informations à chaque fois que vous revenez sur le site ou que vous naviguez d'une page à une autre.</p>

<h2 class="text-center" >Comment utilisons-nous les cookies ?</h2>

<p>Nous utilisons les cookies pour diverses raisons, notamment :</p>
<ul>
    <li>Pour vous authentifier et vous identifier lorsque vous utilisez nos services.</li>
    <li>Pour personnaliser votre expérience sur notre site Web.</li>
    <li>Pour analyser la manière dont vous utilisez notre site Web.</li>
</ul>

<br>

Vous avez le contrôle sur les cookies que vous acceptez ou refusez. La plupart des navigateurs Web acceptent automatiquement les cookies, 
mais vous pouvez généralement modifier les paramètres de votre navigateur pour refuser les cookies si vous préférez. 
Toutefois, veuillez noter que si vous désactivez les cookies, certaines fonctionnalités de notre site Web peuvent ne pas fonctionner correctement.</p>

<h3 class="text-center" >Questions ?</h3>
<p class="my-4">Si vous avez des questions concernant notre utilisation des cookies, n'hésitez pas à nous contacter à l'adresse <b><a href="mailto:italent.contact.site@gmail.com">italent.contact.site@gmail.com</a></b> pour obtenir plus d'informations. <br>

En continuant à utiliser notre site Web, vous acceptez notre utilisation des cookies conformément à la présente politique.</p>
    </main>
    
    <?php 
    include('includes/footer.php'); ?>
</body>
</html>