<?php
    require_once "userAuthentification.php";
    if($user->isLogged()){
        $userData = json_decode($user->returnUser(), true);
        //print_r($userData);
    }else{
        header('Location: ../views/index.php');
    }
?>