<?php
session_start();
$servername = "S34.UNLIMITED.RS";
$db_username = "polovtel_user";
$db_password = "9:76cQZ:arKnR4";
$database_name = "polovtel_mobileshop";

$con = mysqli_connect($servername, $db_username, $db_password, $database_name);

if(!$con){
    die("Neuspesna konekcija");
}

require_once __DIR__ .'/../../vendor/autoload.php';
 

$clientID = '33934885967-9cfe82jlrm1u3bqtciruhklre83s87d9.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'https://polovni-telefoni.rs/app/controllers/googleLoginController.php';

// Call Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");

$loginUrl = $client->createAuthUrl();

