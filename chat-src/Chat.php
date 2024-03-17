<?php
namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface
{
    protected $clients;
    protected $user;
    protected $messages;

    public function __construct($user, $messages)
    {
        $this->user = $user;
        $this->messages = $messages;
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $queryArray);

        $this->user->updateUserConnectionId($queryArray['token'], $conn->resourceId);

        $user_id = $this->user->getUserIdFromToken($queryArray['token']);
        //$this->user->updateLoginStatus($user_id, 1);
        $data['status_type'] = "Online";
        $data['user_id_status'] = $user_id;

        foreach ($this->clients as $client) {
            $client->send(json_encode($data));
        }
        $this->user->updateOnlineStatus($user_id, 1);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n"
            ,
            $from->resourceId,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );

        $data = json_decode($msg, true);

        if(isset($data['action']) && $data['action'] == "update_seen"){
            //$senderData = json_decode($this->user->returnOtherUser($data['senderId']), true);
            $receiverData = json_decode($this->user->returnOtherUser($data['receiverId']), true);

            if(isset($data['msgId'])){
                $this->messages->setStatus(1);
                $this->messages->setId($data['msgId']);
                $this->messages->updateMessageStatus();
            }
            
            foreach($this->clients as $client) {
                if ($client->resourceId == $receiverData['user_connection_id'] || $from == $client) {
                    $client->send(json_encode($data));
                }
            }
        }

        if (!empty($data['message'])) {
            $this->messages->setSenderId($data['userId']);
            $this->messages->setReceiverId($data['receiverId']);
            $this->messages->setMessage($data['message']);
            $this->messages->setSentDate(date("Y-m-d h:i:s"));
            $this->messages->setStatus(0);
            $chat_message_id = $this->messages->saveMessage();
            $data['msg_id'] = $chat_message_id;

            $senderData = json_decode($this->user->returnOtherUser($data['userId']), true);
            $receiverData = json_decode($this->user->returnOtherUser($data['receiverId']), true);

            $senderName = $senderData['name'];
            $receiverName = $receiverData['name'];
            $data['dt'] = date("d-m-Y h:i:s");

            foreach ($this->clients as $client) {
                // if ($from !== $client) {
                //     // The sender is not the receiver, send to each client connected
                //     $client->send($msg);
                // }

                if ($from == $client) {
                    $data['from'] = 'Me';
                } else {
                    $data['from'] = $senderName;
                }

                if ($client->resourceId == $receiverData['user_connection_id'] || $from == $client) {
                    $client->send(json_encode($data));
                } else {
                    $this->messages->setStatus(0);
                    $this->messages->setId($chat_message_id);
                    $this->messages->updateMessageStatus();
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {

        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $queryArray);

        $user_id = $this->user->getUserIdFromToken($queryArray['token']);
        $data['status_type'] = "Offline";
        $data['user_id_status'] = $user_id;

        foreach ($this->clients as $client) {
            $client->send(json_encode($data));
        }
        $this->user->updateOnlineStatus($user_id, 0);

        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}