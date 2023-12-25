<?php
include_once(__DIR__ . '/Ad.php');
include_once(__DIR__ . '/../exceptions/adExceptions.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);


class Phone extends Ad{
    public $accessories;

    public function __construct($user_id = null, $brand = null, $model = null, $title = null, $state = null, $stateRange = null ,$description = null, $images = null, $price = null, $new_price = null, $views = null, $availability = null, $damage = null, $accessories = null) {
        
        parent::__construct($user_id, $brand, $model, $title, $state, $stateRange ,$description, $images, $price, $new_price, $views, $availability, $damage);

        $this->accessories = $accessories;
    }

    public function create($user_id, $brand, $model, $title, $state, $stateRange ,$description, $price, $images, $availability, $damage, $accessories){
        try{
            $sql = "INSERT INTO oglasi (user_id, brand, model, title, state, stateRange, description, price, images, availability, damage, accessories)
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->con->prepare($sql);
                if (!$stmt) {
                die('Error in SQL query: ' . $this->con->error);
            }
            $imageFolder = $this->createImageFolder($user_id);
            $isVerified = 1;
            $stmt->bind_param("isssssssssss", $user_id, $brand, $model, $title, $state, $stateRange ,$description, $price, $imageFolder, $isVerified, $damage, $accessories);

            $result = $stmt->execute();
            $result = $stmt->affected_rows;

            $imagesUploaded = $this->saveImages($imageFolder, $images, $user_id);
            
            return $imagesUploaded && ($result > 0 ? true : false);
        }catch(Exception $e){
            throw new AD_CANNOT_BE_CREATED();
        }
    }

    public function createImageFolder($user_id){
        $folderName = uniqid($user_id."_");
        $uploadDirectory = $folderName;
        mkdir($uploadDirectory, 0777, true);
        return $uploadDirectory;
    }
    

    public function saveImages($uploadDirectory, $imageSrcArray, $user_id){
        try{
            $brojac = 0;
            foreach ($imageSrcArray as $key => $imageSrc) {
                $base64String = $imageSrc;
                list($type, $data) = explode(';', $base64String);
                list(, $data) = explode(',', $data);
    
                $imageData = base64_decode($data);
                if($brojac === 0){
                    $imageName = 'main-image.png';
                }else{
                    $imageName = uniqid('image_' . $brojac . '_') . '.png';
                }
                $targetFile = $uploadDirectory . '/' . $imageName;
                file_put_contents($targetFile, $imageData);
                $brojac++;
            }
            return true;
        } catch (Exception $e) {
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
    public function countSaves($ad_id){
        try{
            $sql = "SELECT COUNT(*) as count FROM sacuvani_oglasi WHERE ad_id = ?";
    
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $ad_id);
    
            $stmt->execute();
            $result = $stmt->get_result();
    
            if($row = $result->fetch_assoc()) {
                return $row['count'];
            }
            return 0;
        }
        catch(Exception $e){
            throw new COUNT_SAVES_ERROR();
        }
    }public function save($user_id, $ad_id){
        try{
            $sql = "INSERT INTO sacuvani_oglasi (user_id, ad_id) 
            VALUES (?,?)";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("ii", $user_id, $ad_id);

            $stmt->execute();
            if ($stmt->error) {
                throw new Exception("SQL execution error: " . $stmt->error);
            }
            $results = $stmt->affected_rows;
                
            return $results > 0 ? true : false;
        }
        catch(Exception $e){
            throw new ADD_CANNOT_BE_SAVED();
        }
    }

    public function deleteSave($user_id, $ad_id){
        try{
            $sql = "DELETE FROM sacuvani_oglasi WHERE user_id = ? AND ad_id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("ii", $user_id, $ad_id);

            $stmt->execute();
            if ($stmt->error) {
                throw new Exception("SQL execution error: " . $stmt->error);
            }
            $results = $stmt->affected_rows;
                
            return $results > 0 ? true : false;
        }
        catch(Exception $e){
            throw new SAVE_CANNOT_BE_DELETED();
        }
    }
    
}
