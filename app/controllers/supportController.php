<?php
require_once "../classes/Support.php";
require_once "../config/config.php";
include_once '../exceptions/adExceptions.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['action'])) {
        $support = new Support();
        if ($data['action'] === 'saveSupportData') {
            $response = saveSupportData($data, $support);
        }
    }
}

echo json_encode($response);

function saveSupportData($data, $support)
{
    try {
        $support->setName($data['name']);
        $support->setLastname($data['lastname']);
        $support->setEmail($data['email']);
        $support->setProblem($data['problem']);
        $support->setDescription($data['description']);

        $result = $support->sendSupportMessage();
        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'Uspešno poslata poruka support-u'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Došlo je do greške prilikom slanja poruke support-u'
            ];
        }
    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'message' => 'Došlo je do greške prilikom slanja poruke support-u'
        ];
    }
    return $response;
}