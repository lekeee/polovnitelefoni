<?php
include_once(__DIR__ . '/../exceptions/verificationExceptions.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
class Verification
{
    protected $con;

    public function __construct()
    {
        global $con;
        $this->con = $con;
    }

    public function findCode($code)
    {
        try {

        } catch (Exception $e) {
            throw new FIND_CODE_ERROR();
        }
        $sql = "SELECT user_id FROM verifikacioni_kodovi WHERE verification_code=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $results = $stmt->get_result();
        $user = $results->fetch_assoc();

        if ($user) {
            $user_id = $user['user_id'];
            return $user_id;
        } else {
            return null;
        }
    }

    public function findPasswordCode($code)
    {
        try {
            $sql = "SELECT user_id FROM verifikacioni_kodovi WHERE changepw_code=?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("s", $code);
            $stmt->execute();
            $results = $stmt->get_result();
            $user = $results->fetch_assoc();

            if ($user) {
                $user_id = $user['user_id'];
                return $user_id;
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw new FIND_PW_CODE_ERROR();
        }
    }

    public function deleteUserVerification($user_id)
    {
        try {
            $sql = "DELETE FROM verifikacioni_kodovi WHERE user_id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            if ($stmt->error) {
                throw new Exception("SQL execution error: " . $stmt->error);
            }
            $results = $stmt->affected_rows;

            return true;
        } catch (Exception $e) {
            throw new VERIFICATION_CANNOT_BE_DELETED();
        }
    }
}