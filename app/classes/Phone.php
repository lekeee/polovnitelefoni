<?php
include_once(__DIR__ . '/Ad.php');
include_once(__DIR__ . '/../exceptions/adExceptions.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);


class Phone extends Ad{
    public $accessories;

    public function __construct($user_id = null, $brand = null, $model = null, $title = null, $state = null, $state_rate = null, $description = null, $images = null, $price = null, $new_price = null, $views = null, $availability = null, $damage = null, $accessories = null) {
        try{
            parent::__construct($user_id, $brand, $model, $title, $state, $state_rate, $description, $images, $price, $new_price, $views, $availability, $damage);

            $this->accessories = $accessories;
        }
        catch(Exception $e){
            throw new OBJECT_NOT_CREATED();
        }
    }

    public function create($user_id, $brand, $model, $title, $state, $state_rate, $description, $price, $new_price, $images, $availability, $damage, $accessories){
        try{
            $sql = "INSERT INTO oglasi (user_id, brand, model, title, state, state_rate, description, price, new_price, images, availability, damage, accessories)
                VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->con->prepare($sql);

            $stmt->bind_param("issssssssssss", $user_id, $brand, $model, $title, $state, $state_rate, $description, $price, $new_price, $images, $availability, $damage, $accessories);

            $result = $stmt->execute();
            $result = $stmt->affected_rows;
            
            return $result > 0 ? true : false;
        }
        catch (Exception $e){
            throw new AD_CANNOT_BE_CREATED();
        }
        
    }

    public function saveImages($images, $user_id){

        try{
            $folderName = uniqid($user_id."_"); // Generiše jedinstveno ime foldera za slike
            $uploadDirectory = "uploads/" . $folderName; // Putanja do foldera za smeštaj slika
            mkdir($uploadDirectory); // Kreira folder

            foreach ($images['tmp_name'] as $key => $tmp_name) {
                $originalFileName = basename($images['name'][$key]);
                $targetFile = $uploadDirectory . '/' . $originalFileName;
                
                move_uploaded_file($tmp_name, $targetFile);
            }
        }
        catch(Exception $e){
            throw new IMAGES_NOT_SAVED();
        }
        
    }

    public function select24($offset = 0, $limit = 24){
        try{
            $sql = "SELECT * FROM oglasi LIMIT $limit OFFSET $offset";
            $result = $this->con->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        catch(Exception $e){
            throw new ADS_NOT_SELECTED();
        }
    }

    public function select24UserAds($user_id, $offset = 0, $limit = 24){
        try{
            $sql = "SELECT * FROM oglasi WHERE user_id=? LIMIT $limit OFFSET $offset";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $ad_id);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }
        catch(Exception $e){
            throw new ADS_NOT_SELECTED();
        }
    }
    
    public function read($ad_id){
        try{
            $sql = "SELECT * FROM oglasi WHERE ad_id=?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $ad_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows === 1)
                return json_encode($result->fetch_assoc());
            return NULL;
        }
        catch(Exception $e){
            throw new AD_CANNOT_BE_READ();
        }
    }

    public function checkIsRated($user_id){
        try{
            $sql = "SELECT * FROM ocene WHERE rater_id=?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->num_rows == 0 ? false : true;
        }
        catch(Exception $e){
            throw new CHECK_RATE_ERROR();
        }
    }

    public function saveRate($user_id, $ad_id, $ocena){
        try{
            $sql = "INSERT INTO ocene (user_id, ad_id, ocena) 
            VALUES (?,?,?)";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("iii", $user_id, $ad_id, $ocena);

            $stmt->execute();
            $results = $stmt->affected_rows;
                
            return $results > 0 ? true : false;
        }
        catch(Exception $e){
            throw new SAVE_RATE_ERROR();
        }
        
    }

    public function updateRate($user_id, $ad_id, $ocena){
        try{
            $sql = "UPDATE ocene SET 
                ocena = ?
                WHERE user_id = ? AND ad_id=?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("iii", $ocena, $user_id, $ad_id);
            $stmt->execute();
            $results = $stmt->affected_rows;

            return $results > 0 ? true : false;
        }
        catch(Exception $e){
            throw new UPDATE_RATE_ERROR();
        }
    }

    public function rate($user_id, $ad_id, $ocena){
        try{
            if($this->checkIsRated($user_id)){
                return $this->updateRate($user_id, $ad_id, $ocena);
            }
            else{
                return $this->saveRate($user_id, $ad_id, $ocena);
            }
        }
        catch(Exception $e){
            throw new RATE_ERROR();
        }
    }

    public function averageRating($ad_id){
        try{
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
        catch(Exception $e){
            throw new AVERAGE_RATING_ERROR();
        }
    }

    public function checkVisit($ip, $ad_id){
        try{
            $sql = "SELECT * FROM visitors WHERE ip_address=? AND ad_id=?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("si", $ip, $ad_id);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->num_rows == 0 ? true : false;
        }
        catch(Exception $e){
            throw new CHECK_VISIT_ERROR();
        }
    }

    public function addVisit($ip, $ad_id){
        try{
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
        catch(Exception $e){
            throw new ADD_VISIT_ERROR();
        }
    }

    public function totalVisits($ad_id){
        try{
            $sql = "SELECT COUNT(*) as count FROM visitors WHERE ad_id=?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $ad_id); 
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            return $row['count'];
        }
        catch(Exception $e){
            throw new TOTAL_VISIT_ERROR();
        }
    }
}