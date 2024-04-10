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

$loop = React\EventLoop\Factory::create();
$webSock = new React\Socket\Server('0.0.0.0:443', $loop);
$webSock = new React\Socket\SecureServer($webSock, $loop, [
    'local_cert'        => 'home/polovtel/public_html/ssl/certs/polovni_telefoni_rs_b4b59_a2387_1716933709_083f0ab670ff5a8169bdd1424fb29ea7.crt', // path to your cert
    'local_pk'          => 'home/polovtel/public_html/ssl/keys/b4b59_a2387_54abf26b019597734ff123ea1d2fdf22.key', // path to your server private key
    'allow_self_signed' => TRUE, // Allow self signed certs (should be false in production)
    'verify_peer' => FALSE
]);

$server = new Ratchet\Server\IoServer(
    new Ratchet\Http\HttpServer(
        new Ratchet\WebSocket\WsServer(
            new Chat($user, $messages)
        )
    ),
    $webSock
);

$server->run();


// session_abort();
// use Ratchet\Server\IoServer;
// use Ratchet\Http\HttpServer;
// use Ratchet\WebSocket\WsServer;
// use MyApp\Chat;

// require dirname(__DIR__) . '/vendor/autoload.php';
// require dirname(__DIR__) . "/app/config/config.php";
// require dirname(__DIR__) . "/app/auth/userAuthentification.php";
// require dirname(__DIR__) . "/app/classes/Messages.php";

// $loop = React\EventLoop\Factory::create();

// $messages = new Messages();

// $server = new React\Socket\TcpServer(443);
// $server = new React\Socket\SecureServer($server, null, array(
//     'local_cert' => 'home/polovtel/public_html/ssl/certs/polovni_telefoni_rs_b4b59_a2387_1716933709_083f0ab670ff5a8169bdd1424fb29ea7.crt',
//     'local_pk' => 'home/polovtel/public_html/ssl/keys/b4b59_a2387_54abf26b019597734ff123ea1d2fdf22.key'
// ));
// $webServer = new HttpServer(
//     new WsServer(
//         new Chat($user, $messages)
//     )
// );
// $server = new IoServer($webServer, $server, $loop);
// $server->run(); 
