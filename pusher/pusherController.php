<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once dirname(__DIR__) . "/app/config/config.php";
require_once dirname(__DIR__) . "/app/classes/Messages.php";
require_once dirname(__DIR__) . "/app/classes/User.php";
require dirname(__DIR__) . '/vendor/autoload.php';

$options = array(
    'cluster' => 'eu',
    'useTLS' => true
  );
  $pusher = new Pusher\Pusher(
    '3d990468bac14b8556de',
    '41e1503a516b5db1c9b7',
    '1802701',
    $options
  );

  $messages = new Messages();
  $user = new User();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = json_decode(file_get_contents('php://input'), true);
    if(isset($data['action'])){
        if($data['action'] == 'sendmessage'){
            if(!empty($data['message'])){
                $messages->setSenderId($data['user_id']);
                $messages->setReceiverId($data['receiver_id']);
                $messages->setMessage($data['message']);
                $messages->setSentDate(date("Y-m-d h:i:s"));
                $messages->setStatus(0);
                $chat_message_id = $messages->saveMessage();
                $data['msg_id'] = $chat_message_id;

                $senderData = json_decode($user->returnOtherUser($data['user_id']), true);
                $receiverData = json_decode($user->returnOtherUser($data['receiver_id']), true);

                $senderName = $senderData['name'];
                $receiverName = $receiverData['name'];
                $data['dt'] = date("d-m-Y h:i:s");
                $data['from'] = 'Me';
                
                [$id1, $id2] = compareIds($data['user_id'], $data['receiver_id']);
                $pusher->trigger('channel-'.$id1.$id2, 'sendmessage', $data);
                
                if($receiverData['login_status'] == 1 && $receiverData['online_status'] == 1){
                    $notifyData['user_id'] = $data['receiver_id'];
                    $notifyData['from_user'] = $data['user_id'];
                    $pusher->trigger('channel-notification', 'notifyuser', $notifyData);
                }
                else{
                    $user->sendNotificationEmail($data['receiver_id']);
                }

                $response = array(
                    'status' => 'success',
                    'message' => 'Uspesno poslata poruka'
                );
                echo json_encode($response);
            }
            
        }
        if ($data["action"] == "fetch_chat") {
            $messages->setSenderId($data['receiverId']);
            $messages->setReceiverId($data['userId']);
            $messages->setStatus(1);
            $numberChanged = $messages->changeChatStatus();

            $response = [
                "messages" => $messages->getMessages(),
                "numberChanged" => $numberChanged
            ];
        
            echo json_encode($response);
        }
        if($data['action'] == "update_seen"){
            if(isset($data['msg_id'])){
                $messages->setStatus(1);
                $messages->setId($data['msg_id']);
                $messages->updateMessageStatus();
            }
            $pusher->trigger('channel-notification', 'updateseen', $data);
            $response = array(
                'status' => 'success',
                'message' => 'Poslato update seen'
            );
            echo json_encode($response);
        }
        if($data['action'] == "status" && isset($_SESSION['user_id'])){
            if($data['status'] == 'online'){
                $user->updateOnlineStatus($_SESSION['user_id'], 1);
            }
            if($data['status'] == 'offline'){
                $user->updateOnlineStatus($_SESSION['user_id'], 0);
            }
            $response = array(
                'status' => 'success',
                'message' => 'Poslat update status'
            );
            echo json_encode($response);
        }
        else{
            $response = array(
                'status' => 'error',
                'message' => 'Korisnik nije ulogovan'
            );
            echo json_encode($response);
        }
    }
}

function compareIds($id1, $id2) {
    if (intval($id1) > intval($id2)) {
        $temp = $id1;
        $id1 = $id2;
        $id2 = $temp;
    }
    return [$id1, $id2];
}
