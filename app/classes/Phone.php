<?php
include_once(__DIR__ . '/Ad.php');

class Phone extends Ad{
    public $accessories;

    public function __construct($user_id = null, $brand = null, $model = null, $title = null, $state = null, $description = null, $images = null, $price = null, $new_price = null, $views = null, $availability = null, $damage = null, $accessories = null) {
        
        parent::__construct($user_id, $brand, $model, $title, $state, $description, $images, $price, $new_price, $views, $availability, $damage);

        $this->accessories = $accessories;
    }

    public function create($user_id, $brand, $model, $title, $state, $description, $price, $new_price, $images, $availability, $damage, $accessories){

        $sql = "INSERT INTO oglasi (user_id, brand, model, title, state, description, price, new_price, images, availability, damage, accessories)
                VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->con->prepare($sql);

        $stmt->bind_param("isssssssssss", $user_id, $brand, $model, $title, $state, $description, $price, $new_price, $images, $availability, $damage, $accessories);

        $result = $stmt->execute();
        $result = $stmt->affected_rows;
        
        return $result > 0 ? true : false;
    }

    public function select24($offset = 0, $limit = 24){
        $sql = "SELECT * FROM oglasi LIMIT $limit OFFSET $offset";
        $result = $this->con->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function read($user_id){
        $sql = "SELECT * FROM oglasi WHERE ad_id=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function rating(){
        //logika za ocenu
    }
}