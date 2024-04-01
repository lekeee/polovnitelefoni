<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Support
{

    protected $con;
    private $id;
    private $name;
    private $lastname;
    private $email;
    private $description;
    private $problem;

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }
    public function getLastname()
    {
        return $this->lastname;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setProblem($problem)
    {
        $this->problem = $problem;
    }
    public function getProblem()
    {
        return $this->problem;
    }

    public function __construct($name = null, $lastname = null, $email = null, $problem = null, $description = null)
    {
        global $con;
        $this->con = $con;

        $this->name = $name;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->description = $description;
        $this->problem = $problem;
    }

    public function sendSupportMessage()
    {
        try{
            $sql = "INSERT INTO support (name, lastname, email, problem, description)
                    VALUES (?,?,?,?,?)";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("sssss", $this->name, $this->lastname, $this->email, $this->problem, $this->description);
            $stmt->execute();

            return $stmt->affected_rows > 0 ? true : false;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }
}