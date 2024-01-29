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
            <div class="background-user-image">
                <div class="user-image-container">
                    <div class="user-profile-image">
                        <img src="../public/src/userShow2.svg" alt="" srcset="">
                    </div>
                </div>
            </div>
            <div class="user-info-container">
                <div class="info-container">
                    <h2>Djordje Ivanovic</h2>
                    <div class="inf-cont">
                        <div class="mail-container">
                            <img src="../public/src/mail.svg" alt="">
                            <p>idjordje63@gmail.com</p>
                        </div>
                        <div class="mail-container">
                            <img src="../public/src/message-icon2.svg" alt="">
                            <p style="cursor: pointer">Pošalji poruku</p>
                        </div>
                        <div class="mail-container">
                            <img src="../public/src/phone-call2.svg" alt="">
                            <p style="cursor: pointer">0637303883</p>
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

</html>