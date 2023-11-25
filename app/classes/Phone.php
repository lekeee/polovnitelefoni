<?php

class Phone{
    protected $con;

    public function __construct(){
        global $con;
        $this->con = $con;
    }

    public function create($user_id, $brand, $model, $title, $state, $description, $price, $images){

        $sql = "INSERT INTO oglasi (user_id, brand, model, title, state, description, price, images)
                VALUES(?,?,?,?,?,?,?,?)";
        $stmt = $this->con->prepare($sql);

        $stmt->bind_param("ssssssss", $user_id, $brand, $model, $title, $state, $description, $price, $images);

        $result = $stmt->execute();

        if($result){
            return true;
        }
        else{
            return false;
        }
    }

    public function selectAll(){
        $sql = "SELECT * FROM oglasi";
        $result = $this->con->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function read($user_id){
        $sql = "SELECT * FROM oglasi WHERE ad_id=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}