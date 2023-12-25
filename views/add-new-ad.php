<?php
    include_once "../app/auth/checkAuthStateForCreateNewAd.php";
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
    <link rel="stylesheet" href="../public/css/add-new-ad.css?v=<?php echo time() ?>">
    <section class="dashboard">
        <div class="div-block-676">
            <div class="div-block-677">
                <div class="div-block-678"><a href="dashboard.php" class="dashboardlinks w-inline-block">
                        <div>Kontrolna tabla</div>
                    </a><a href="add-new-ad.php" class="dashboardlinks w-inline-block active">
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
                <?php
                    if($userData['name'] !== null && $userData['lastname'] !== null
                        && $userData['username'] !== null && $userData['email'] !== null
                        && $userData['phone'] !== null && $userData['city'] !== null 
                        && $userData['address'] !== null)
                            include_once("add-new-ad-part.php");
                    else
                        echo '
                            <div class="noUserData">
                                <div class="">
                                    <h3 style="font-weight: normal; font-size: 16px; margin: 0; padding: 0">Da biste mogli da postavite oglas prvo morate uneti sve podatke o vama. Podatke možete uneti u sekciji <a href="../views/edit-account.php" style="text-decoration: none; font-weight: bold; color: #0086e6;">Podaci o nalogu</a>. Nakon toga ćete moći da postavite oglas</h3>
                                </div>
                            </div>
                        ';
                ?>
            </div>
        </div>
    </section>

    <?php
        require_once "../inc/subscribeForm.php";
        require_once "../inc/footer.php";
    ?>

    <!-- <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=655506e07faa7f82a5f25610"
        type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
        </script> -->
    <script src="../public/js/login-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>
</body>

</html>