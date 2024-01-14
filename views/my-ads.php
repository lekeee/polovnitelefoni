<?php
include_once "../app/auth/checkAuthState.php";
?>
<!DOCTYPE html>
<html data-wf-domain="polovni-telefoni.webflow.io" data-wf-page="655506e07faa7f82a5f25613"
    data-wf-site="655506e07faa7f82a5f25610">

<?php
require_once "../inc/headTag.php";
?>

<body class="body" onload="savedAdsOnLoad()">

    <?php
    require_once "../inc/header.php";
    require_once "../inc/bottomNavigator.php";
    require_once "../inc/mobileMenu.php";
    ?>

    <link rel="stylesheet" href="../public/css/saved-ads.css?v=<?php echo time() ?>">

    <script src="../public/js/signOut.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <section class="dashboard">
        <div class="div-block-676">
            <div class="div-block-677">
                <?php require_once('../inc/dashboard-navigation.php') ?>
                <script>
                    document.querySelectorAll('.dashboardlinks')[2].classList.add('active');
                </script>
                <div class="div-block-679">
                    <div class="saved-ads-main-container">
                        <div class="no-saved-ads" style="display: none;">
                            <div class="no-saved-ads-main-container">
                                <img src="../public/src/not-found.svg?v=<?php echo time(); ?>" srcset="Love Icon">
                                <p>NEMATE JOŠ NIJEDAN OGLAS</p>
                                <button onclick="window.location.href='add-new-ad.php'">Dodaj novi oglas</button>
                            </div>
                        </div>
                        <div class="saved-ads" style="display: none;">
                            <table>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Proizvod</th>
                                        <th>Brend</th>
                                        <th>Model</th>
                                        <th>Cena</th>
                                        <th class="saved-date">Datum dodavanja</th>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody id="saved-body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="delete-backgound-container">
        <div class="delete-main-container">
            <p>Da li ste sigurni da želite da obrišete oglas
                <strong>Na prodaju novi iPhone 15 Pro Max</strong>
            </p>
            <div class="delete-confirm" onclick="deleteAd()">
                <img src="../public/src/delete-icon.svg?v=<?php echo time(); ?>" alt="Obriši" id="delete-btn">
                Obriši oglas
            </div>
            <div class="delete-confirm">
                <img src="../public/src/close-icon-white.svg?v=<?php echo time(); ?>" alt="Obriši">
                Otkaži
            </div>
        </div>
    </div>

    <?php
    require_once "../inc/subscribeForm.php";
    require_once "../inc/footer.php";
    ?>

    <script src="../public/js-public/jquery.js"></script>
    <script src="../public/js/login-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <script src="../public/js/my-ads.js?v=<?php echo time() ?>"></script>
    <script type="module" src="../public/js/index.js?v=<?php echo time() ?>"></script>
</body>

</html>