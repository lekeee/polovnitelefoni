<?php
include_once(__DIR__ . '/Ad.php');
include_once(__DIR__ . '/../exceptions/adExceptions.php');


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

    public function saveImages($images, $user_id){
        $folderName = uniqid($user_id."_"); // Generiše jedinstveno ime foldera za slike
        $uploadDirectory = "uploads/" . $folderName; // Putanja do foldera za smeštaj slika
        mkdir($uploadDirectory); // Kreira folder

        foreach ($images['tmp_name'] as $key => $tmp_name) {
            $originalFileName = basename($images['name'][$key]);
            $targetFile = $uploadDirectory . '/' . $originalFileName;
            
            move_uploaded_file($tmp_name, $targetFile);
        }
    }

    public function select24($offset = 0, $limit = 24){
        $sql = "SELECT * FROM oglasi LIMIT $limit OFFSET $offset";
        $result = $this->con->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function select24UserAds($user_id, $offset = 0, $limit = 24){
        $sql = "SELECT * FROM oglasi WHERE user_id=? LIMIT $limit OFFSET $offset";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $ad_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function read($ad_id){
        try{
            $sql = "SELECT * FROM oglasi WHERE ad_id=?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $ad_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows == 0)
                return $result->fetch_assoc();
            return false;
        }
        catch(Exception $e){
            throw new AD_CANNOT_BE_READ();
        }
    }

    public function checkIsRated($user_id){
        $sql = "SELECT * FROM ocene WHERE rater_id=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows == 0 ? false : true;
    }

    public function saveRate($user_id, $ad_id, $ocena){
        $sql = "INSERT INTO ocene (user_id, ad_id, ocena) 
                VALUES (?,?,?)";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("iii", $user_id, $ad_id, $ocena);

            $stmt->execute();
            $results = $stmt->affected_rows;
            
        return $results > 0 ? true : false;
    }

    public function updateRate($user_id, $ad_id, $ocena){
        $sql = "UPDATE ocene SET 
                ocena = ?
                WHERE user_id = ? AND ad_id=?";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("iii", $ocnea, $user_id, $ad_id);
        $stmt->execute();
        $results = $stmt->affected_rows;

        return $results > 0 ? true : false;
    }

    public function rate($user_id, $ad_id, $ocena){
        if($this->checkIsRated($user_id)){
            return $this->updateRate($user_id, $ad_id, $ocena);
        }
        else{
            return $this->saveRate($user_id, $ad_id, $ocena);
        }
    }

    public function averageRating($ad_id){
        $sql = "SELECT ocena FROM ocene WHERE ad_id=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $ad_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $totalRating = 0;
        $numberOfRatings = 0;
    
        while ($row = $result->fetch_assoc()) {
            $totalRating += $row['ocena'];
            $numberOfRatings++;
        }

        if ($numberOfRatings > 0) {
            $averageRating = $totalRating / $numberOfRatings;
            return $averageRating;
        } else {
            return 0;
        }
    }

    public function checkVisit($ip, $ad_id){
        $sql = "SELECT * FROM visitors WHERE ip_address=? AND ad_id=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("si", $ip, $ad_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows == 0 ? true : false;
    }

    public function addVisit($ip, $ad_id){
        if($this->checkVisit($ip, $ad_id)){
            $sql = "INSERT INTO visitors (ip_address, ad_id) 
                VALUES (?,?)";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("si", $ip, $ad_id);

            $stmt->execute();
            $results = $stmt->affected_rows;
            
            return $results > 0 ? true : false;
        }
        return false;
    }

    public function totalVisits($ad_id){
        $sql = "SELECT COUNT(*) as count FROM visitors WHERE ad_id=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $ad_id); 
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['count'];
    }
}