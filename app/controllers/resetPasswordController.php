<?php
require_once "../classes/User.php";
require_once "../config/config.php";
require_once "../classes/Phone.php";
include_once '../exceptions/userExceptions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['action'])) {
        $user = new User();
        if ($data['action'] === 'resetPassword') {
            $user_id = $data['user_id'];
            $password = $data['newPassword'];
            try {
                $result = $user->resetPassword($user_id, $password);
                if ($result) {
                    $response = array(
                        'status' => 'success',
                        'message' => $result
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Došlo je do greške prilikom promene lozinke!'
                    );
                }
            } catch (Exception $e) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Došlo je do greške prilikom promene lozinke!'
                );
            }
        }
        if ($data['action'] === 'sendReset') {
            $emailOrUsername = $data['email'];
            try {
                $email = $user->getEmail($emailOrUsername);
                $result = $user->sendChangePasswordMail($email);
                $response = array(
                    'status' => 'success',
                    'message' => $result
                );
            } catch (EMAIL_NOT_SENDED $e) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Došlo je do greške prilikom slanja mail-a za resetovanje poruke, molimo pokušajte kasnije!'
                );
            }
        }
    }
}
echo json_encode($response);
?>