<!DOCTYPE html>
<html data-wf-domain="polovni-telefoni.webflow.io" data-wf-page="655506e07faa7f82a5f25613"
    data-wf-site="655506e07faa7f82a5f25610">

<?php
require_once "../inc/headTag.php";
?>
<link href="../public/css/index.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link href="../public/css/support.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />

<body class="body">

    <?php
    require_once "../inc/header.php";
    require_once "../inc/bottomNavigator.php";
    require_once "../inc/mobileMenu.php";
    ?>

    <?php
    if ($isLogged = $user->isLogged()) {
        $userData = json_decode($user->returnUser(), true);
    }
    ?>

    <link href="../public/css/user.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />

    <section class="mainpageselection">
        <div class="mainpagediv">
            <!-- <img src="../public/src/polovnitelefoni.svg" alt="Polovni Telefoni logo"> -->
            <h2>Kako Vam možemo pomoći?</h2>
            <p>Ukoliko imate neki problem, možete nam staviti do znanja popunjavanjem forme ispod. Naš tim će vas što
                pre kontaktirati.</p>
            <div class="support-main-div">
                <div class="support-header">
                    <div class="logo-problem">
                        <img src="../public/src/polovnitelefoni.svg" alt="">
                    </div>
                </div>
                <div class="support-name-lastname">
                    <div class="suport-column">
                        <p>Ime</p>
                        <input type="text" id="name" placeholder="Unesite Vaše ime" <?php
                        if ($isLogged && $userData['name'] != null) {
                            echo "value=" . $userData['name'];
                        }
                        ?> />
                    </div>
                    <div class="suport-column second">
                        <p>Prezime</p>
                        <input type="text" id="lastname" placeholder="Unesite Vaše prezime" <?php
                        if ($isLogged && $userData['lastname'] != null) {
                            echo "value=" . $userData['lastname'];
                        }
                        ?> />
                    </div>
                </div>
                <div class="support-email-container">
                    <p>Email adresa</p>
                    <input type="text" id="email" placeholder="Unesite Vašu email adresu" <?php
                    if ($isLogged && $userData['email'] != null) {
                        echo "value=" . $userData['email'];
                    }
                    ?> />
                </div>
                <div class="support-email-container">
                    <p>Navedite problem koji imate</p>
                    <input type="text" id="problem" placeholder="npr. Problem sa prijavom na profil" />
                </div>
                <div class="support-email-container">
                    <p>Dajte nam detalje</p>
                    <span sty>Vaši detalji su od izuzetne važnosti! Molimo vas da budete što precizniji. Ukoliko
                        primetite
                        grešku, ljubazno vas molimo da nam navedete korake koje ste preduzeli kako biste je ponovili,
                        vaša očekivanja i šta se zapravo desilo. Naš tim obično odgovara u roku od nekoliko sati.</span>
                    <!-- <input type="text" id="email" placeholder="Unesite Vašu email adresu" style="margin-top: 5px;" /> -->
                    <textarea name="description" id="description"></textarea>
                </div>
                <button onclick="sendMessageToSupport()">Kontaktiraj Podršku</button>
            </div>
        </div>
    </section>

    <div class="report-backgound-container">
        <div class="report-main-container" style="max-width: 400px">
            <div class="image-report-container">
                <img src="../public/src/polovnitelefoni-only-logo.svg">
                <p><b>Obaveštenje</b></p>
            </div>
            <div class="report-content">
                <p>Vaša prijava je poslata administratorima. Bićete obavešteni o ishodu prijave putem email adrese koju
                    ste uneli prilikom podnošenja prijave. </p>
                <div class="report-confirm exit" style="margin-top: 20px;" onclick="hiddeReportUser()">
                    <label>U redu</label>
                </div>
            </div>
        </div>
    </div>

    <?php
    require_once "../inc/message-button.php";
    require_once "../inc/subscribeForm.php";
    require_once "../inc/footer.php";
    ?>

    <body>
        <script src="../public/js/user.js?v=<?php echo time(); ?>"></script>

        <script src="../public/js-public/jquery.js?v=<?php echo time(); ?>" type="text/javascript"></script>
        <script src="../public/js/login-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>
        <script src="../public/js/support.js?v=<?php echo time(); ?>" type="text/javascript"></script>

</html>