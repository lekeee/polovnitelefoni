<?php

include_once '../exceptions/userExceptions.php';

class User{

    protected $con;

    public function __construct(){
        global $con;
        $this->con = $con;
    }

    private function isEmailTaken($email){
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    private function isUsernameTaken($username){
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function createPrimary($username, $email, $password){

        if(!$this->isEmailTaken($email)){
            if(!$this->isUsernameTaken($username)){
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
                $sql = "INSERT INTO users (username, email, password) VALUES (?,?,?)";
                $stmt = $this->con->prepare($sql);
        
                $stmt->bind_param("sss", $username, $email, $hashed_password);
        
                $result = $stmt->execute();
        
                if($result){
                    // $_SESSION['user_id'] = $result->insert_id;
                    return true;
                }
                else{
                    return false;
                }
            }else{
                return "Korisničko ime je zauzeto.";
            }
        }else{
            return "Već postoji nalog sa unetom email adresom.";
        }

        
    }

    /* ne koristi se
    public function create($name, $lastname, $username, $email, $password, $phone, $city, $address){
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (name, lastname, username, email, password, phone, city, address) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->con->prepare($sql);

        $stmt->bind_param("ssssssss", $name, $lastname, $username, $email, $hashed_password, $phone, $city, $address);

        $result = $stmt->execute();

        if($result){
            $_SESSION['user_id'] = $result->insert_id;
            return true;
        }
        else{
            return false;
        }
    }*/

    public function login($emailOrUsername, $password){
        $sql = "SELECT user_id, password FROM users WHERE email = ? OR username = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
        $stmt->execute();

        $results = $stmt->get_result();

        if($results->num_rows == 1){
            $user = $results->fetch_assoc();

            if(password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['user_id'];
                return true;
            }
        }

        return false;
    }

    public function returnUser(){ 
        $user_id = $this->getId();
        $sql = "SELECT * FROM users WHERE user_id=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $user = $result->fetch_assoc();
        
        //ako kojim slucajem nema user vraca null
        return $user ? json_encode($user) : null;
    }

    public function updateUser($name, $lastname, $username, $oldPassword, $password, $phone, $city, $address){
        $user_id = $this->getId();
        $sql = "UPDATE users SET 
        name = ?, 
        lastname = ?, 
        phone = ?, 
        city = ?, 
        address = ? 
        WHERE user_id = ?";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("sssssi", $name, $lastname, $phone, $city, $address, $user_id);

        // Izvršavanje upita
        $stmt->execute();
        $results = $stmt->affected_rows;
        
        $userData = $this->returnUser();
        if($oldPassword){
            $hashed_password = json_decode($userData, true)['password'];
            if(password_verify($oldPassword, $hashed_password)){
                if($password){
                    if($this->updatePassword($password)){
                        return isset($results);
                    }
                    else
                        return false;
                }
            }else
                throw new WRONG_PASSWORD();
        }

        if($username !== json_decode($userData, true)['username'] && $this->isUsernameTaken($username)){
            throw new USERNAME_TAKEN_EXCEPTION();
            return 'USRNAME_TAKEN';
        }
        return $this->updateUsername($username) && isset($results);
    }

    private function updateUsername($username){
        $sql = "UPDATE users SET 
        username = ?
        WHERE user_id = ?";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("si", $username, $this->getId());

        $stmt->execute();
        $results = $stmt->affected_rows;

        return isset($results);
    }

    private function updatePassword($password) {
        $sql = "UPDATE users SET 
        password = ? 
        WHERE user_id = ?";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("si", password_hash($password, PASSWORD_DEFAULT), $this->getId());
        
        $stmt->execute();
        $results = $stmt->affected_rows;

        return isset($results);
    }

    public function isLogged(){
        if(isset($_SESSION['user_id'])){
            return true;
        }
        return false;
    }

    public function logout(){
        unset($_SESSION['user_id']);
    }

    public function getId(){
        if(isset($_SESSION['user_id'])){
            return $_SESSION['user_id'];
        }
        else return false;
    }
}