<?php
require '../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

$client = new Client();
$body = '{
    "route": "device-detail",
    "key": "apple_iphone_13_pro_max-11089"
}';
$request = new Request('POST', 'https://script.google.com/macros/s/AKfycbxNu27V2Y2LuKUIQMK8lX1y0joB6YmG6hUwB1fNeVbgzEh22TcDGrOak03Fk3uBHmz-/exec', [], $body);
$res = $client->sendAsync($request)->wait();
echo $res->getBody();
?>