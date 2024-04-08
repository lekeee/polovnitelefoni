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
    443
);
$server->socketContext = stream_context_create([
    'ssl' => [
        'local_cert' => '/ssl/certs/polovni_telefoni_rs_b4b59_a2387_1716933709_083f0ab670ff5a8169bdd1424fb29ea7.crt',
        'local_pk' => '/ssl/keys/af196_82b39_0afff1aaa1bd2b52167b45c318447661.key',
        // Dodatne SSL opcije po potrebi
    ]
]);
$server->run();
