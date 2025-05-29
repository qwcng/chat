<?php
require 'vendor/autoload.php';
require_once "cfg.php";


use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;

class ChatServer implements MessageComponentInterface {
    protected $clients;
    protected $users;
    protected $user;
    protected $chat;    
    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->users = [];
        $this->user = new User();
        $this->chat = new Chat();
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Połączenie otwarte: ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg,true );
        if (isset($data['user_id'])) {
            $userId = $data['user_id'];
            $this->users[$userId] = $from;
            
            echo "✅ Użytkownik {$userId} został zarejestrowany.\n";
            $this->user->status($userId, 'online');
            return;
        }
        $senderId = $data['sender_id'];
        $receiverId = $data['receiver_id'];
        $messageText = $data['message'];
        $senderUsername = $this->chat->getSenderUsername($senderId);
        $this->chat->sendMessage($senderId, $receiverId, $messageText);
        $response = [
            'sender_id' => $senderId,
            'sender_username' => $senderUsername,
            'receiver_id' => $receiverId,
            'message' => $messageText
        ];
        
        $jsonResponse = json_encode($response);
        if (isset($this->users[$receiverId])) {
            $this->users[$receiverId]->send($jsonResponse);
            echo "📩 Wiadomość wysłana do {$receiverId}.\n";
        } else {
            echo "⚠️ Użytkownik {$receiverId} jest offline, wiadomość zapisana w bazie.\n";
        }
    }

    public function onClose(ConnectionInterface $conn) {
        foreach ($this->users as $user_id => $client) {
            if ($client === $conn) {
                unset($this->users[$user_id]);
                echo "Użytkownik {$user_id} rozłączony.\n";
                $this->user->status($user_id, 'offline');
                break;
            }
        }
        
        $this->clients->detach($conn);
        echo "Połączenie zamknięte: ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Błąd: {$e->getMessage()}\n";
        $conn->close();
    }
}
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatServer()
        )
    ),
    8080
);

echo "Serwer WebSocket działa na porcie 8080...\n";
$server->run();