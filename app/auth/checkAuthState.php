<?php
    require_once "userAuthentification.php";
    if($user->isLogged()){
        //echo "Korisnik je logovan";
    }else{
        header('Location: ../views/index.php');
    }
?>