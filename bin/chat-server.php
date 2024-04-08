<?php
session_abort();
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;
echo "Pre require";
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . "/app/config/config.php";
require dirname(__DIR__) . "/app/auth/userAuthentification.php";
require dirname(__DIR__) . "/app/classes/Messages.php";
echo "Posle require";
$messages = new Messages();
echo "Posle messages";
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat($user, $messages)
        )
    ),
    9000
);
echo "Posle server";
$server->run();
echo "Posle startovanja";
