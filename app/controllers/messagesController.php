<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Content-Type: application/json");

require_once dirname(__DIR__) . "../config/config.php";
require_once dirname(__DIR__) . "../classes/Messages.php";

if (isset($_POST)) {
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
