<?php
require_once "../app/auth/userAuthentification.php";
if (isset($_GET['id'])) {
    $userID = $_GET['id'];
    $myId = $user->getId();
    if ($userID == $myId) {
        header('Location: dashboard.php');
        exit;
    }
} else {
    if (isset($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        header('Location: index.php');
    }
    exit;
}
?>

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

    $profileData = json_decode($user->getUserDataFromId($userID), true);
    ?>
    <link href="../public/css/loading-animation.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <section class="mainpageselection">
        <div class="mainpagediv">
            <div class="user-image-short-container">
                <div class="user-image-container">
                    <img src="../public/src/userShow2.svg" alt="" srcset="">
                    <div class="user-rates">
                        <div class="rate-label">
                            <!-- <h5>3.9</h5><img src="../public/src/start-rating4.png" alt="" srcset=""> -->
                            <div class="positive-negative-container">
                                <!-- <img src="../public/src/happy-emoji.svg" alt="Pozitivne ocene"> -->
                                <svg class="positive-emoji" width="35" height="35" viewBox="0 0 24 24" role="img"
                                    aria-labelledby="happyFaceIconTitle" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M7.3010863,14.0011479 C8.0734404,15.7578367 9.98813711,17 11.9995889,17
                                        C14.0024928,17 15.913479,15.7546194 16.6925307,14.0055328" />
                                    <line stroke-linecap="round" stroke="red" x1="9" y1="9" x2="9" y2="9" />
                                    <line stroke-linecap="round" x1="15" y1="9" x2="15" y2="9" />
                                    <circle cx="12" cy="12" r="10" />
                                </svg>

                                <p id="positive-rates">0</p>
                            </div>
                            <div class="positive-negative-container" style="margin-left: 10px">
                                <svg class="negative-emoji" width="37" height="37" viewBox="0 0 24 24" fill="none">
                                    <g clip-path="url(#clip0_443_3604)">
                                        <circle cx="12" cy="12" r="9" stroke="red" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <circle cx="9.5" cy="9.5" r="1.5" fill="red" />
                                        <circle cx="14.5" cy="9.5" r="1.5" fill="red" />
                                        <path
                                            d="M7.53803 15.6064C8.79314 14.5681 10.3711 14 12 14C13.6289 14 15.2069 14.5681 16.462 15.6064"
                                            stroke="red" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </g>
                                </svg>

                                <p id="negative-rates">0</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="user-short-container">
                    <div class="name-location">
                        <h3>
                            <?php
                            if ($profileData['name'] != null && $profileData['lastname'] != null) {
                                echo $profileData['name'] . ' ' . $profileData['lastname'];
                            } else {
                                echo $profileData['username'];
                            }
                            ?>
                        </h3>
                        <div class="loc-img-p">
                            <img src="../public/src/location.svg?v=<?php echo time() ?>" alt="">
                            <p>
                                <?php
                                if ($profileData['city'] != null) {
                                    echo $profileData['city'];
                                } else {
                                    echo 'Nepoznata lokacija';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="user-interactions">
                        <div class="user-btn">
                            <div class="user-send-message">
                                <svg viewBox="0 0 32 32" width="23" height="23" style="margin-right: 5px">
                                    <defs>
                                        <style>
                                            .cls-1 {
                                                fill: none;
                                            }
                                        </style>
                                    </defs>
                                    <title />
                                    <g data-name="Layer 2" id="Layer_2">
                                        <path fill="white"
                                            d="M4,28a.84.84,0,0,1-.38-.08A1,1,0,0,1,3,27V8.78A4.89,4.89,0,0,1,8,4H24a4.89,4.89,0,0,1,5,4.78v9.44A4.89,4.89,0,0,1,24,23H9.41l-4.7,4.71A1,1,0,0,1,4,28ZM8,6A2.9,2.9,0,0,0,5,8.78V24.59l3.29-3.3A1,1,0,0,1,9,21H24a2.9,2.9,0,0,0,3-2.78V8.78A2.9,2.9,0,0,0,24,6Z" />
                                        <circle fill="white" cx="16" cy="13.5" r="2" />
                                        <circle fill="white" cx="21.5" cy="13.5" r="2" />
                                        <circle fill="white" cx="10.5" cy="13.5" r="2" />
                                    </g>
                                    <g id="frame">
                                        <rect class="cls-1" height="32" width="32" />
                                    </g>
                                </svg>
                                <a href="../views/messages.php?id=<?php echo $userID ?>">Pošalji
                                    poruku</a>
                            </div>
                        </div>
                        <div class="user-btn">
                            <div class="user-send-message report">
                                <svg height="100%" id="svg2793" width="23" height="23" style="margin-right: 5px;"
                                    style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;"
                                    version="1.1" viewBox="0 0 512 512" fill="#ed6969" xml:space="preserve">
                                    <defs id="defs2797" />
                                    <g id="_31-Attention" style="display:inline" transform="translate(0,-6144)">
                                        <g id="g2100" transform="translate(256,6174)">
                                            <path
                                                d="M 0,452 C -124.617,452 -226,350.617 -226,226 -226,101.383 -124.617,0 0,0 124.617,0 226,101.383 226,226 226,350.617 124.617,452 0,452 M 0,-30 c -141.159,0 -256,114.841 -256,256 0,141.159 114.841,256 256,256 C 141.159,482 256,367.159 256,226 256,84.841 141.159,-30 0,-30"
                                                id="path2098" style="fill-rule:nonzero" />
                                        </g>
                                        <g id="g2104" transform="translate(289.539,6376.21)">
                                            <path
                                                d="m 0,-102.97 v 0.001 L -8.336,12.599 c -0.949,13.15 -12.019,23.451 -25.203,23.451 -13.184,0 -24.254,-10.3 -25.203,-23.45 l -8.337,-115.568 c -0.669,-9.286 2.581,-18.515 8.923,-25.326 6.34,-6.817 15.313,-10.726 24.617,-10.726 9.304,0 18.277,3.909 24.622,10.732 6.337,6.805 9.587,16.034 8.917,25.318 m -33.54,-66.05 c -17.608,0 -34.587,7.397 -46.578,20.288 -11.995,12.885 -18.149,30.351 -16.883,47.921 l 8.337,115.57 c 2.074,28.761 26.288,51.291 55.125,51.291 28.835,0 53.049,-22.53 55.125,-51.291 l 8.336,-115.57 v 0.001 c 1.268,-17.57 -4.885,-35.037 -16.878,-47.916 -11.995,-12.897 -28.975,-20.294 -46.584,-20.294"
                                                id="path2102" style="fill-rule:nonzero" />
                                        </g>
                                        <g id="g2108" transform="translate(277.474,6519.64)">
                                            <path
                                                d="m 0,21.69 c 0,11.839 -9.634,21.47 -21.475,21.47 -11.841,0 -21.474,-9.631 -21.474,-21.47 V 0 c 0,-11.839 9.634,-21.47 21.475,-21.47 C -9.633,-21.47 0,-11.839 0,0 Z m -21.475,-73.16 c -28.383,0 -51.474,23.089 -51.474,51.47 v 21.69 c 0,28.381 23.092,51.47 51.475,51.47 C 6.909,73.16 30,50.071 30,21.69 V 0 C 30,-28.381 6.908,-51.47 -21.475,-51.47"
                                                id="path2106" style="fill-rule:nonzero" />
                                        </g>
                                    </g>
                                </svg>
                                <a href="#" onclick="showReportUser(<?php echo $user->isLogged() ?>)">Prijavi
                                    korisnika</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="user-image-short-container" style="margin-top: 10px">
                <div class="user-image-container stat-main-container">
                    <div class="stat-header" style="margin-top: 20px">
                        <p>statistika</p>
                        <div class="text-separator-horizontal"></div>
                    </div>
                    <div class="stat-main">
                        <p>Dodati oglasi: <span id="addedAds">10</span></p>
                        <p>Aktivni oglasi: <span id="activeAds">3</span></p>
                        <p>Ukupno čuvanja oglasa: <span>234</span></p>
                        <div class="donut-chart-brands" style="border-bottom: none">
                            <h4>Učestalost brendova</h4>
                            <div class="donut-container">
                                <canvas id="donutCanvas" width="120" height="120"></canvas>
                                <div class="donut-info">

                                </div>
                            </div>
                        </div>
                        <!-- <hr style="margin-top: 20px; color: #ddd"> -->
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
                            <div class="user-about-container-temp" style="width: 50%; height: 1px"></div>
                            <div class="user-about-main-container">
                                <h3>Informacije o korisniku</h3>
                                <div class="about-info-row">
                                    <p class="about-main">Korisničko ime: </p>
                                    <a class="user-info">
                                        <?php
                                        if ($profileData['username'] != null) {
                                            echo $profileData['username'];
                                        } else {
                                            echo 'Nepoznato korisničko ime';
                                        }
                                        ?>
                                    </a>
                                </div>
                                <div class="about-info-row">
                                    <p class="about-main">Broj telefona: </p>
                                    <a <?php
                                    if ($profileData['phone'] != null) {
                                        echo 'href="tel:' . $profileData['phone'] . '"';
                                        echo 'class="user-phone"';
                                    } else {
                                        echo 'href="#"';
                                        echo 'class="user-info"';
                                    }
                                    ?> class="user-phone">
                                        <?php
                                        if ($profileData['phone'] != null) {
                                            echo $profileData['phone'];
                                        } else {
                                            echo 'Nepoznat broj telefona';
                                        }
                                        ?>
                                    </a>
                                </div>
                                <div class="about-info-row">
                                    <p class="about-main">
                                        Grad:
                                    </p>
                                    <a <?php
                                    if ($profileData['city'] != null) {
                                        echo 'href="https://www.google.com/maps/place/' . $profileData['city'] . '"';
                                        echo 'class="user-phone"';
                                    } else {
                                        echo 'href="#"';
                                        echo 'class="user-info"';
                                    }
                                    ?>target="_blank" class="user-phone">
                                        <?php
                                        if ($profileData['city'] != null) {
                                            echo $profileData['city'];
                                        } else {
                                            echo 'Nepoznat grad';
                                        }
                                        ?>
                                    </a>
                                </div>
                                <div class="about-info-row">
                                    <p class="about-main">Adresa: </p><a <?php
                                    if ($profileData['address'] != null) {
                                        echo 'href="https://www.google.com/maps/place/' . $profileData['address'] . '"';
                                        echo 'class="user-phone"';
                                    } else {
                                        echo 'href="#"';
                                        echo 'class="user-info"';
                                    }
                                    ?>target="_blank" class="user-phone">
                                        <?php
                                        if ($profileData['address'] != null) {
                                            echo $profileData['address'];
                                        } else {
                                            echo 'Nepoznata adresa';
                                        }
                                        ?>
                                    </a>
                                </div>
                                <div class="about-info-row">
                                    <p class="about-main">Email adresa: </p>
                                    <a href="" class="user-info">
                                        <?php
                                        if ($profileData['email'] != null) {
                                            echo $profileData['email'];
                                        } else {
                                            echo 'Nepoznata email adresa';
                                        }
                                        ?>
                                    </a>
                                </div>
                                <div class="about-info-row">
                                    <p class="about-main">Član od: </p>
                                    <a class="user-info">
                                        <?php
                                        if ($profileData['member_since'] != null) {
                                            $date = new DateTime($profileData['member_since']);
                                            $formattedDate = $date->format('d.m.Y');
                                            echo $formattedDate;
                                        } else {
                                            echo 'Nepoznat datum učlanjivanja';
                                        }
                                        ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="user-about-container ads-main-container">
                            <div class="ads-container-temp" style="width: 100%; height: 1px"></div>
                            <div class="ads-container">
                                <div class="loading-container">
                                    <?php
                                    include_once("../inc/loadingWidgetList.php");
                                    ?>
                                </div>
                                <div class="not-found-container">
                                    <img src="../public/src/not-found.svg" alt="Nema rezultata">
                                    <p>Korisnik nema ni jedan aktivni oglas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="report-backgound-container">
        <div class="report-main-container">
            <div class="image-report-container">
                <img src="../public/src/polovnitelefoni-only-logo.svg">
                <p><b>Prijava korisnika</b></p>
            </div>
            <div class="report-content">
                <p class="report-info">Iskazali ste želju za prijavu korisnika <b>
                        <?php
                        if ($profileData['name'] != null && $profileData['lastname'] != null) {
                            echo $profileData['name'] . ' ' . $profileData['lastname'] . '.';
                        } else {
                            echo $profileData['username'] . '.';
                        }
                        ?>
                    </b>
                    Ukoliko smatrate da korisnik narušava pravila naše zajednice, navedite
                    raglog vaše prijave.</p>

                <div class="report-message-container">
                    <p style="margin-bottom: 0; font-weight: 600;">RAZLOG PRIJAVE PROFILA<span
                            style="color: red; font-weight: bold">*</span> :
                    </p>
                    <textarea name="report-message" class="report-message">
                </textarea>
                    <p class="admin-text">Nakon što prijavite profil, administratori će pogledati vašu prijavu i
                        proveriti
                        prijavljeni profil.
                        Bićete blagovremeno obavešteni o ishodu.</p>
                </div>
                <div class="report-confirm report"
                    onclick="reportUser(<?php echo $myId ?>, <?php echo $userID ?>, this)"
                    style="background-color: #ed6969">
                    <img src="../public/src/report-icon.svg?v=<?php echo time(); ?>" alt="Obriši" id="delete-btn">
                    Prijavi korisnika
                </div>
            </div>

            <div class="report-success">
                <p><b>Uspešno ste prijavili korisnika. Administratori će pogledati vaš zahtev i u najkraće mogućem
                        vremeću će vas obavestiti o ishodu.</b></p>
            </div>
            <div class="report-confirm exit" onclick="hiddeReportUser()">
                <img src="../public/src/close-icon-white.svg?v=<?php echo time(); ?>" alt="Obriši">
                <label>Otkaži</label>
            </div>
        </div>
    </div>



    <?php
    require_once "../inc/subscribeForm.php";
    require_once "../inc/footer.php";
    ?>

    <body>
        <script src=" ../public/js/user-profile.js?v=<?php echo time(); ?>"></script>
        <script src="../public/js-public/rpie.js?v=<?php echo time(); ?>"></script>
        <script src="../public/js/donut.js?v=<?php echo time(); ?>"></script>
        <script src="../public/js/user.js?v=<?php echo time(); ?>"></script>
        <script src="../public/js-public/jquery.js?v=<?php echo time(); ?>" type="text/javascript"></script>
        <script src="../public/js/login-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>

</html>