<?php

class Newsletter{
    protected $con;
    private $id;
    private $email;
    private $creation_date;

    public function __construct($email){
        global $con;
        $this->con = $con;

        $this->email = $email;
    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getCreationDate(){
        return $this->creation_date;
    }
    public function setCreationDate($creation_date){
        $this->creation_date = $creation_date;
    }

    public function subscribe(){
        try{
            $checkSql = "SELECT COUNT(*) as count FROM newsletter WHERE email = ?";
            $checkStmt = $this->con->prepare($checkSql);
            $checkStmt->bind_param("s", $this->email);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
            $count = $checkResult->fetch_assoc()['count'];
            
            if($count > 0) {
                return false;
            }
            
            $insertSql = "INSERT INTO newsletter (email) VALUES (?)";
            $insertStmt = $this->con->prepare($insertSql);
            $insertStmt->bind_param("s", $this->email);
            $insertStmt->execute();
            
            return $insertStmt->affected_rows > 0 ? true : false;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }
}