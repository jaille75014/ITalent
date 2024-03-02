$(document).ready(function() {
    $('.user-item').on('click', function() {
        var userId = $(this).data('user-id');
        fetchMessages(userId);
    });

    $('#message-form').submit(function(event) {
        event.preventDefault();
        var message = $('#message-input').val();
        var userId = $('#chat-box').data('user-id');
        if (message.trim() !== '') {
            sendMessage(userId, message);
            $('#message-input').val('');
        }
    });

    function fetchMessages(userId) {
        $.ajax({
            url: 'fetch_messages.php',
            type: 'GET',
            data: { user_id: userId },
            success: function(data) {
                $('#chat-box').html(data);
                $('#chat-box').data('user-id', userId);
            }
        });
    }

    function sendMessage(userId, message) {
        $.ajax({
            url: 'send_message.php',
            type: 'POST',
            data: { user_id: userId, message: message },
            success: function() {
                fetchMessages(userId);
            }
        });
    }
});