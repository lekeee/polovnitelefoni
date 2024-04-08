<?php
session_abort();
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . "/app/config/config.php";
require dirname(__DIR__) . "/app/auth/userAuthentification.php";
require dirname(__DIR__) . "/app/classes/Messages.php";

$messages = new Messages();

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat($user, $messages)
        )
    ),
    80
);
$server->run();
