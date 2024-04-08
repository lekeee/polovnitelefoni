<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once dirname(__DIR__) . "../config/config.php";
require_once dirname(__DIR__) . "../classes/Messages.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if ($data["action"] == "fetch_chat") {
        $message = new Messages();
        $message->setSenderId($data['receiverId']);
        $message->setReceiverId($data['userId']);
        $message->setStatus(1);
        $message->changeChatStatus();

        echo json_encode($message->getMessages());
    }

}
