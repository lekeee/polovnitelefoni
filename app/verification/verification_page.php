<?php
    require_once "../config/config.php"; //za brisanje
    require_once "../classes/User.php";
    $user = new User();
    require_once "../classes/Verification.php";
    $uid = $_GET["uid"];

    
    $ver = new Verification();
    $isCodeValid = $ver->findCode($uid);

    if($isCodeValid){
        $user->verifyUser($isCodeValid);
        echo "USPESNO VERIFIKOVANO";
    }
    else{
        echo "Greska";
    }