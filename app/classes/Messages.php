<?php
class Messages
{
    private $id;
    private $sender_id;
    private $receiver_id;
    private $message;
    private $status;
    private $sent_at;
    protected $con;

    public function __construct()
    {
        global $con;
        $this->con = $con;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setSenderId($sender_id)
    {
        $this->sender_id = $sender_id;
    }

    public function getSenderId()
    {
        return $this->sender_id;
    }

    public function setReceiverId($receiver_id)
    {
        $this->receiver_id = $receiver_id;
    }

    public function getReceiverId()
    {
        return $this->receiver_id;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setSentDate($sent_at)
    {
        $this->sent_at = $sent_at;
    }

    public function getSentDate()
    {
        return $this->sent_at;
    }

    public function saveMessage()
    {
        try{
            $query = "INSERT INTO messages (sender_id, receiver_id, msg, status, sent_at) 
                  VALUES(?,?,?,?,?)";
            $statement = $this->con->prepare($query);
            $statement->bind_param("iisis", $this->sender_id, $this->receiver_id, $this->message, $this->status, $this->sent_at);
            $statement->execute();

            return $this->con->insert_id;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function getMessages()
    {
        try{
            $query = "SELECT a.name as senderName, b.name as receiverName, msg, sent_at,
            status, sender_id, receiver_id
            FROM messages
            INNER JOIN users a
                ON messages.sender_id = a.user_id
            INNER JOIN users b
                ON messages.receiver_id = b.user_id
            WHERE(messages.sender_id = ? AND messages.receiver_id = ?)
            OR(messages.sender_id = ? AND messages.receiver_id = ?)";

            $statement = $this->con->prepare($query);
            $statement->bind_param("iiii", $this->sender_id, $this->receiver_id, $this->receiver_id, $this->sender_id);
            $statement->execute();

            $result = $statement->get_result();
            $messages = $result->fetch_all(MYSQLI_ASSOC);

            return $messages;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function updateMessageStatus()
    {
        try{
            $query = "UPDATE messages 
                    SET status = ?
                    WHERE id = ?";
            $statement = $this->con->prepare($query);
            $statement->bind_param("ii", $this->status, $this->id);
            $statement->execute();
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function changeChatStatus()
    {
        try{
            $query = "UPDATE messages 
                    SET status = 1
                    WHERE sender_id = ?
                    AND receiver_id = ?
                    AND status = 0";
            $statement = $this->con->prepare($query);
            $statement->bind_param("ii", $this->sender_id, $this->receiver_id);
            $statement->execute();
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function getUnreadMessages($id)
    {
        try{
        $query = "SELECT COUNT(*) as count_unread, sender_id FROM `messages` WHERE receiver_id = ? AND status = 0 GROUP BY sender_id";
        $statement = $this->con->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();

        $result = $statement->get_result();
        $ids = $result->fetch_all(MYSQLI_ASSOC);

        return $ids;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function selectUsersWithMessages($id)
    {
        try{
            $sql = "SELECT DISTINCT u.* FROM users u 
                    INNER JOIN messages m 
                    ON u.user_id = m.sender_id OR u.user_id = m.receiver_id 
                    WHERE u.user_id <> ? AND (m.sender_id = ? OR m.receiver_id = ?)";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("iii", $id, $id, $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return $result->fetch_all();
            }
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function returnLastMessage()
    {
        try{
            $query = "SELECT * FROM `messages` WHERE receiver_id = ? OR sender_id = ? ORDER BY sent_at DESC LIMIT 1";
            $statement = $this->con->prepare($query);
            $statement->bind_param("ii", $this->sender_id, $this->sender_id);
            $statement->execute();

            $result = $statement->get_result();
            $message = $result->fetch_all(MYSQLI_ASSOC);

            return $message;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }
}