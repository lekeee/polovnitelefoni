<?php

class User{

    protected $con;

    public function __construct(){
        global $con;
        $this->con = $con;
    }

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
    }

    public function login($email, $password){
        $sql = "SELECT user_id, password FROM users WHERE email = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $email);
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
        return $_SESSION['user_id'];
    }
}