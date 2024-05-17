<?php 
// includes
include('../includes/bd.php');

    
if(isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
    $req = $bdd->prepare('SELECT user_id, firstname, lastname, email, statut FROM USERS WHERE user_id LIKE ?');
    $success = $req->execute([
        '%' . $id .'%'
    ]);

} elseif(isset($_GET['email'])) {
    $email = htmlspecialchars($_GET['email']);
    $req = $bdd->prepare('SELECT user_id, firstname, lastname, email, statut FROM USERS WHERE email LIKE ?');
    $success = $req->execute([
        '%' . $email .'%'
    ]);

} elseif(isset($_GET['lastname'])) {
    $lastname = htmlspecialchars($_GET['lastname']);
    $req = $bdd->prepare('SELECT user_id, firstname, lastname, email, statut FROM USERS WHERE lastname LIKE ?');
    $success = $req->execute([
        '%' . $lastname .'%'
    ]);

} elseif(isset($_GET['firstname'])) {
    $firstname = htmlspecialchars($_GET['firstname']);
    $req = $bdd->prepare('SELECT user_id, firstname, lastname, email, statut FROM USERS WHERE firstname LIKE ?');
    $success = $req->execute([
        '%' . $firstname .'%'
    ]);
}

if($success){
    $users = $req->fetchAll(PDO::FETCH_ASSOC);

    foreach($users as $user) {
        echo '<tr>';
        echo '<td>' . $user['user_id'] . '</td>';
        echo '<td>' . $user['lastname'] . '</td>';
        echo '<td>' . $user['firstname'] . '</td>';
        echo '<td>' . $user['email'] . '</td>';
        echo '<td>';
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
                    <button type="submit" class="btn btn-warning" name="delete_publications">Supprimer</button>
                </form>
              </td>';
        echo '<td class="text-center">
                <form method="post">
                    <input type="hidden" name="user_id" value="' . $user['user_id'] . '">
                    <button type="submit" class="btn btn-warning" name="delete_story">Supprimer</button>
                </form>
              </td>';
    echo '<td class="text-center">
            <form method="post">
                <input type="hidden" name="user_id" value="' . $user['user_id'] . '">
                <input type="hidden" name="user_id" value="' . $user['user_id'] . '">
                <input type="text" name="raison_suppression" placeholder="Raison :" required>
                <button type="submit" class="btn btn-danger" name="delete_user" onclick="return confirm(\'Êtes-vous sûr de vouloir bannir cet utilisateur ?\')">Bannir</button>
            </form>
          </td>';
    echo '</tr>';
    }
    echo '</table>';
    
}
?>