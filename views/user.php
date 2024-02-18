<!DOCTYPE html>
<html data-wf-domain="polovni-telefoni.webflow.io" data-wf-page="655506e07faa7f82a5f25613"
    data-wf-site="655506e07faa7f82a5f25610">

<?php
require_once "../inc/headTag.php";
?>
<link href="../public/css/index.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link href="../public/css/user.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />

<body class="body">

    <?php
    require_once "../inc/header.php";
    require_once "../inc/bottomNavigator.php";
    require_once "../inc/mobileMenu.php";
    ?>

    <section class="mainpageselection">
        <div class="mainpagediv">
            <div class="user-image-short-container">
                <div class="user-image-container">
                    <img src="../public/src/userShow2.svg" alt="" srcset="">
                </div>
                <div class="user-short-container">
                    <div class="name-location">
                        <h3>Djordje Ivanovic</h3>
                        <img src="../public/src/location.svg?v=<?php echo time() ?>" alt="">
                        <p>Leskovac</p>
                    </div>
                    <div class="user-rates">
                        <p>Prosečna ocena</p>
                        <div class="rate-label">
                            <h5>3.9</h5><img src="../public/src/start-rating4.png" alt="" srcset="">
                        </div>
                    </div>
                    <div class="user-interactions">
                        <div class="user-btn">
                            <div class="user-send-message">
                                <img src="../public/src/message-icon2.svg" alt="">
                                <a href="#">Pošalji poruku</a>
                            </div>
                        </div>
                        <div class="user-btn">
                            <div class="user-send-message">
                                <img src="../public/src/report.svg" alt="">
                                <a href="#">Prijavi korisnika</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="user-image-short-container" style="margin-top: 10px">
                <div class="user-image-container stat-main-container">
                    <div class="stat-header">
                        <p>statistika</p>
                        <div class="text-separator-horizontal"></div>
                    </div>
                    <div class="stat-main">
                        <p>Dodati oglasi: <span>10</span></p>
                        <p>Aktivni oglasi: <span>3</span></p>
                        <p>Ukupno čuvanja oglasa: <span>234</span></p>
                        <div class="donut-chart-brands">
                            <h4>Učestalost brendova</h4>
                            <div class="donut-container">
                                <canvas id="donutCanvas" width="120" height="120"></canvas>
                                <div class="donut-info">
                                    <div class="donut-info-row">
                                        <div class="color-identificator" style="background-color: #4CAF50"></div>
                                        <p>Apple</p>
                                    </div>
                                    <div class="donut-info-row">
                                        <div class="color-identificator" style="background-color: #FFC107"></div>
                                        <p>Samsung</p>
                                    </div>
                                    <div class="donut-info-row">
                                        <div class="color-identificator" style="background-color: #00BCD4"></div>
                                        <p>Huawei</p>
                                    </div>
                                    <div class="donut-info-row">
                                        <div class="color-identificator" style="background-color: #E91E63"></div>
                                        <p>Xiaomi</p>
                                    </div>
                                    <div class="donut-info-row">
                                        <div class="color-identificator" style="background-color: #9E9E9E"></div>
                                        <p>LG</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr style="margin-top: 20px; color: #ddd">
                    </div>
                </div>
                <div class="user-short-container" style="padding-top: 0px">
                    <div class="navigation">
                        <div class="user-ads-info user-ads-ident">
                            <img src="../public/src/ads.svg?v=<?php echo time(); ?>">
                            <a href="#">Korisnikovi oglasi</a>
                        </div>
                        <div class="user-ads-info user-info-ident" style="margin-left: 20px;">
                            <img src="../public/src/user_icon.png">
                            <a href="#">Osnovni podaci</a>
                        </div>
                    </div>
                    <div class="click-identificator" style="margin-top: -1px;">
                    </div>
                    <div class="user-preview-container">
                        <div class="user-about-container">
                            <h3>Informacije o korisniku</h3>
                            <div class="about-info-row">
                                <p class="about-main">Korisničko ime: </p>
                                <a class="user-info">djordje.ivanovic</a>
                            </div>
                            <div class="about-info-row">
                                <p class="about-main">Broj telefona: </p><a href="tel:0637303883"
                                    class="user-phone">0637303883</a>
                            </div>
                            <div class="about-info-row">
                                <p class="about-main">Grad: </p><a href="https://www.google.com/maps/place/Leskovac"
                                    target="_blank" class="user-phone">Leskovac</a>
                            </div>
                            <div class="about-info-row">
                                <p class="about-main">Adresa: </p><a
                                    href="https://www.google.com/maps/place/Stara Zeleznicka Kolonija 5a"
                                    target="_blank" class="user-phone">Stara Zeleznicka Kolonija 5a</a>
                            </div>
                            <div class="about-info-row">
                                <p class="about-main">Email adresa: </p><a href="mailto:idjordje63@gmail.com"
                                    class="user-phone">idjordje63@gmail.com</a>
                            </div>
                            <div class="about-info-row">
                                <p class="about-main">Član od: </p>
                                <a class="user-info">25.11.2023</a>
                            </div>
                        </div>
                        <div class="user-about-container ads-main-container">
                            <div class="ads-container">
                                <?php
                                require_once('../inc/widget-list.php');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    require_once "../inc/subscribeForm.php";
    require_once "../inc/footer.php";
    ?>

    <body>
        <script src="../public/js/user-profile.js?v=<?php echo time(); ?>"></script>
        <script src="../public/js-public/rpie.js?v=<?php echo time(); ?>"></script>
        <script src="../public/js/donut.js?v=<?php echo time(); ?>"></script>

</html>