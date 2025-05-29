<script>
const chatBox = document.getElementById('chatBox');
chatBox.scrollTop = chatBox.scrollHeight;
<?php if (isset($_GET['id'])): ?>
const conn = new WebSocket('ws://localhost:8080');


conn.onopen = function() {
    console.log('Connected to WebSocket server');
    conn.send(JSON.stringify({
        user_id: <?php echo $user->getUserId(); ?>
    }));
};


conn.onmessage = function(e) {
    const data = JSON.parse(e.data);
    const chatBox = document.getElementById('chatBox');


    const currentReceiverId = new URLSearchParams(window.location.search).get('id');

    if (data.sender_id == currentReceiverId) {
        pop();
        const messageClass = data.sender_id == <?php echo $user->getUserId(); ?> ? 'outcoming' : 'incoming';
        const newMessage = document.createElement('div');
        newMessage.classList.add(messageClass);
        newMessage.style.animation = "pop 0.5s";
        newMessage.innerHTML = `<div class="message-data">${data.message}</div>`;
        chatBox.appendChild(newMessage);
        chatBox.scrollTop = chatBox.scrollHeight;
    } else {
        pop();
        newMessage(data.sender_username, data.message);
    }

    setTimeout(() => {
        $("#friendsList").load("friends.php");
    }, 100);
};

// Funkcja do wysyłania wiadomości
function sendMessage() {
    const message = document.querySelector('.input-message').value;
    const chatBox = document.getElementById('chatBox');
    document.querySelector('.input-message').focus();
    chatBox.scrollTop = chatBox.scrollHeight;
    if (message.trim() !== "") {
        const data = {
            message: message,
            sender_id: <?php echo $user->getUserId(); ?>,
            receiver_id: <?php echo $_GET['id']; ?>
        };

        // Wysłanie danych do serwera WebSocket
        conn.send(JSON.stringify(data));

        const chatBox = document.getElementById('chatBox');
        const newMessage = document.createElement('div');
        newMessage.classList.add('outcoming');


        newMessage.innerHTML = `<div class="message-data">${message}</div>`;
        chatBox.appendChild(newMessage);
        chatBox.scrollTop = chatBox.scrollHeight;

        document.querySelector('.input-message').value = '';

        setTimeout(() => {
            $("#friendsList").load("friends.php");
        }, 100);
    }
}
<?php endif; ?>

function clickPress(event) {
    if (event.key == "Enter" && !event.shiftKey) {
        event.preventDefault();
        sendMessage();
    }
}

function changeUsername(element) {
    let input = document.createElement("input");
    input.type = "text";
    input.className = element.className;
    input.value = element.innerText;
    element.replaceWith(input);
    input.focus();
}

function back() {
    window.location.href = "index.php";
}
</script>