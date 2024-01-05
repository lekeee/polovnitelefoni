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
                        <div class="no-saved-ads" style="display: none">
                            <div class="no-saved-ads-main-container">
                                <img src="../public/src/love-icon.svg?v=<?php echo time(); ?>" srcset="Love Icon">
                                <p>NEMATE JOŠ NIJEDAN SAČUVANI OGLAS</p>
                                <button>Vrati se u šop</button>
                            </div>
                        </div>
                        <div class="saved-ads">
                            <table>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Proizvod</th>
                                        <th>Cena</th>
                                        <th>Datum dodavanja</th>
                                        <th>Stanje</th>
                                        <th>Oštećenje</th>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img src="../public/src/mobile-phones/Apple/iPhone15ProMax.png"
                                                alt="Slika proizvoda 1" class="table-image"></td>
                                        <td>
                                            <a href="" class="saved-title">Na prodaju iPhone 15 Pro Max</a>
                                        </td>
                                        <td>
                                            <p class="saved-price">€1000</p>
                                        </td>
                                        <td>2024-01-05</td>
                                        <td>Novo</td>
                                        <td>Nema oštećenja</td>
                                        <td>
                                            <div class="saved-price-close-container">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="../public/src/mobile-phones/Apple/iPhone15ProMax.png"
                                                alt="Slika proizvoda 1" class="table-image"></td>
                                        <td>
                                            <a href="" class="saved-title">Na prodaju iPhone 15 Pro Max</a>
                                        </td>
                                        <td>
                                            <p class="saved-price">€1000</p>
                                        </td>
                                        <td>2024-01-05</td>
                                        <td>Novo</td>
                                        <td>Nema oštećenja</td>
                                        <td>
                                            <div class="saved-price-close-container">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="../public/src/mobile-phones/Apple/iPhone15ProMax.png"
                                                alt="Slika proizvoda 1" class="table-image"></td>
                                        <td>
                                            <a href="" class="saved-title">Na prodaju iPhone 15 Pro Max</a>
                                        </td>
                                        <td>
                                            <p class="saved-price">€1000</p>
                                        </td>
                                        <td>2024-01-05</td>
                                        <td>Novo</td>
                                        <td>Nema oštećenja</td>
                                        <td>
                                            <div class="saved-price-close-container">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="../public/src/mobile-phones/Apple/iPhone15ProMax.png"
                                                alt="Slika proizvoda 1" class="table-image"></td>
                                        <td>
                                            <a href="" class="saved-title">Na prodaju iPhone 15 Pro Max</a>
                                        </td>
                                        <td>
                                            <p class="saved-price">€1000</p>
                                        </td>
                                        <td>2024-01-05</td>
                                        <td>Novo</td>
                                        <td>Nema oštećenja</td>
                                        <td>
                                            <div class="saved-price-close-container">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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

    <script src="../public/js-public/jquery.js"></script>
    <script src="../public/js/login-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>
</body>

</html>