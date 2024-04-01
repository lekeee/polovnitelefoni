<?php
include_once '../classes/Newsletter.php';
require_once "../config/config.php";

function subscribe($data, $newsletter)
{
    try {
        $newsletter->setEmail($data['email']);
        $result = $newsletter->subscribe();
        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'Drago nam je što ste ovde! Svakog meseca
                ćemo Vam dostaviti
                najnovije vesti, savete i posebne ponude koje su
                ekskluzivne samo za naše pretplatnike.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Već se nalazite u grupi naših pretplatnika.'
            ];
        }
    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'message' => 'Greška prilikom subscribe-vanja'
        ];
    }
    return $response;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['action'])) {
        $newsletter = new Newsletter();
        if ($data['action'] === 'subscribe') {
            $response = subscribe($data, $newsletter);
        }
    }
}
echo json_encode($response);