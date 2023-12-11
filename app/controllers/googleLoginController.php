<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../config/config.php";
require_once "../classes/User.php";
$user = new User();

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']); 
    $token = $client->getAccessToken(); 
    $_SESSION['token'] = $token;
}else{
    header('Location: ../../views/index.php');
    exit();
}

if(isset($_SESSION['token']) && isset($_SESSION['user_id'])){ 
    $client->setAccessToken($_SESSION['token']);
} 

$oAuth = new Google_Service_Oauth2($client);
$userData = $oAuth->userinfo->get(); 

if($user->checkUserByOauthId($userData['id']) === null){
    $user->createGoogle($userData['givenName'], $userData['familyName'], $userData['email'], "google",  $userData['id']);
    $_SESSION['user_id'] = $user->getIdRegister($userData['email']);
    header('Location: ../../views/index.php');
}else{
    $_SESSION['user_id'] = $user->getIdRegister($userData['email']);
    header('Location: ../../views/index.php');
    exit();
}