<?php
http_response_code(404);
?>

<!DOCTYPE html>
<html data-wf-domain="polovni-telefoni.webflow.io" data-wf-page="655506e07faa7f82a5f25613"
    data-wf-site="655506e07faa7f82a5f25610">

<?php
require_once "../inc/headTag.php";
?>
<link href="../public/css/index.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link href="../public/css/404.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />

<body class="body">

    <?php
    require_once "../inc/header.php";
    require_once "../inc/bottomNavigator.php";
    require_once "../inc/mobileMenu.php";
    ?>

    <section class="mainpageselection">
        <div class="mainpagediv">
            <div class="not-found-main-div">
                <img src="../public/src/404.svg" alt="Not Found">
                <h1>Stranica nije pronađena!</h1>
                <p>Izvinjavamo se, stranica koju tražite nije pronađena.</p>
                <button onclick="window.location.href = '../views'">Vrati se na početnu</button>
            </div>
        </div>
    </section>



    <?php
    require_once "../inc/message-button.php";
    require_once "../inc/subscribeForm.php";
    require_once "../inc/footer.php";
    ?>

    <body>
        <script src="../public/js-public/jquery.js?v=<?php echo time(); ?>" type="text/javascript"></script>
        <script src="../public/js/login-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>

</html>