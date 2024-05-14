<?php
require_once "userAuthentification.php";
if ($user->isLogged()) {
    $userData = json_decode($user->returnUser(), true);
} else {
    header('Location: ../views/login.php');
}