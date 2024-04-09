<?php
session_abort();
// use Ratchet\Server\IoServer;
// use Ratchet\Http\HttpServer;
// use Ratchet\WebSocket\WsServer;
// use MyApp\Chat;

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . "/app/config/config.php";
require dirname(__DIR__) . "/app/auth/userAuthentification.php";
require dirname(__DIR__) . "/app/classes/Messages.php";

use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\Proxy;
use MyApp\Chat;

$messages = new Messages();


$server = new Proxy('0.0.0.0', 443); // Postavite adresu i port proksija prema vašim potrebama

$server->route('/wss2', new Chat($user, $messages));

$server->run();

// $server = IoServer::factory(
//     new HttpServer(
//         new WsServer(
//             new Chat($user, $messages)
//         )
//     ),
//     443
// );

// $server->run();



