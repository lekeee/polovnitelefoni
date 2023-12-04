<?php

class Verification{
    protected $con;

    public function __construct(){
        global $con;
        $this->con = $con;
    }

    public function findCode($code){
        $sql = "SELECT user_id FROM verifikacioni_kodovi WHERE verification_code=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $results = $stmt->get_result();
        $user = $results->fetch_assoc();
        
        if ($user) {
            $user_id = $user['user_id'];
            return $user_id;
        } else {
            return null;
        }
    }

    public function findPasswordCode($code){
        $sql = "SELECT user_id FROM verifikacioni_kodovi WHERE changepw_code=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $results = $stmt->get_result();
        $user = $results->fetch_assoc();
        
        if ($user) {
            $user_id = $user['user_id'];
            return $user_id;
        } else {
            return null;
        }
    }    
}