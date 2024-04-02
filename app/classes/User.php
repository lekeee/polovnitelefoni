<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "Verification.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once (__DIR__ . '/../exceptions/userExceptions.php');


class User
{
    protected $con;

    public function __construct()
    {
        try {
            global $con;
            $this->con = $con;
        } catch (Exception $e) {
            throw new OBJECT_USER_NOT_CREATED();
        }
    }

    public function isEmailTaken($email)
    {
        try {
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            return $stmt->num_rows > 0;
        } catch (Exception $e) {
            throw new IS_EMAIL_TAKEN_ERROR();
        }

    }

    private function isUsernameTaken($username)
    {
        try {
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            return $stmt->num_rows > 0;
        } catch (Exception $e) {
            throw new IS_USERNAME_TAKEN_ERROR();
        }
    }

    public function createPrimary($username, $email, $password)
    {
        try {
            if (!$this->isEmailTaken($email)) {
                if (!$this->isUsernameTaken($username)) {
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
                } else {
                    return "Korisničko ime je zauzeto.";
                }
            } else {
                return "Već postoji nalog sa unetom email adresom.";
            }
        } catch (Exception $e) {
            throw new CREATE_PRIMARY_ERROR();
        }
    }

    public function createGoogle($name, $lastname, $email, $oauth_provider, $oauth_uid = NULL)
    {
        try {
            $verified = 1;
            $sql = "INSERT INTO users (name, lastname, email, verified, oauth_uid, oauth_provider) VALUES (?,?,?,?,?,?)";
            $stmt = $this->con->prepare($sql);
            if (!$stmt) {
                // Dodajte ovde kod za rukovanje greškom u pripremi upita
                die('Greška prilikom pripreme upita: ' . $this->con->error);
            }
            $stmt->bind_param("sssiss", $name, $lastname, $email, $verified, $oauth_uid, $oauth_provider);
            $result = $stmt->execute();

            if (!$result) {
                throw new ERROR_FROM_QUERY();
            }
            return true;
        } catch (Exception $e) {
            throw new ACCOUNT_NOT_CREATED();
        }

    }

    public function setOauthUid($email, $oauth_uid)
    {
        try {
            $user_id = $this->getId();
            $sql = "UPDATE users SET 
            oauth_uid = ?,
            oauth_provider= ?
            WHERE email = ?";

            $oauth_provider = "google";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("sss", $oauth_uid, $oauth_provider, $email);

            $stmt->execute();
            $results = $stmt->affected_rows;

            return isset($results);
        } catch (Exception $e) {
            throw new SET_OAUTH_UID_ERROR();
        }
    }

    public function getIdRegister($email)
    {
        try {
            $sql = "SELECT user_id FROM users WHERE email = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $results = $stmt->get_result();

            if ($results->num_rows == 1) {
                $user = $results->fetch_assoc();
                return $user["user_id"];
            }
            return NULL;
        } catch (Exception $e) {
            throw new GET_ID_REGISTER_ERROR();
        }
    }

    public function login($emailOrUsername, $password)
    {
        try {
            $sql = "SELECT user_id, password, verified FROM users WHERE email = ? OR username = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
            $stmt->execute();

            $results = $stmt->get_result();

            if ($results->num_rows == 1) {
                $user = $results->fetch_assoc();
                if ($user["verified"] == 0) {
                    throw new ACCOUNT_NOT_VERIFIED();
                }
                if ($user['password'] != null && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $user_token = md5(uniqid());
                    $this->updateToken($user['user_id'], $user_token);
                    $this->updateLoginStatus($user['user_id'], 1);
                    return true;
                }
            }

            return false;
        } catch (Exception $e) {
            throw new LOGIN_ERROR();
        }

    }

    public function checkUserByOauthUid($oauth_uid)
    {
        try {
            $sql = "SELECT * FROM users WHERE oauth_uid=?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("s", $oauth_uid);
            $stmt->execute();
            $result = $stmt->get_result();

            $user = $result->fetch_assoc();

            return $user ? true : null;
        } catch (Exception $e) {
            throw new CHECK_USER_BY_OAUTH_UID_ERROR();
        }

    }

    public function returnOauthUid()
    {
        try {
            $user_id = $this->getId();
            $sql = "SELECT ouath_uid FROM users WHERE user_id=?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            $results = $stmt->get_result();

            if ($results->num_rows == 1) {
                $user = $results->fetch_assoc();
                return $user["oauth_uid"];
            } else
                return false;
        } catch (Exception $e) {
            throw new RETURN_OAUTH_UID_ERROR();
        }
    }

    public function returnUser()
    {
        try {
            $user_id = $this->getId();
            $sql = "SELECT * FROM users WHERE user_id=?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $user = $result->fetch_assoc();

            //ako kojim slucajem nema user vraca null
            return $user ? json_encode($user) : null;
        } catch (Exception $e) {
            throw new RETURN_USER_ERROR();
        }
    }
    public function getEmail($emailOrUsername)
    {
        try {
            $sql = "SELECT email FROM users WHERE email = ? OR username = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
            $stmt->execute();

            $results = $stmt->get_result();

            if ($results->num_rows == 1) {
                $user = $results->fetch_assoc();
                return $user["email"];
            }

            return NULL;
        } catch (Exception $e) {
            throw new GET_EMAIL_ERROR();
        }
    }
    public function updateUser($name, $lastname, $username, $oldPassword, $password, $phone, $city, $address)
    {
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
        if ($oldPassword) {
            $hashed_password = json_decode($userData, true)['password'];
            if (password_verify($oldPassword, $hashed_password)) {
                if ($password) {
                    if ($this->updatePassword($password)) {
                        return isset($results);
                    } else
                        return false;
                }
            } else
                throw new WRONG_PASSWORD();
        }

        if ($username !== json_decode($userData, true)['username'] && $this->isUsernameTaken($username)) {
            throw new USERNAME_TAKEN_EXCEPTION();
        }
        return $this->updateUsername($username) && isset($results);
    }

    private function updateUsername($username)
    {
        try {
            $user_id = $this->getId();
            $sql = "UPDATE users SET 
            username = ?
            WHERE user_id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("si", $username, $user_id);

            $stmt->execute();
            $results = $stmt->affected_rows;

            return isset($results);
        } catch (Exception $e) {
            throw new UPDATE_USERNAME_ERROR();
        }
    }
    public function resetPassword($uid, $password)
    {
        try {
            $sql = "UPDATE users SET 
            password = ? 
            WHERE user_id = ?";

            $stmt = $this->con->prepare($sql);
            $newPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("si", $newPassword, $uid);

            $stmt->execute();
            $results = $stmt->affected_rows;

            return $results > 0 && $this->deleteResetPasswordCode($uid);
        } catch (Exception $e) {
            throw new RESET_PASSWORD_ERROR();
        }
    }

    public function deleteResetPasswordCode($uid)
    {
        try {
            $sql = "UPDATE verifikacioni_kodovi SET 
            changepw_code=NULL 
            WHERE user_id=?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $uid);

            $stmt->execute();
            $results = $stmt->affected_rows;

            return $results > 0 ? true : false;
        } catch (Exception $e) {
            throw new DELETE_RESET_PW_CODE_ERROR();
        }
    }

    private function updatePassword($password)
    {
        try {
            $sql = "UPDATE users SET 
            password = ? 
            WHERE user_id = ?";

            $stmt = $this->con->prepare($sql);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $id = $this->getId();
            $stmt->bind_param("si", $hashedPassword, $id);

            $stmt->execute();
            $results = $stmt->affected_rows;

            return isset($results);
        } catch (Exception $e) {
            throw new UPDATE_PASSWORD_ERROR();
        }
    }

    public function isLogged()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }

    /*public function isLoggedWithGoogle(){
        if(isset($_SESSION['user_id']) && isset($_SESSION['token'])){
            return true;
        }
        return false;
    }*/

    public function logout()
    {
        if (isset($_SESSION['user_id']) && isset($_SESSION['token'])) {
            $this->updateLoginStatus($this->getId(), 0);
            unset($_SESSION['user_id']);
            unset($_SESSION['token']);
            //$client->revokeToken(); 
        } else if (isset($_SESSION['user_id'])) {
            $this->updateLoginStatus($this->getId(), 0);
            unset($_SESSION['user_id']);
        }

    }

    public function getId()
    {
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['user_id'];
        } else
            return false;
    }

    public function generateChangePasswordCode($email)
    {
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

    public function generateVerificationCode($email)
    {
        $length = 24; //duzina koda
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $code .= $characters[$index];
        }
        if ($this->checkVerificationUserExist($email)) {
            $this->updateVerificationCode($code, $email);
        } else {
            $this->saveVerificationCode($code, $email);
        }
        return $code;
    }

    private function checkVerificationUserExist($email)
    {
        try {
            $user_id = $this->getIdRegister($email);
            $sql = "SELECT * FROM verifikacioni_kodovi WHERE user_id=?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->num_rows == 1;
        } catch (Exception $e) {
            throw new CHECK_VERIFICATION_USER_EXIST();
        }

    }

    public function saveVerificationCode($code, $email)
    {
        try {
            $id_val = $this->getIdRegister($email);
            $sql = "INSERT INTO verifikacioni_kodovi (user_id, verification_code) 
                    VALUES (?,?)";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("is", $id_val, $code);

            $stmt->execute();
            $results = $stmt->affected_rows;

            return $results > 0 ? true : false;
        } catch (Exception $e) {
            throw new SAVE_VERIFICATION_CODE_ERROR();
        }
    }

    public function updateChangePasswordCode($code, $email)
    {
        try {
            $id_val = $this->getIdRegister($email);

            $sql = "UPDATE verifikacioni_kodovi SET 
            changepw_code = ?
            WHERE user_id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("si", $code, $id_val);

            $stmt->execute();
            $results = $stmt->affected_rows;

            return $results > 0 ? true : false;
        } catch (Exception $e) {
            throw new UPDATE_CHANGE_PW_CODE_ERROR();
        }
    }

    public function updateVerificationCode($code, $email)
    {
        try {
            $id_val = $this->getIdRegister($email);

            $sql = "UPDATE verifikacioni_kodovi SET 
                    verification_code = ?
                    WHERE user_id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("si", $code, $id_val);

            $stmt->execute();
            $results = $stmt->affected_rows;
            return $results > 0 ? true : false;
        } catch (Exception $e) {
            throw new UPDATE_VERIFICATION_CODE_ERROR();
        }
    }

    public function verifyUser($user_id)
    {
        try {
            $sql = "UPDATE users SET 
            verified = '1'
            WHERE user_id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $user_id);

            // Izvršavanje upita
            $stmt->execute();
            $results = $stmt->affected_rows;

            return isset($results);
        } catch (Exception $e) {
            throw new VERIFY_USER_ERROR();
        }
    }

    public function getUserDataFromId($user_id)
    {
        try {
            $sql = "SELECT name, lastname, username, email, phone, city, address, member_since FROM users WHERE user_id=?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $user = $result->fetch_assoc();

            //ako kojim slucajem nema user vraca null
            return $user ? json_encode($user) : null;
        } catch (Exception $e) {
            throw new GET_USER_DATA_FROM_ID_ERROR();
        }
    }

    public function sendVerificationEmail($email)
    {
        require __DIR__ . "/../../PHPMailer/src/Exception.php";
        require __DIR__ . "/../../PHPMailer/src/PHPMailer.php";
        require __DIR__ . "/../../PHPMailer/src/SMTP.php";

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "mail.polovni-telefoni.rs";
            $mail->SMTPAuth = true;
            $mail->Username = 'team@polovni-telefoni.rs';
            $mail->Password = 'i.l;n&iuy9Tg';
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;

            $mail->setFrom("team@polovni-telefoni.rs");
            $mail->addAddress($email);
            $mail->isHTML(true);

            $uid = $this->generateVerificationCode($email);


            $mail->Subject = "Verifikacija naloga";
            $mail->Body =
                "
            <div style='font-family: Arial, sans-serif; color:000; width: 600px; background-color: #fff; padding: 10px 0px 20px 0px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>

                <div style='padding-top: 0; padding-bottom: 10px; text-align: center; display: block;'>
                    <img src='https://polovni-telefoni.rs/public/src/polovnitelefoni.png' alt='' style='width: 50%; height:50%'>
                </div>

                <div style='padding: 20px; text-align: center; display: block; background-color: #ED6969; '>
                    <img src='https://polovni-telefoni.rs/public/src/mail-icon.png' alt='' style='width: 50px; height: 50px;'>
                </div>


                <div style='text-align: left; padding: 0px 20px 20px 20px;'>
                    <h1><b>Verifikacija emaila</b></h1>
                    <p>Hvala što koristite sajt <a href='https://www.polovni-telefoni.rs' style='text-decoration: none; color: #ed6969;'>polovni-telefoni.rs</a>!</p>
                    <p>Potrebno nam je još malo informacija da bismo završili vašu registraciju, uključujući i potvrdu vaše e-mail adrese.</p>
                    <p>Kliknite na dugme ispod koje će vas odvesti na stranicu za verifikaciju.</p>

                    <p>Drago nam je što ste ovde!</p>
                    <p>Vaš Polovni Telefoni tim.</p>
                </div>

                <div style='text-align: center; padding: 20px;'>
                    <a href='https://polovni-telefoni.rs/views/verification.php?uid=$uid' style='display: inline-block; padding: 15px 20px; color: #fff; background-color: #ed6969; text-decoration: none; border-radius: 5px; font-weight: bold; text-align: center; text-transform: uppercase; transition: background-color 0.3s ease;'>Stranica za verifikaciju</a>
                </div>

                <hr style='margin: 20px 0; border: 0; border-top: 2px solid #ccc;'>

                <div style='text-align: center; padding: 20px;'>
                    <img src='https://polovni-telefoni.rs/public/src/icons-instagram.png' alt='' style='width: 40px; height: 40px;'>
                    <img src='https://polovni-telefoni.rs/public/src/icons-facebook.png' alt='' style='width: 40px; height: 40px;'>
                </div>

                <footer style='background-color: rgb(33, 32, 32); padding: 20px; text-align: center;'>
                    <p style='color: white;'>© polovni-telefoni.rs, Inc. Sva prava su zadrzana.</p>
                </footer>

            </div>
            
            "; //link TREBA DA SE PROMENI
            $mail->send();

            return true;
        } catch (Exception $e) {
            echo $e;
            throw new EMAIL_NOT_SENDED();
        }
    }

    public function sendChangePasswordMail($email)
    {
        require "../../PHPMailer/src/Exception.php";
        require "../../PHPMailer/src/PHPMailer.php";
        require "../../PHPMailer/src/SMTP.php";

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "mail.polovni-telefoni.rs";
            $mail->SMTPAuth = true;
            $mail->Username = 'team@polovni-telefoni.rs';
            $mail->Password = 'i.l;n&iuy9Tg';
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;

            $mail->setFrom("team@polovni-telefoni.rs");
            $mail->addAddress($email);
            $mail->isHTML(true);

            $uid = $this->generateChangePasswordCode($email);

            $mail->Subject = "Zahtev za promenu loznike";
            $mail->Body =
                "
                <div style='font-family: Arial, sans-serif; color:000; width: 600px; background-color: #fff; padding: 10px 0px 20px 0px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>

                    <div style='padding-top: 0; padding-bottom: 10px; text-align: center; display: block;'>
                        <img src='https://polovni-telefoni.rs/public/src/polovnitelefoni.png' alt='' style='width: 50%; height:50%'>
                    </div>
            
                    <div style='padding: 20px; text-align: center; display: block; background-color: #ED6969; '>
                        <img src='https://polovni-telefoni.rs/public/src/mail-icon.png' alt='' style='width: 50px; height: 50px;'>
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
                        <a href='https://polovni-telefoni.rs/views/resetPassword.php?uid=$uid' style='display: inline-block; padding: 15px 20px; color: #fff; background-color: #ed6969; text-decoration: none; border-radius: 5px; font-weight: bold; text-align: center; text-transform: uppercase; transition: background-color 0.3s ease;'>Stranica za verifikaciju</a>
                    </div>
            
                    <hr style='margin: 20px 0; border: 0; border-top: 2px solid #ccc;'>
            
                    <div style='text-align: center; padding: 20px;'>
                        <img src='https://polovni-telefoni.rs/public/src/icons-instagram.png' alt='' style='width: 40px; height: 40px;'>
                        <img src='https://polovni-telefoni.rs/public/src/icons-facebook.png' alt='' style='width: 40px; height: 40px;'>
                    </div>
            
                    <footer style='background-color: rgb(33, 32, 32); padding: 20px; text-align: center;'>
                        <p style='color: white;'>© polovni-telefoni.rs, Inc. Sva prava su zadrzana.</p>
                    </footer>
            
                </div>
            ";
            //i ovde se menja
            $mail->send();

            return true;
        } catch (Exception $e) {
            throw new EMAIL_NOT_SENDED;
        }
    }

    function getIP()
    {
        try {
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
        } catch (Exception $e) {
            throw new GET_IP_ERROR();
        }
    }

    public function mySaves($offset = 0, $limit = 16)
    {
        try {
            $user_id = $this->getId();
            $sql = "SELECT * FROM sacuvani_oglasi INNER JOIN oglasi 
            ON sacuvani_oglasi.ad_id = oglasi.ad_id
            WHERE sacuvani_oglasi.user_id=? LIMIT $limit OFFSET $offset ";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return json_encode($result->fetch_all(MYSQLI_ASSOC));
            }
            return NULL;
        } catch (Exception $e) {
            throw new MY_SAVES_ERROR();
        }
    }

    public function deleteUser($username)
    {
        try {
            $user_id = $this->getId();
            $validUsername = $this->checkUsername($user_id, $username);
            if ($validUsername) {
                $ver = new Verification();
                if ($ver->deleteUserVerification($user_id) && $this->deleteUserAds()) {

                    $sql = "DELETE FROM users WHERE user_id = ?";

                    $stmt = $this->con->prepare($sql);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    if ($stmt->error) {
                        throw new Exception("SQL execution error: " . $stmt->error);
                    }
                    $results = $stmt->affected_rows;
                    if ($results > 0) {
                        //$this->logout();
                        return true;
                    } else
                        return false;
                }
            }
            return false;
        } catch (Exception $e) {
            throw new USER_CANNOT_BE_DELETED();
        }
    }

    public function deleteUserAds()
    {
        try {
            $user_id = $this->getId();
            $sql = "SELECT * FROM oglasi WHERE user_id = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $ad_id = $row['ad_id'];
                echo $ad_id;
                $ad = new Phone();
                $ad->deleteAd($ad_id);
            }
            return true;
        } catch (Exception $e) {
            throw new USER_ADS_CANNOT_BE_DELETED();
        }
    }

    private function checkUsername($user_id, $username)
    {
        try {
            $sql = "SELECT username FROM users WHERE user_id=?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $user = $result->fetch_assoc();
            return $user['username'] === $username;
        } catch (Exception $e) {
            throw new INCORECT_USERNAME();
        }
    }

    public function myAds($offset = 0, $limit = 24)
    {
        try {
            $user_id = $this->getId();
            $sql = "SELECT * FROM oglasi WHERE user_id=? LIMIT $limit OFFSET $offset";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return json_encode($result->fetch_all(MYSQLI_ASSOC));
            }
            return NULL;
        } catch (Exception $e) {
            throw new ADS_NOT_SELECTED();
        }
    }


    //! DODATO ZA PORUKE

    public function updateLoginStatus($id, $status)
    {
        try {
            // 0 logout 1 login
            $sql = "UPDATE users
                    SET login_status = ?
                    WHERE user_id = ?";
            $statement = $this->con->prepare($sql);
            $statement->bind_param("ii", $status, $id);
            $statement->execute();
            $result = $statement->affected_rows;
            if ($result == 1) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function returnOnlineStatus($user_id){
        try {
            $sql = "SELECT online_status FROM users
                    WHERE user_id = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function updateOnlineStatus($id, $status)
    {
        // 0 logout 1 login
        try {
            $sql = "UPDATE users
                SET online_status = ?
                WHERE user_id = ?";
            $statement = $this->con->prepare($sql);
            $statement->bind_param("ii", $status, $id);
            $statement->execute();
            $result = $statement->affected_rows;
            if ($result == 1) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    public function updateToken($id, $token)
    {
        try {
            $sql = "UPDATE users SET
                user_token = ?
                WHERE user_id = ?";
            $statement = $this->con->prepare($sql);
            $statement->bind_param("si", $token, $id);
            $statement->execute();
            $result = $statement->affected_rows;
            if ($result == 1) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getToken($id)
    {
        try {
            $sql = "SELECT user_token FROM users WHERE user_id = ?";
            $statement = $this->con->prepare($sql);
            $statement->bind_param("i", $id);
            $statement->execute();
            $result = $statement->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $token = $row['user_token'];
                return $token;
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getUserIdFromToken($token)
    {
        try {
            $sql = "SELECT user_id FROM users WHERE user_token = ?";
            $statement = $this->con->prepare($sql);
            $statement->bind_param("s", $token);
            $statement->execute();
            $result = $statement->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id = $row['user_id'];
                return $id;
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function updateUserConnectionId($token, $userConnectionId)
    {
        try {
            $sql = "UPDATE users SET
                user_connection_id = ?
                WHERE user_token = ?";
            $statement = $this->con->prepare($sql);
            $statement->bind_param("ss", $userConnectionId, $token);
            $statement->execute();
            $result = $statement->affected_rows;
            if ($result === TRUE) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function loginStatus($name)
    {
        try {
            $sql = "SELECT user_id FROM users WHERE name = ?";
            $statement = $this->con->prepare($sql);
            $statement->bind_param("s", $name);
            $statement->execute();
            $result = $statement->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $idKorisnika = $row['user_id'];
                return $idKorisnika;
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function returnOtherUser($id)
    {
        try {
            $sql = "SELECT * FROM users WHERE user_id=?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            $user = $result->fetch_assoc();

            return $user ? json_encode($user) : null;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function reportUser($userId, $reportedId, $msg)
    {
        try {
            $sql = "INSERT INTO prijave (user_id, reported_id, report_msg)
                VALUES(?,?,?)";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("iis", $userId, $reportedId, $msg);
            $stmt->execute();
            $results = $stmt->affected_rows;

            return $results > 0 ? true : false;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function addRate($user_id, $rated_id, $type)
    {
        try {
            $check_sql = "SELECT COUNT(*) as count FROM ocene_user WHERE user_id = ? AND rated_id = ?";
            $check_stmt = $this->con->prepare($check_sql);
            $check_stmt->bind_param("ii", $user_id, $rated_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $row = $check_result->fetch_assoc();
            $count = $row['count'];

            $this->con->begin_transaction();

            if ($count > 0) {
                $update_sql = "UPDATE ocene_user SET tip = ? WHERE user_id = ? AND rated_id = ?";
                $update_stmt = $this->con->prepare($update_sql);
                $update_stmt->bind_param("iii", $type, $user_id, $rated_id);
                $update_stmt->execute();
                $rows_affected = $update_stmt->affected_rows;
            } else {
                $insert_sql = "INSERT INTO ocene_user (user_id, rated_id, tip) VALUES (?, ?, ?)";
                $insert_stmt = $this->con->prepare($insert_sql);
                $insert_stmt->bind_param("iii", $user_id, $rated_id, $type);
                $insert_stmt->execute();
                $rows_affected = $insert_stmt->affected_rows;
            }

            $this->con->commit();

            $success = $rows_affected > 0;

            return $success;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function isRated($user_id, $rated_id)
    {
        try {
            $sql = "SELECT * FROM ocene_user 
                WHERE user_id = ? AND rated_id = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("ii", $user_id, $rated_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function returnRates($rated_id)
    {
        try {
            $sql = "SELECT
                    (SELECT count(*) FROM `ocene_user` WHERE rated_id = ? AND tip = 1) AS broj_pozitivnih, 
                    (SELECT count(*) FROM `ocene_user` WHERE rated_id = ? AND tip = 0) AS broj_negativnih; ";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("ii", $rated_id, $rated_id);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
            return null;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function returnEmail($user_id){
        try{
            $sql = "SELECT email FROM users WHERE user_id = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            $results = $stmt->get_result();

            if ($results->num_rows == 1) {
                $user = $results->fetch_assoc();
                return $user["email"];
            }

            return NULL;
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function sendNotificationEmail($user_id){
        require_once __DIR__ . '/../../PHPMailer/src/Exception.php';
        require_once __DIR__ . '/../../PHPMailer/src/PHPMailer.php';
        require_once __DIR__ . '/../../PHPMailer/src/SMTP.php';


        try {
            $email = $this->returnEmail($user_id);

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "mail.polovni-telefoni.rs";
            $mail->SMTPAuth = true;
            $mail->Username = 'team@polovni-telefoni.rs';
            $mail->Password = 'i.l;n&iuy9Tg';
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;

            $mail->setFrom("team@polovni-telefoni.rs");
            $mail->addAddress($email);
            $mail->isHTML(true);

            $mail->Subject = "Pristigle su nove poruke";
            $mail->Body =
                "
                <div style='font-family: Arial, sans-serif; color:000; width: 600px; background-color: #fff; padding: 10px 0px 20px 0px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>

                    <div style='padding-top: 0; padding-bottom: 10px; text-align: center; display: block;'>
                        <img src='https://polovni-telefoni.rs/public/src/polovnitelefoni.png' alt='' style='width: 50%; height:50%'>
                    </div>

                    <div style='padding: 20px; text-align: center; display: block; background-color: #ED6969; '>
                        <img src='https://polovni-telefoni.rs/public/src/mail-icon.png' alt='' style='width: 50px; height: 50px;'>
                    </div>

                    <div style='text-align: left; padding: 0px 20px 20px 20px; color:000'>
                        <h1><b>Nove poruke na Polovni Telefoni!</b></h1>
                        <p>Imate nove poruke koje čekaju na vašem nalogu na polovni-telefoni.rs </p>
                        
                        <p>Da biste pročitali svoje poruke, molimo vas da se prijavite na svoj nalog i posetite svoj inbox.<p>
                        <div style='display:flex; justify-content: center; align-items: center; padding: 20px;'>
                            <a href='https://polovni-telefoni.rs/views/messages.php' style='display: inline-block; padding: 15px 20px; color: #fff; background-color: #ed6969; text-decoration: none; border-radius: 5px; font-weight: bold; text-align: center; text-transform: uppercase; transition: background-color 0.3s ease;'>
                            Proveri inbox &#9993;
                            </a>
                        </div>
                        <p>Ako imate bilo kakvih pitanja ili problema, slobodno nas kontaktirajte.<p>

                        <p>Drago nam je što ste ovde!</p>
                        <p>Vaš Polovni Telefoni tim.</p>
                    </div>

                    <hr style='margin: 20px 0; border: 0; border-top: 2px solid #ccc;'>

                    <div style='text-align: center; padding: 20px;'>
                        <img src='https://polovni-telefoni.rs/public/src/icons-instagram.png' alt='' style='width: 40px; height: 40px;'>
                        <img src='https://polovni-telefoni.rs/public/src/icons-facebook.png' alt='' style='width: 40px; height: 40px;'>
                    </div>

                    <footer style='background-color: rgb(33, 32, 32); padding: 20px; text-align: center;'>
                        <p style='color: white;'>© polovni-telefoni.rs, Inc. Sva prava su zadrzana.</p>
                    </footer>

                </div>
            ";
            $mail->send();

            return true;
        }
        catch (Exception $e) {  
            echo $e->getMessage();
        }
    }
}