// <?php
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
//     80
// );
// $server->socketContext = stream_context_create([
//     'ssl' => [
//         'local_cert' => '/ssl/certs/polovni_telefoni_rs_b4b59_a2387_1716933709_083f0ab670ff5a8169bdd1424fb29ea7.crt',
//         'local_pk' => '/ssl/keys/b4b59_a2387_54abf26b019597734ff123ea1d2fdf22.key',
//         // Dodatne SSL opcije po potrebi
//     ]
// ]);
// $server->run();

// $server = IoServer::factory(
//     new HttpServer(
//         new WsServer(
//             new Chat($user, $messages)
//         )
//     ),
//     80, // Port 443 za HTTPS
//     '0.0.0.0', // Slušaj sve dostupne IP adrese
//     stream_context_create([
//         'ssl' => [
//             'local_cert' => '/ssl/certs/www_socket_polovni_telefoni_rs_bc925_3a359_1720381154_4306ad3f9ba75e9d5a03046f9fabca0c.crt',
//             'local_pk' => '/ssl/keys/bc925_3a359_6d3ceb2b1330a45f8ad294a214f447f0.key'
//             // Dodatne SSL opcije po potrebi
//         ]
//     ])
// );



<?php
session_abort();
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\Http\OriginCheck;
use Ratchet\WebSocket\WsSecureServer; // Promenjeno
use MyApp\Chat;

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . "/app/config/config.php";
require dirname(__DIR__) . "/app/auth/userAuthentification.php";
require dirname(__DIR__) . "/app/classes/Messages.php";

$messages = new Messages();

$server = IoServer::factory(
    new HttpServer(
        new OriginCheck(
            new WsSecureServer( // Promenjeno
                new Chat($user, $messages)
            )
        )
    ),
    443, // Promenjeno na port 443 za HTTPS
    '0.0.0.0', // Slušaj sve dostupne IP adrese
    stream_context_create([
        'ssl' => [
            'local_cert' => '/ssl/certs/www_socket_polovni_telefoni_rs_bc925_3a359_1720381154_4306ad3f9ba75e9d5a03046f9fabca0c.crt',
            'local_pk' => '/ssl/keys/bc925_3a359_6d3ceb2b1330a45f8ad294a214f447f0.key'
            // Dodatne SSL opcije po potrebi
        ]
    ])
);

$server->run();

