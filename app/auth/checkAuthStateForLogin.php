<?php
    require_once "userAuthentification.php";
    if($user->isLogged()){
        header('Location: ../views/dashboard.php');
    }else{

    }
?>