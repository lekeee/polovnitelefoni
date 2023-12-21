<?php
    include_once "../app/auth/checkAuthState.php";
    $userData = json_decode($user->returnUser(), true);
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
    <link href="../public/css/edit-account.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <section class="dashboard">
        <div class="div-block-676">
            <div class="div-block-677">
                <div class="div-block-678"><a href="dashboard.php" class="dashboardlinks w-inline-block">
                        <div>Kontrolna tabla</div>
                    </a><a href="#" class="dashboardlinks w-inline-block">
                        <div>Narudžbine</div>
                    </a><a href="#" class="dashboardlinks w-inline-block">
                        <div>Preuzimanja</div>
                    </a><a href="#" class="dashboardlinks w-inline-block">
                        <div>Adrese</div>
                    </a><a href="edit-account.php" class="dashboardlinks active w-inline-block">
                        <div>Podaci o nalogu</div>
                    </a><a href="#" class="dashboardlinks w-inline-block">
                        <div>Upoređivanja</div>
                    </a><a href="#" class="dashboardlinks w-inline-block">
                        <div>Omiljeni oglasi</div>
                    </a><a href="#" class="dashboardlinks w-inline-block" onclick="signOut()">
                        <div>Odjavi se</div>
                    </a></div>
                <div class="div-block-679">
                    <div class="div-block-680"></div>
                    <div class="form-block-5 w-form">
                        <form id="edit-account-form" name="edit-account-form" data-name="Email Form 4" method="get"
                            class="form-5" data-wf-page-id="655506e07faa7f82a5f25613"
                            data-wf-element-id="f9e91c57-77b3-0441-c616-d555e5628bec" action="return false">
                            <div class="edit-account-error" id="edit-account-message">
                                <div style="font-weight: bold;">Thank you! Your submission has been received!</div>
                            </div>
                            <div class="div-block-681">
                                <div class="div-block-682 inputupdate"><label for="UserName" class="field-label">Ime
                                        *</label><input type="text" class="updateinput w-input" maxlength="256"
                                        name="UserName" data-name="UserName" placeholder="" id="UserName" required=""
                                        value="<?php echo $userData['name'] ?? ''; ?>" />
                                </div>
                                <div class="div-block-682"><label for="UserSurname" class="field-label-2">Prezime
                                        *</label><input type="text" class="updateinput w-input" maxlength="256"
                                        name="UserSurname" data-name="UserSurname" placeholder="" id="UserSurname"
                                        required="" value="<?php echo $userData['lastname'] ?? ''; ?>" /></div>
                            </div>
                            <div class="div-block-684"></div>
                            <div class="div-block-682 inputupdate pdtop"><label for="UserUsername"
                                    class="field-label-3">Korisničko ime *</label><input type="text"
                                    class="updateinput w-input" maxlength="256" name="UserUsername"
                                    data-name="UserUsername" placeholder="" id="UserUsername" required=""
                                    value="<?php echo $userData['username'] ?? ''; ?>" />
                                <div class="text-block-44">Ovo ime će se prikazivati u sekciji naloga i recenzijama
                                </div>
                            </div>
                            <div class="div-block-682 inputupdate pdtop"><label for="UserEmail"
                                    class="field-label-3">Email adresa (Ne moze se promeniti)</label><input type="email"
                                    class="updateinput w-input" maxlength="256" name="UserEmail" data-name="UserEmail"
                                    placeholder="" id="UserEmail" value="<?php echo $userData['email'] ?? ''; ?>"
                                    disabled /></div>
                            <div class="div-block-681">
                                <div class="div-block-682 inputupdate pdtop"><label for="UserCity"
                                        class="field-label">Grad *</label><select id="UserCity" name="UserCity"
                                        data-name="UserCity" required="" class="updateinput selectcity w-select"
                                        value="<?php echo $userData['city'] ?? ''; ?>">
                                        <option value="0">Izaberite grad</option>
                                        <?php require_once "../inc/gradovi.php" ?>
                                    </select></div>
                                <div class="div-block-682 inputupdate pdtop"><label for="UserAddress"
                                        class="field-label">Adresa *</label><input type="text"
                                        class="updateinput w-input" maxlength="256" name="UserAddress"
                                        data-name="UserAddress" placeholder="" id="UserAddress" required=""
                                        value="<?php echo $userData['address'] ?? ''; ?>" /></div>
                            </div>
                            <div class="div-block-682 inputupdate pdtop"><label for="UserPhoneNumber"
                                    class="field-label-3">Broj mobilnog telefona *</label><input type="tel"
                                    class="updateinput w-input" maxlength="256" name="UserPhoneNumber"
                                    data-name="UserPhoneNumber" placeholder="" id="UserPhoneNumber" required=""
                                    value="<?php echo $userData['phone'] ?? ''; ?>" /></div>
                            <h1 class="heading-5">Promena lozinke</h1>
                            <div class="div-block-682 inputupdate pdtop">
                                <div class="passwordLabel">
                                    <label for="UserOldPassword" class="field-label-3">Trenutna lozinka (ostavite prazno
                                        ukoliko ne želite da
                                        promenite lozinku)
                                    </label>
                                    <img width="20" loading="lazy" alt="Show Password Icon"
                                        src="../public/src/show_password_icon.png" class="image-8"
                                        onclick="showPassword(1)" input-id="UserOldPassword" id="show1"/>
                                    <img width="20" loading="lazy" alt="Hide Password Icon"
                                        src="../public/src/hide_password_icon.png" class="image-7"
                                        onclick="hidePassword(1)" input-id="UserOldPassword" id="hide1"/>
                                </div>
                                <input type="password" class="updateinput w-input" maxlength="256"
                                    name="UserOldPassword" data-name="UserOldPassword" placeholder=""
                                    id="UserOldPassword" />
                            </div>
                            <div class="div-block-682 inputupdate pdtop">
                                <div class="passwordLabel">
                                    <label for="UserNewPassword" class="field-label-3">Nova lozinka (ostavite prazno
                                        ukoliko
                                        ne želite da promenite
                                        lozinku)</label>
                                    <img width="20" loading="lazy" alt="Show Password Icon"
                                        src="../public/src/show_password_icon.png" class="image-8"
                                        onclick="showPassword(2)" input-id="UserNewPassword" id="show2"/>
                                    <img width="20" loading="lazy" alt="Hide Password Icon"
                                        src="../public/src/hide_password_icon.png" class="image-7"
                                        onclick="hidePassword(2)" input-id="UserNewPassword" id="hide2"/>
                                </div>
                                <input type="password" class="updateinput w-input" maxlength="256"
                                    name="UserNewPassword" data-name="UserNewPassword" placeholder=""
                                    id="UserNewPassword" pattern=".{8,20}" title="Lozinka mora imati između 8 i 20 znakova"/>
                            </div>
                            <div class="div-block-682 inputupdate pdtop">
                                <div class="passwordLabel">
                                    <label for="UserConfirmedNewPassword" class="field-label-3" >Potvrdite novu
                                        lozinku</label>
                                    <img width="20" loading="lazy" alt="Show Password Icon"
                                        src="../public/src/show_password_icon.png" class="image-8"
                                        onclick="showPassword(3)" input-id="UserConfirmedNewPassword" id="show3"/>
                                    <img width="20" loading="lazy" alt="Hide Password Icon"
                                        src="../public/src/hide_password_icon.png" class="image-7"
                                        onclick="hidePassword(3)" input-id="UserConfirmedNewPassword" id="hide3"/>
                                </div>
                                <input type="password" class="updateinput w-input" maxlength="256"
                                    name="UserConfirmedNewPassword" data-name="UserConfirmedNewPassword" placeholder=""
                                    id="UserConfirmedNewPassword" />
                            </div><input type="submit" value="Sačuvaj promene" data-value="Sacuvaj Promene"
                                data-wait="../public/src/loading.gif" class="submit-button-5 w-button" id="saveButton"
                                style="width: 146px; height: 50px; color: white;" />
                        </form>

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
    <script src="../public/js/animations.js?v=<?php echo time(); ?>"></script>
    <script src="../public/js/login-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <script src="../public/js/edit-account.js?v=<?php echo time(); ?>" type="text/javascript"></script>
</body>

</html>