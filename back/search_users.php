<?php 
// includes
include('../includes/bd.php');

    
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $req = $bdd->prepare('SELECT user_id, firstname, lastname, email, statut FROM USERS WHERE user_id LIKE ?');
    $success = $req->execute([
        '%' . $id .'%'
    ]);

} elseif(isset($_GET['email'])) {
    $email = $_GET['email'];
    $req = $bdd->prepare('SELECT user_id, firstname, lastname, email, statut FROM USERS WHERE email LIKE ?');
    $success = $req->execute([
        '%' . $email .'%'
    ]);

} elseif(isset($_GET['lastname'])) {
    $lastname = $_GET['lastname'];
    $req = $bdd->prepare('SELECT user_id, firstname, lastname, email, statut FROM USERS WHERE lastname LIKE ?');
    $success = $req->execute([
        '%' . $lastname .'%'
    ]);

} elseif(isset($_GET['firstname'])) {
    $firstname = $_GET['firstname'];
    $req = $bdd->prepare('SELECT user_id, firstname, lastname, email, statut FROM USERS WHERE firstname LIKE ?');
    $success = $req->execute([
        '%' . $firstname .'%'
    ]);
}

if($success){
    $users = $req->fetchAll(PDO::FETCH_ASSOC);

    foreach($users as $user) {
        echo '<tr>';
        echo '<td class="text-center">' . $user['user_id'] . '</td>';
        echo '<td class="text-center">' . $user['lastname'] . '</td>';
        echo '<td class="text-center">' . $user['firstname'] . '</td>';
        echo '<td class="text-center">' . $user['email'] . '</td>';
        echo '<td class="text-center">';
        switch ($user['statut']) {
            case '1':
                echo "Etudiant";
                break;
            case '2':
                echo "Recruteur";
                break;
            case '3':
                echo "Admin";
                break;
            default:
                echo "Banni temporairement";
                break;
        }
        echo '</td>';
        echo '<td class="text-center">
                <form method="post">
                    <input type="hidden" name="user_id" value="' . $user['user_id'] . '">
                    <button type="submit" class="btn btn-danger" name="delete_publications">Supprimer</button>
                </form>
              </td>';
        echo '<td class="text-center">
                <form method="post">
                    <input type="hidden" name="user_id" value="' . $user['user_id'] . '">
                    <button type="submit" class="btn btn-danger" name="delete_story">Supprimer</button>
                </form>
              </td>';
    echo '<td class="text-center">
            <form method="post">
                <input type="hidden" name="user_id" value="' . $user['user_id'] . '">
                <button type="submit" class="btn btn-danger" name="delete_user">Bannir</button>
            </form>
          </td>';
    echo '<td class="text-center">
            <form class="d-flex flex-column flex-md-row" method="post">
                <input type="hidden" name="user_id" value="' . $user['user_id'] . '">
                <input type="text" name="raison_suppression" class="form-control me-md-2 mb-2 mb-md-0" placeholder="Raison :" required>
                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
          </td>';
    echo '</tr>';
    }
    echo '</table>';
    
}
?>