<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Newsletter
{
    protected $con;
    private $id;
    private $email;
    private $creation_date;

    public function __construct($email = NULL)
    {
        global $con;
        $this->con = $con;

        $this->email = $email;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getCreationDate()
    {
        return $this->creation_date;
    }
    public function setCreationDate($creation_date)
    {
        $this->creation_date = $creation_date;
    }

    public function subscribe()
    {
        try {
            $checkSql = "SELECT COUNT(*) as count FROM newsletter WHERE email = ?";
            $checkStmt = $this->con->prepare($checkSql);
            $checkStmt->bind_param("s", $this->email);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
            $count = $checkResult->fetch_assoc()['count'];

            if ($count > 0) {
                return false;
            }

            $insertSql = "INSERT INTO newsletter (email) VALUES (?)";
            $insertStmt = $this->con->prepare($insertSql);
            $insertStmt->bind_param("s", $this->email);
            $insertStmt->execute();

            if($insertStmt->affected_rows > 0 ){
                return $this->sendEmailToSubscriber();
            }
            else{
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function sendEmailToSubscriber(){
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
            $mail->addAddress($this->email);
            $mail->isHTML(true);

            $mail->Subject = "Dobrodoslica novom pretplatniku";
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
                        <h1><b>Dobrodošli u naš Newsletter!</b></h1>
                        <p>Hvala Vam što ste deo polovni-telefoni.rs zajednice!</p>
                        <p>Hvala Vam što ste se prijavili za naš newsletter!<p>
                        <p>Veoma smo uzbuđeni što ćemo sa vama deliti najnovije vesti, savete i ekskluzivne ponude sa našeg web sajta.</p>

                        <p>Evo šta možete očekivati od našeg newslettera:</p>
                        <ul>
                            <li>Redovne vesti i ažuriranja o našim proizvodima / uslugama</li>
                            <li>Korisne savete i trikove</li>
                            <li>Ekskluzivne ponude i popuste dostupne samo našim pretplatnicima</li>
                        </ul>

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
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}