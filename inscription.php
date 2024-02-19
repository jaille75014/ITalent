<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/litera/bootstrap.min.css" integrity="sha384-enpDwFISL6M3ZGZ50Tjo8m65q06uLVnyvkFO3rsoW0UC15ATBFz3QEhr3hmxpYsn" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Inscription | ITalent</title>
    </head>

    <body>
    <?php include('includes/header.php');?>
    <main>
        <div class="container">
            <div class="card">
            <div class="form-group col-6">
                <form>
                   <input type="text" class="form-control" name="nom" placeholder="Entrez votre nom :">
                 </div>
                 <div class="form-group col-6">
                <form>
                   <input type="text" class="form-control" name="prenom" placeholder="Entrez votre Prénom :">
                 </div>
                 <div class="form-group col">
                   <input type="email" class="form-control" name="email" placeholder="Entrez votre E-mail :">
                 </div>
                 <div class="form-group col">
                <form>
                   <input type="password" class="form-control" name="password" placeholder="Entrez un mot de passe :">
                 </div>
                 <div class="form-group">
                     <label for="fichier">Ajoutez une photo de profil</label>
                     <input type="file" class="form-control-file" id="fichier">
                 </div>
             </form>
         </div>
        </div>
    </main>
    <footer>

    </footer>        
    </body>


</html>