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
                <?php require_once ('../inc/dashboard-navigation.php') ?>
                <script>
                    document.querySelectorAll('.dashboardlinks')[2].classList.add('active');
                </script>
                <?php

                if (
                    $userData['name'] !== null && $userData['lastname'] !== null
                    && $userData['username'] !== null && $userData['email'] !== null
                    && $userData['phone'] !== null && $userData['city'] !== null
                    && $userData['address'] !== null
                )
                    include_once ("add-new-ad-part.php");
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
    <script src="../public/js/login-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>
</body>

</html>