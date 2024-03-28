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
            $sql = "INSERT INTO newsletter (email)
                    VALUES (?)";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("s", $this->email);
            $stmt->execute();
            
            return $stmt->affected_rows > 0 ? true : false;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

}