<?php
require_once "../app/auth/userAuthentification.php";
include_once "../app/classes/User.php";
include_once '../app/exceptions/userExceptions.php';

$mySaves = 0;
if ($user->isLogged()) {
    $myData = $user->mySaves(0, 1000);
    $mySavesData = null;

    if ($myData !== null) {
        $mySavesData = json_decode($user->mySaves(0, 1000), true);
    }
    if ($mySavesData !== NULL) {
        $counted = count($mySavesData);
        if ($counted > 9)
            $mySaves = $counted + '+';
        else
            $mySaves = $counted;
    } else
        $mySaves = 0;
}
?>

<link rel="stylesheet" href="../public/css/list-widget.css?v=<?php echo time(); ?>">
<?php if(basename($_SERVER['SCRIPT_FILENAME']) != 'messages.php') {
    ?>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="../pusher/notify.js?v=<?php echo time(); ?>"></script>
<?php } ?>
<script src="../pusher/status.js?v=<?php echo time(); ?>"></script>
<?php
// if ($user->isLogged()) {
//     $token = $user->getToken($_SESSION['user_id']);
//     echo "
//       <script type='module'>
//           localStorage.setItem('token', '" . $token . "');
//       </script>
//       ";
    ?>
    <!-- <script src="../public/js/websocket.js" type="module"></script> -->
    <audio src="../public/audio/alert_tone.mp3" id="audio-tag" muted style="display:none"></audio>
    <?php
//}
?>
<section class="header">
    <div class="w-layout-blockcontainer container firstnavbar w-container">
        <div class="w-layout-blockcontainer container-2 w-container"><a href="../views/about-us.php"
                class="link-block w-inline-block">
                <div class="firstnavbartext">O nama</div>
            </a><a href="<?php echo $user->isLogged() ? '../views/dashboard.php' : '../views/login.php' ?>"
                class="link-block w-inline-block">
                <div class="text-block firstnavbartext">Moj nalog</div>
            </a><a href="#" class="link-block w-inline-block">
                <div class="text-block-2 firstnavbartext">Izdvojeni proizvodi</div>
            </a><a href="../views/saved-ads.php" class="link-block w-inline-block">
                <div class="text-block-3 firstnavbartext">Sačuvani oglasi</div>
            </a></div>
        <div class="w-layout-blockcontainer container-3 w-container">
            <!-- <a href="#" class="link-block w-inline-block" title="U izradi...">
                <div class="text-block-4">Prati pošiljku</div>
            </a> -->
            <div data-hover="false" data-delay="0" class="dropdown w-dropdown">
                <div class="dropdown-toggle seconddropdown w-dropdown-toggle">
                    <div class="text-block-5" style="margin-right: 0px;">
                        Srpski
                    </div>
                    <!-- <img src="../public/src/arrow_down.png" loading="lazy" width="14" height="14"
                        alt="Arrow Down Icon" /> -->
                </div>
                <!-- <nav class="dropdown-list w-dropdown-list"><a href="#" class="dropdown-link w-dropdown-link">English</a>
                </nav> -->
            </div>
            <div data-hover="false" data-delay="0" class="dropdown seconddropdown w-dropdown">
                <div class="dropdown-toggle seconddropdown w-dropdown-toggle">
                    <div class="text-block-5" style="margin-right: 0px;">EUR</div>
                    <!-- <img src="../public/src/arrow_down.png" loading="lazy" width="14"
                        height="14" alt="Arrow Down Icon" /> -->
                </div>
                <!-- <nav class="dropdown-list w-dropdown-list"><a href="#" class="dropdown-link w-dropdown-link">RSD</a>
                </nav> -->
            </div>
        </div>
    </div>
    <div class="div-block"><a data-w-id="dececed3-f170-003e-2db2-631e28dd94b9" href="#" class="w-inline-block"><img
                src="../public/src/hamburger_menu.svg" id='mobile-menu-open' width="30" height="30" alt="Otvori menu"
                class="image-6" /></a>

        <div class="div-block-57" style="cursor: pointer;" onclick="window.location.href='https://polovni-telefoni.rs'"><img
                src="../public/src/polovnitelefoni.svg" loading="lazy" height="60" alt="Logo" class="image" /></div>
        <!-- <div class="div-block-2">
            <div class="div-block-3">
                <div data-hover="false" data-delay="0" data-w-id="665941f7-2c5c-e618-c253-3b3a958220df"
                    class="dropdown-4 w-dropdown">
                    <div class="dropdown-toggle-2 w-dropdown-toggle">
                        <div class="text-block-6">Sve</div>
                        <div class="div-block-74">
                            <div class="div-block-73"><img src="../public/src/arrow_down.png" loading="lazy" width="14"
                                    alt="Arrow Down Icon" /><img src="../public/src/arrow_up.png" loading="lazy"
                                    width="14" alt="Arrow Above" /></div>
                        </div>
                    </div>
                    <nav class="dropdown-list-3 w-dropdown-list"><a href="#"
                            class="dropdown-link-2 w-dropdown-link">Mobilni Telefoni</a><a href="#"
                            class="dropdown-link-3 w-dropdown-link">Tableti</a><a href="#"
                            class="dropdown-link-4 w-dropdown-link">Pametni Satovi</a></nav>
                </div>
            </div>
            <div class="div-block-4"><img src="../public/src/search-icon.svg" loading="lazy" width="24"
                    alt="Search Icon" /></div>
            <div class="form-block w-form">
                <form id="email-form" name="email-form" data-name="Email Form" method="get" class="form"
                    data-wf-page-id="655506e07faa7f82a5f25613"
                    data-wf-element-id="322ffea6-4ecb-344c-4a1e-c7b285d7978c"><input type="text"
                        class="text-field w-input" maxlength="256" name="field" data-name="Field"
                        placeholder="Pretraži svoj omiljeni telefon" id="field" /><input type="submit" value="Pretrazi"
                        data-wait="Please wait..." class="submit-button w-button" /></form>
                <div class="w-form-done"></div>
                <div class="w-form-fail"></div>
            </div>
        </div> -->
        <div class="div-block-2 search-cont" style="position: relative">
            <input type="text" placeholder="Pretraži..." id="searchtext">
            <button class="searchbutton">
                <img src="../public/src/search-icon.svg" loading="lazy" width="22" alt="Pretrazi telefone" />
            </button>
            <div class="search-result-container">
                <div class="search-tutorial-container">
                    <img src="../public/src/search-identificator.svg" alt="Pretrazi telefone">
                    <p>Pretražujte oglase na osnovu njihovog naslova ili unosom ključnih reči</p>
                </div>
                <div class="search-tutorial-container search-not-found">
                    <img src="../public/src/not-found.svg" alt="Rezultat nije pronadjen">
                    <p>Nije pronađen nijedan rezultat</p>
                </div>
                <div class="search-result">

                </div>
            </div>
        </div>
        <div class="div-block-5">
            <div class="div-block-6 div-block-7">
                <div class="div-block-8"
                    onclick="window.location.href='<?php echo $user->isLogged() ? '../views/dashboard.php' : '../views/login.php' ?>'">
                    <img src="../public/src/user_icon.png" loading="lazy" height="35" alt="Korisnikova profilna slika"
                        width="35" class="image-27" />
                    <div>
                        <div class="text-block-7" style="color: grey">
                            <?php echo $user !== NULL && $user->isLogged() ? "Dobrodošli" : "Prijavi se na" ?>
                        </div>
                        <div class="text-block-8">
                            <?php
                            if ($user !== NULL && $user->isLogged()) {
                                $userData = $user->returnUser();
                                $userData = json_decode($userData, true);
                                if ($userData !== null) {
                                    $userDataDecoded = json_decode($user->returnUser(), true);
                                    if (!empty($userDataDecoded['username'])) {
                                        echo $userDataDecoded['username'];
                                    } else {
                                        echo $userDataDecoded['name'] . ' ' . $userDataDecoded['lastname'];
                                    }
                                } else {
                                    echo "Profil";
                                }

                            } else {
                                echo "Profil";
                            }
                            ?>
                        </div>

                    </div>
                </div>
                <div class="div-block-9">
                    <a href="../views/add-new-ad.php" class="link-block-3 w-inline-block">
                        <img src="../public/src/add_new_ad_icon.png" width="20" alt="Dodaj novi oglas"
                            class="image-2" />
                        <div class="text-block-9">Dodaj Oglas</div>
                    </a>
                </div>
                <div class="div-block-10" onclick="window.location.href='../views/saved-ads.php'">
                    <img src="../public/src/love-icon.svg?v=<?php echo time(); ?>" style="width: 30px"
                        alt="Omiljeni telefon" class="image-3" />
                    <div class="div-block-11" id="mySavesContainer"
                        style="display: <?php echo $mySaves > 0 ? 'flex' : 'none' ?>">
                        <div class="text-block-10" id="mySavesCount">
                            <?php echo $mySaves ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="div-block-12">
        <div class="div-block-14">
            <div data-hover="false" data-delay="0" data-w-id="d9013978-067d-ce1a-92bf-79873730cf28"
                class="dropdown-5 w-dropdown">
                <div class="dropdown-toggle-5 w-dropdown-toggle"><img width="30" height="30" alt="Otvori meni"
                        src="../public/src/hamburger_menu.svg" loading="lazy" />
                    <div class="text-block-12">Sve kategorije</div>
                    <div class="div-block-74">
                        <div class="div-block-73"><img width="14" loading="lazy" alt="Otvori"
                                src="../public/src/arrow_down.png" /><img width="14" loading="lazy" alt="Zatvori"
                                src="../public/src/arrow_up.png" />
                        </div>
                    </div>
                </div>
                <nav class="dropdown-list-4 w-dropdown-list">
                    <div class="div-block-69" onclick="showHeaderMobileCategories()">
                        <div class="div-block-70">
                            <img width="30" loading="lazy" alt="Mobilni telefon"
                                src="../public/src/mobile_phone_icon.png" />
                            <div class="text-block-39">Mobilni Telefoni</div>
                        </div>
                        <div class="div-block-76">
                            <div class="div-block-75">
                                <img width="16" loading="lazy" alt="Sledece" src="../public/src/arrow_right.png"
                                    class="image-24" />
                                <img width="14" loading="lazy" alt="Prethodno" src="../public/src/arrow_left.png"
                                    class="image-26" />
                            </div>
                        </div>
                        <div class="div-block-71" id="header-phone-list" style="display: none;">
                            <div class="div-block-72">
                                <div class="text-block-40">Mobilni Telefoni</div>
                                <a href="../views/index.php?brand=Apple" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">Apple</div>
                                </a>
                                <a href="../views/index.php?brand=Samsung" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">Samsung</div>
                                </a>
                                <a href="../views/index.php?brand=Xiaomi" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">Xiaomi</div>
                                </a>
                                <a href="../views/index.php?brand=Huawei" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">Huawei</div>
                                </a>
                                <a href="../views/index.php?brand=Motorola" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">Motorola</div>
                                </a>
                                <a href="../views/index.php?brand=Nokia" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">Nokia</div>
                                </a>
                                <a href="../views/index.php?brand=Google" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">Google</div>
                                </a>
                                <a href="../views/index.php?brand=OnePlus" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">OnePlus</div>
                                </a>
                                <a href="../views/index.php?brand=Honor" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">Honor</div>
                                </a>
                                <a href="../views/index.php?brand=Alcatel" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">Alcatel</div>
                                </a>
                                <a href="../views/index.php?brand=Poco" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">Poco</div>
                                </a>
                                <a href="../views/index.php?brand=Realme" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">Realme</div>
                                </a>
                                <a href="../views/index.php?brand=Tesla" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">Tesla</div>
                                </a>
                                <a href="../views/index.php?brand=LG" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">LG</div>
                                </a>
                                <a href="../views/index.php?brand=Microsoft" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">Microsoft</div>
                                </a>
                                <a href="../views/index.php?brand=ZTE" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">ZTE</div>
                                </a>
                                <a href="../views/index.php?brand=Oppo" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">Oppo</div>
                                </a>
                                <a href="../views/index.php?brand=Vivo" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">Vivo</div>
                                </a>
                                <a href="../views/index.php?brand=Blackberry" class="link-block-12 w-inline-block">
                                    <div class="mobilephonebrand">Blackberry</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="div-block-69" style="cursor: default">
                        <div class="div-block-70"><img width="30" loading="lazy" alt="Slusalice za telefon"
                                src="../public/src/headphones_icon.png" />
                            <div class="text-block-39">Slušalice <span style="color: #ed6969">(Uskoro!)</span></div>
                        </div>
                    </div>
                    <div class="div-block-69" style="cursor: default">
                        <div class="div-block-70" sryle><img width="30" loading="lazy"
                                alt="Oprema i delovi za mobilne telefone" src="../public/src/other_icon.png" />
                            <div class="text-block-39">Oprema i Delovi <span style="color: #ed6969">(Uskoro!)</span>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="div-block-15">
            <a href="../views/index.php" class="link-block-4 w-inline-block">
                <img src="../public/src/home-navigator.svg" loading="lazy" width="20" height="20"
                    alt="Polovni telefoni pocetna" class="image-4" />
                <div class="text-block-13">Početna</div>
            </a>
            <a href="#" class="shopTrigger link-block-4 w-inline-block">
                <img src="../public/src/shop-icon.svg" loading="lazy" width="20" height="20"
                    alt="Polovni telefoni prodavnica" class="image-4" />
                <div class="text-block-13">Šop</div>
            </a>
            <a href="#" class="subscribeTrigger link-block-4 w-inline-block">
                <img src="../public/src/subscribe-icon.svg" loading="lazy" width="16" height="16"
                    alt="Polovni telefoni pretplati se" class="image-4" />
                <div class="text-block-13">Pretplati se</div>
            </a>
            <a href="#" class="link-block-4 w-inline-block">
                <img src="../public/src/contact-navigator.svg" loading="lazy" width="18" height="18"
                    alt="Polovni telefoni kontakt" class="image-4" />
                <div class="text-block-13">Kontakt</div>
            </a>
            <a href="#" class="link-block-4 w-inline-block" title="Uskoro!">
                <img src="../public/src/blog-icon.svg" loading="lazy" width="20" height="20" alt="Polovni telefoni blog"
                    class="image-4" />
                <div class="text-block-13" title="Uskoro!">Blog</div>
            </a>
            <a href="../views/support.php" class="link-block-4 w-inline-block">
                <img src="../public/src/support-navigator.svg" loading="lazy" width="20" height="20"
                    alt="Polovni telefoni podrska" class="image-4" />
                <div class="text-block-13">Podrška</div>
            </a>
        </div>
        <div class="div-block-16">
            <div data-hover="false" data-delay="0" class="dropdown-3 w-dropdown">
                <div class="dropdown-toggle-4 w-dropdown-toggle"><img src="../public/src/onsale_icon.jpg" loading="lazy"
                        width="33" alt="Snizeni telefoni" class="image-5" />
                    <div class="div-block-17">
                        <div class="text-block-14">Samo ovog vikenda</div>
                        <div class="text-block-15">Super sniženja</div>
                    </div><img width="14" loading="lazy" alt="Otvori" src="../public/src/arrow_down.png" />
                </div>
                <nav class="w-dropdown-list">
                    <a href="#" class="w-dropdown-link">Uskoro!</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<div class="div-block-13 lineseparator"></div>
<div data-w-id="2312cd45-42d1-6acc-59ef-08dd05adea72" class="div-block-55"></div>
<script src="../public/js/header.js?v=<?php echo time(); ?>"></script>
