<?php
include_once "../app/auth/checkAuthState.php";
?>
<!DOCTYPE html>
<html data-wf-domain="polovni-telefoni.webflow.io" data-wf-page="655506e07faa7f82a5f25613"
    data-wf-site="655506e07faa7f82a5f25610">

<?php
require_once "../inc/headTag.php";
?>

<body class="body">

    <?php
    require_once "../inc/header.php";
    require_once "../inc/bottomNavigator.php";
    require_once "../inc/mobileMenu.php";
    ?>

    <link rel="stylesheet" href="../public/css/saved-ads.css">

    <script src="../public/js/signOut.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <section class="dashboard">
        <div class="div-block-676">
            <div class="div-block-677">
                <?php require_once('../inc/dashboard-navigation.php') ?>
                <script>
                    document.querySelectorAll('.dashboardlinks')[7].classList.add('active');
                </script>
                <div class="div-block-679">
                    <div class="saved-ads-main-container">
                        <div class="no-saved-ads">
                            <div class="no-saved-ads-main-container">
                                <img src="../public/src/love-icon.svg?v=<?php echo time(); ?>" srcset="Love Icon">
                                <p>NEMATE JOŠ NIJEDAN SAČUVANI OGLAS</p>
                                <button>Vrati se u šop</button>
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

    <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=655506e07faa7f82a5f25610"
        type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script src="../public/js/login-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <script src="../public/js/dashboard.js?v=<?php echo time(); ?>" type="text/javascript"></script>
</body>

</html>