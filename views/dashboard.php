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
    <script src="../public/js/signOut.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <section class="dashboard">
        <div class="div-block-676">
            <div class="div-block-677">
                <div class="div-block-678"><a href="dashboard.php" class="dashboardlinks active w-inline-block">
                        <div>Kontrolna tabla</div>
                    </a><a href="add-new-ad.php" class="dashboardlinks w-inline-block">
                        <div>Dodaj oglas</div>
                    </a><a href="#" class="dashboardlinks w-inline-block">
                        <div>Narudžbine</div>
                    </a><a href="#" class="dashboardlinks w-inline-block">
                        <div>Preuzimanja</div>
                    </a><a href="#" class="dashboardlinks w-inline-block">
                        <div>Adrese</div>
                    </a><a href="edit-account.php" class="dashboardlinks w-inline-block">
                        <div>Podaci o nalogu</div>
                    </a><a href="#" class="dashboardlinks w-inline-block">
                        <div>Upoređivanja</div>
                    </a><a href="#" class="dashboardlinks w-inline-block">
                        <div>Omiljeni oglasi</div>
                    </a><a href="#" class="dashboardlinks w-inline-block" onclick="signOut()">
                        <div>Odjavi se</div>
                    </a>
                </div>
                <div class="div-block-679">
                    <div class="text-block-43">Zdravo <strong>
                            <?php
                            if ($userData['username'] !== null) {
                                echo $userData['username'];
                            } else if ($userData['name'] !== null && $userData['lastname'] !== null) {
                                echo $userData['name'] . ' ' . $userData['lastname'];
                            } else {
                                echo "korisniče";
                            }
                            ?>
                        </strong>(niste <strong>
                            <?php
                            if ($userData['username'] !== null) {
                                echo $userData['username'];
                            } else if ($userData['name'] !== null && $userData['lastname'] !== null) {
                                echo $userData['name'] . ' ' . $userData['lastname'];
                            } else {
                                echo "korisniče";
                            }
                            ?>
                        </strong>? <span class="text-span-3" onclick="signOut()">Odjavi se</span>)
                    </div>
                    <div class="text-block-42">Na kontrolnoj tabli svog naloga možete pogledati svoje <span
                            class="text-span-3">nedavne porudžbine</span>, upravljati <span class="text-span-3">adresama
                            za isporuku i fakturisanje</span> kao i <span class="text-span-3"
                            onclick="window.location.href = 'edit-account.php'">izmeniti lozinku i detalje
                            naloga</span>
                    </div>
                    <div class="text-block-42" style="margin-top: 30px">
                        <h4>Brisanje Naloga</h4>
                        <p>Brisanjem vašeg naloga biće obrisane sve informacije o vama kao i svi vaši oglasi. Nakon
                            što obrišete nalog nećete moći da ga povratite.</p>
                        <div class="delete-account-text">
                            <p>Da biste potvrdili brisanje, unesite vaše korisničko ime</p>
                            <div class="delete-input-submit" autocomplete="off">
                                <input type="text" id="delete-password" style="font-weight: bold">
                                <input type="submit" value="Obriši nalog" id="delete-button">
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