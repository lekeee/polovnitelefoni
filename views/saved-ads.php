<?php
include_once "../app/auth/checkAuthState.php";
?>
<!DOCTYPE html>
<html data-wf-domain="polovni-telefoni.webflow.io" data-wf-page="655506e07faa7f82a5f25613"
    data-wf-site="655506e07faa7f82a5f25610" lang="sr">

<?php
require_once "../inc/headTag.php";
?>

<body class="body" onload="savedAdsOnLoad()">

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
                <?php require_once ('../inc/dashboard-navigation.php') ?>
                <script>
                    document.querySelectorAll('.dashboardlinks')[4].classList.add('active');
                </script>
                <div class="div-block-679">
                    <div class="saved-ads-main-container">
                        <div class="no-saved-ads" style="display: none;">
                            <div class="no-saved-ads-main-container">
                                <img src="../public/src/love-icon.svg?v=<?php echo time(); ?>"
                                    alt="Nema sacuvanih oglasa">
                                <p>NEMATE JOŠ NIJEDAN SAČUVANI OGLAS</p>
                                <button onclick="window.location.href='../'">Vrati se u šop</button>
                            </div>
                        </div>
                        <div class="saved-ads" style="display: none;">
                            <table>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Proizvod</th>
                                        <th>Cena</th>
                                        <th class="saved-date">Datum dodavanja</th>
                                        <th>Stanje</th>
                                        <th class="saved-damage">Oštećenje</th>
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

    <?php
    require_once "../inc/message-button.php";
    require_once "../inc/subscribeForm.php";
    require_once "../inc/footer.php";
    ?>

    <script src="../public/js-public/jquery.js"></script>
    <script src="../public/js/login-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <script src="../public/js/saved-ads.js?v=<?php echo time() ?>"></script>
    <script src="../public/js/index.js?v=<?php echo time() ?>"></script>
</body>

</html>