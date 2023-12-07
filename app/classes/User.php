<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once(__DIR__ . '/../exceptions/userExceptions.php');


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
                
        	    if ($stmt->error) {
                    return false;
                }
                
                if ($result) {
                    $this->sendVerificationEmail($email);
                    return true;
                } else {
                    return false;
                }
            }else{
                return "Korisničko ime je zauzeto.";
            }
        }else{
            return "Već postoji nalog sa unetom email adresom.";
        }

        
    }

    private function getIdRegister($email){
        $sql = "SELECT user_id FROM users WHERE email = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $results = $stmt->get_result();

        if($results->num_rows == 1){
            $user = $results->fetch_assoc();
            return $user["user_id"];
        }

        return NULL;
    }
    
    public function login($emailOrUsername, $password){
        $sql = "SELECT user_id, password, verified FROM users WHERE email = ? OR username = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
        $stmt->execute();

        $results = $stmt->get_result();

        if($results->num_rows == 1){
            $user = $results->fetch_assoc();
            if($user["verified"] == 0){
                throw new ACCOUNT_NOT_VERIFIED();
            }
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
    public function getEmail($emailOrUsername){
        $sql = "SELECT email FROM users WHERE email = ? OR username = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
        $stmt->execute();

        $results = $stmt->get_result();

        if($results->num_rows == 1){
            $user = $results->fetch_assoc();
            return $user["email"];
        }

        return NULL;
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
    public function resetPassword($uid, $password){
        $sql = "UPDATE users SET 
        password = ? 
        WHERE user_id = ?";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("si", password_hash($password, PASSWORD_DEFAULT), $uid);
        
        $stmt->execute();
        $results = $stmt->affected_rows;

        return $results > 0 && $this->deleteResetPasswordCode($uid) > 0;
    }

    public function deleteResetPasswordCode($uid){
        $sql = "UPDATE verifikacioni_kodovi SET 
        changepw_code=NULL 
        WHERE user_id=?";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $uid);
        
        $stmt->execute();
        $results = $stmt->affected_rows;

        return $results > 0 ? true : false;
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

    public function generateChangePasswordCode($email){
        $length = 24; //duzina koda
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $code .= $characters[$index];
        }
        $this->updateChangePasswordCode($code, $email);
        return $code;
    }

    public function generateVerificationCode($email){
        $length = 24; //duzina koda
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $code .= $characters[$index];
        }
        if($this->checkVerificationUserExist($email)){
            $this->updateVerificationCode($code, $email);
        }else{
            $this->saveVerificationCode($code, $email);
        }
        return $code;
    }

    private function checkVerificationUserExist($email){
        $user_id = $this->getIdRegister($email);
        $sql = "SELECT * FROM verifikacioni_kodovi WHERE user_id=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows == 1;
    }

    public function saveVerificationCode($code, $email){
        $id_val = $this->getIdRegister($email);
        $sql = "INSERT INTO verifikacioni_kodovi (user_id, verification_code) 
                VALUES (?,?)";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("is", $id_val, $code);

        $stmt->execute();
        $results = $stmt->affected_rows;
        
        return $results > 0 ? true : false;
    }

    public function updateChangePasswordCode($code, $email){
        $id_val = $this->getIdRegister($email);

        $sql = "UPDATE verifikacioni_kodovi SET 
        changepw_code = ?
        WHERE user_id = ?";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("si", $code, $id_val);

        $stmt->execute();
        $results = $stmt->affected_rows;

        return $results > 0 ? true : false;
    }
    public function updateVerificationCode($code, $email){
        $id_val = $this->getIdRegister($email);

        $sql = "UPDATE verifikacioni_kodovi SET 
                verification_code = ?
                WHERE user_id = ?";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("si", $code, $id_val);

        $stmt->execute();
        $results = $stmt->affected_rows;
        return $results > 0 ? true : false;
    }

    public function verifyUser($user_id){
        $sql = "UPDATE users SET 
        verified = '1'
        WHERE user_id = ?";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $user_id);

        // Izvršavanje upita
        $stmt->execute();
        $results = $stmt->affected_rows;
        
        return isset($results);
    }

    public function sendVerificationEmail($email){
        require __DIR__ .  "/../../PHPMailer/src/Exception.php";
        require __DIR__ . "/../../PHPMailer/src/PHPMailer.php";
        require __DIR__ . "/../../PHPMailer/src/SMTP.php";

        try{
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = 'polovnitelefoni383@gmail.com';
            $mail->Password = 'oava ufgw rplr zhbq';
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;

            $mail->setFrom("polovnitelefoni383@gmail.com");
            $mail->addAddress($email);
            $mail->isHTML(true);

            $uid = $this->generateVerificationCode($email);


            $mail->Subject = "Verifikacija naloga";
            $mail->Body = 
            "
            <div style='font-family: Arial, sans-serif; color:000; width: 600px; background-color: #fff; padding: 10px 0px 20px 0px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>

                <div style='padding-top: 0; padding-bottom: 10px; text-align: center; display: block;'>
                    <img src='../public/src/polovnitelefoni.svg' alt=''>
                </div>

                <div style='display: flex; justify-content: center; align-items: center; background-color: #ED6969; height: 100px; margin: 0; padding: 0;'>
                    <img src='../public/src/mail-icon.png' alt='' style='width: 50px; height: 50px;'>
                </div>

                <div style='text-align: left; padding: 0px 20px 20px 20px;'>
                    <h1><b>Verifikacija emaila</b></h1>
                    <p>Hvala što koristite sajt polovnitelefoni.shop!</p>
                    <p>Potrebno nam je još malo informacija da bismo završili vašu registraciju, uključujući i potvrdu vaše e-mail adrese.</p>
                    <p>Kliknite na dugme ispod koje će vas odvesti na stranicu za verifikaciju.</p>

                    <p>Drago nam je što ste ovde!</p>
                    <p>Vaš Polovni Telefoni tim.</p>
                </div>

                <div style='text-align: center; padding: 20px;'>
                    <a href='http://localhost/polovnitelefoni/views/verification.php?uid=$uid' style='display: inline-block; padding: 15px 20px; color: #fff; background-color: #ed6969; text-decoration: none; border-radius: 5px; font-weight: bold; text-align: center; text-transform: uppercase; transition: background-color 0.3s ease;'>Stranica za verifikaciju</a>
                </div>

                <hr style='margin: 20px 0; border: 0; border-top: 2px solid #ccc;'>

                <div style='text-align: center; padding: 20px;'>
                    <img src='../public/src/icons-instagram.svg' alt=''>
                    <img src='../public/src/icons-facebook.svg' alt=''>
                </div>

                <footer style='background-color: rgb(33, 32, 32); padding: 20px; text-align: center;'>
                    <p style='color: white;'> © polovnitelefoni.shop, Inc. All rights reserved.</p>
                </footer>

            </div>
            
            "; //link TREBA DA SE PROMENI
            $mail->send();

            return true;
        }catch(Exception $e){
            echo $e;
            throw new EMAIL_NOT_SENDED();
        }
    }
    
    public function sendChangePasswordMail($email){
        require "../../PHPMailer/src/Exception.php";
        require "../../PHPMailer/src/PHPMailer.php";
        require "../../PHPMailer/src/SMTP.php";

        try{
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = 'polovnitelefoni383@gmail.com';
            $mail->Password = 'oava ufgw rplr zhbq';
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;

            $mail->setFrom("polovnitelefoni383@gmail.com");
            $mail->addAddress($email);
            $mail->isHTML(true);

            $uid = $this->generateChangePasswordCode($email);

            $mail->Subject = "Zahtev za promenu loznike";
            $mail->Body = 
            "
            <div style='font-family: Arial, sans-serif; color:000; width: 600px; background-color: #fff; padding: 10px 0px 20px 0px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>

                <div style='padding-top: 0; padding-bottom: 10px; text-align: center; display: block;'>
                    <img src='../public/src/polovnitelefoni.svg' alt=''>
                </div>

                <div style='display: flex; justify-content: center; align-items: center; background-color: #ED6969; height: 100px; margin: 0; padding: 0;'>
                    <img src='../public/src/mail-icon.png' alt='' style='width: 50px; height: 50px;'>
                </div>

                <div style='text-align: left; padding: 0px 20px 20px 20px;'>
                    <h1><b>Promena lozinke</b></h1>
                    <p>Problemi sa prijavljivanjem?</p>
                    <p>Resetovanje lozinke je jednostavno.</p>
                    <p>Samo pritisnite dugme ispod i pratite uputstva. Uskoro ćemo vas pokrenuti.</p>

                    <p>Ako niste uputili ovaj zahtev, zanemarite ovu e-poštu.</p>
                    <p>Vaš Polovni Telefoni tim.</p>
                </div>

                <div style='text-align: center; padding: 20px;'>
                    <a href='http://localhost/polovnitelefoni/views/resetPassword.php?uid=$uid' style='display: inline-block; padding: 15px 20px; color: #fff; background-color: #ed6969; text-decoration: none; border-radius: 5px; font-weight: bold; text-align: center; text-transform: uppercase; transition: background-color 0.3s ease;'>Stranica za promenu lozinke</a>
                </div>

                <hr style='margin: 20px 0; border: 0; border-top: 2px solid #ccc;'>

                <div style='text-align: center; padding: 20px;'>
                    <img src='../public/src/icons-instagram.svg' alt=''>
                    <img src='../public/src/icons-facebook.svg' alt=''>
                </div>

                <footer style='background-color: rgb(33, 32, 32); padding: 20px; text-align: center;'>
                    <p style='color: white;'> © polovnitelefoni.shop, Inc. All rights reserved.</p>
                </footer>

            </div>
            ";
            //i ovde se menja
            $mail->send();

            return true;
        }
        catch(Exception $e){
            throw new EMAIL_NOT_SENDED;
        }
    }

    function getIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // Provera za deljenje internet konekcije
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Provera za proxy servere
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}