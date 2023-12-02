<?php
    require_once "../config/config.php"; //za brisanje
    require_once "../classes/User.php";
    $user = new User();
    require_once "../classes/Verification.php";
    $uid = $_GET["uid"];

    
    $ver = new Verification();
    $isCodeValid = json_decode($ver->findCode($uid));
    //var_dump($isCodeValid);

    if($isCodeValid){
        $user->verifyUser();
    }
    else{
        echo "Greska";
    }