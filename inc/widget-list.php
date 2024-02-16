<?php

include_once("../app/classes/Phone.php");
require_once "../app/config/config.php";
include_once("../app/classes/User.php");

//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// $data = json_decode(file_get_contents('php://input'), true);
// $ads = $data['ads'];
// $adsConverted = json_decode($ads, true);
// echo showListWidget($adsConverted);
//}
for ($i = 0; $i < 5; $i++) {
    echo showListWidget();
}

function showListWidget()
{
    $result = "";
    ob_start();
    ?>
    <div class="user-widget">
        <img src="../public/src/appleiphone11_4.jpg" alt="" class="widget-image">
        <div class="widget-info-container">
            <a href="">Na prodaju iphone 11 pro max</a>
            <div class="stars-and-rate">
                <img src="../public/src/start-rating3.png" style="width: 100px">
                <p>7/10</p>
            </div>
            <div class="old-and-new-price">
                <p class="old-price">€879</p>
                <p class="new-price">€567</p>
            </div>
            <div class="description">
                <p>Na prodaju Apple iPhone 11 Pro Max. Uredjaj je kao nov, koriscen je svega
                    dva me... </p>
            </div>
        </div>
        <div class="action-container">
            <div class="action-compare-container">
                <div class="content-container">
                    <img src="../public/src/compare-icon.svg" alt="">
                </div>
            </div>
            <div class="action-compare-container">
                <div class="content-container">
                    <img src="../public/src/love-icon.svg" alt="">
                </div>
            </div>
        </div>
    </div>
    <?php
    $result .= ob_get_clean();
    return $result;
}

?>