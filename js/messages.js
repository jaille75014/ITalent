$(document).ready(function() {
    // Boucle -> quand la classe "user-item" est cliquée 
    $('.user-item').on('click', function() {
        // Récupérer l'identifiant de l'utilisateur 
        var userId = $(this).data('user-id');
        fetchMessages(userId);
    });

    // Quand le formulaire avec l'ID 'message-form' est soumis
    $('#message-form').submit(function(event) {
        // Indique à l'agent utilisateur que si l'évènement n'est pas explicitement géré, l'action par défaut ne devrait pas être exécutée comme elle l'est normalement.
        event.preventDefault();
        // Récupérer le message à partir de l'entrée utilisateur
        var message = $('#message-input').val();
        // Récupérer l'identifiant de l'utilisateur
        var userId = $('#chat-box').data('user-id');
        // Vérifier si le message n'est pas vide ou seulement composé d'espaces
        if (message !== '') {
            // Appeler la fonction sendMessage avec l'identifiant de l'utilisateur et le message
            sendMessage(userId, message);
            // Réinitialiser la valeur de l'entrée de message à vide
            $('#message-input').val('');
        }        
    });

    // Récupérer les messages de l'utilisateur spécifié
    function fetchMessages(userId) {
        $.ajax({
            url: 'fetch_messages.php', // URL de la requête AJAX
            type: 'GET', 
            data: { user_id: userId }, // Données envoyées avec la requête
            success: function(data) {
                // Succès de la requête : Mettre à jour le contenu avec les messages récupérés
                $('#chat-box').html(data);
                // Stocker l'identifiant de l'utilisateur
                $('#chat-box').data('user-id', userId);
            }
        });
    }

    // Envoyer un message à l'utilisateur spécifié
    function sendMessage(userId, message) {
        $.ajax({
            url: 'send_message.php', // URL de la requête AJAX
            type: 'POST', 
            data: { user_id: userId, message: message }, // Données envoyées avec la requête
            success: function() {
                // Succès de la requête : Récupérer les messages mis à jour après l'envoi du message
                fetchMessages(userId);
            }
        });
    }
});