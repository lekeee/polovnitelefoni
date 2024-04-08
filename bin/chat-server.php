<?php
// session_abort();
// use Ratchet\Server\IoServer;
// use Ratchet\Http\HttpServer;
// use Ratchet\WebSocket\WsServer;
// use MyApp\Chat;

// require dirname(__DIR__) . '/vendor/autoload.php';
// require dirname(__DIR__) . "/app/config/config.php";
// require dirname(__DIR__) . "/app/auth/userAuthentification.php";
// require dirname(__DIR__) . "/app/classes/Messages.php";

// $messages = new Messages();

// $server = IoServer::factory(
//     new HttpServer(
//         new WsServer(
//             new Chat($user, $messages)
//         )
//     ),
//     443
// );
// $server->socketContext = stream_context_create([
//     'ssl' => [
//         'local_cert' => '/ssl/certs/polovni_telefoni_rs_b4b59_a2387_1716933709_083f0ab670ff5a8169bdd1424fb29ea7.crt',
//         'local_pk' => '/ssl/keys/b4b59_a2387_54abf26b019597734ff123ea1d2fdf22.key',
//         // Dodatne SSL opcije po potrebi
//     ]
// ]);
// $server->run();

use React\EventLoop\Factory;
use React\Socket\Server;
use React\Socket\SecureServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . "/app/config/config.php";
require dirname(__DIR__) . "/app/auth/userAuthentification.php";
require dirname(__DIR__) . "/app/classes/Messages.php";

$messages = new Messages();
$loop = Factory::create();

$webSocketServer = new WsServer(new Chat($user, $messages));
$webSocketServer->disableVersion(0);

$httpServer = new HttpServer($webSocketServer);

$socket = new Server($loop);
$socket->listen(443, '0.0.0.0');

$secureSocket = new SecureServer($socket, $loop, [
    'local_cert' =>  '/ssl/certs/polovni_telefoni_rs_b4b59_a2387_1716933709_083f0ab670ff5a8169bdd1424fb29ea7.crt', // Putanja do SSL sertifikata
    'local_pk' => '/ssl/keys/b4b59_a2387_54abf26b019597734ff123ea1d2fdf22.key', // Putanja do privatnog ključa
    'allow_self_signed' => true, // Dozvoli samo-potpisane sertifikate (za testiranje)
    'verify_peer' => false, // Ne proveravaj validnost SSL sertifikata klijenta (za testiranje)
]);

$httpServer->listen($secureSocket);

$loop->run();
