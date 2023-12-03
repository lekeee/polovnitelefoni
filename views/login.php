<?php
    include_once "../app/auth/checkAuthStateForLogin.php";
?>
<!DOCTYPE html>
<html data-wf-domain="polovni-telefoni.webflow.io" data-wf-page="655506e07faa7f82a5f25613"
    data-wf-site="655506e07faa7f82a5f25610">

<?php
    require_once "../inc/headTag.php";
?>

<body class="body">
    
    <link href="../public/css/login.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <?php
            require_once "../inc/header.php";
            require_once "../inc/bottomNavigator.php";
            require_once "../inc/mobileMenu.php";
        ?>

    <!-- PRIJAVA I REGISTRACIJA -->

    <section class="section">
        <div class="div-block-18">
            <div class="div-block-19">
                <div class="div-block-21">
                    <div class="div-block-20"><a href="#" class="link-block-5 w-inline-block">
                            <div data-w-id="f9206722-de66-a8d1-6941-46c4d4900b6b" class="text-block-16 pritext">PRIJAVA
                            </div>
                        </a><a href="#" class="link-block-5 w-inline-block">
                            <div data-w-id="8a50f284-bc85-0a6b-38d3-daec57ae57de" class="text-block-16 regtext">
                                REGISTRACIJA</div>
                        </a></div>
                    <div class="div-block-24">
                        <div class="prijavacontainter">
                            <div class="form-block-2 w-form">
                                <form id="wf-form-Email-Form-1" action="return false" name="wf-form-Email-Form-1"
                                    data-name="Email Form 1" method="post" class="form-2"
                                    data-wf-page-id="655506e07faa7f82a5f25613"
                                    data-wf-element-id="402ffa6f-510e-569c-4c22-28c4aa49bb28"><label for="login-email"
                                        class="field-label2">Korisničko ime ili email adresa *</label><input type="text"
                                        class="text-field-2 w-input" maxlength="256" name="login-email"
                                        data-name="login-email" placeholder="" id="login-email" required="" />
                                    <div class="div-block-22"><label for="email-2" class="field-label2">Lozinka
                                            *</label><img width="20" loading="lazy" alt="Show Password Icon"
                                            src="../public/src/show_password_icon.png" class="image-8"
                                            id="login-show-password" title="Prikaži lozinku" /><img width="20"
                                            loading="lazy" alt="Hide Password Icon"
                                            src="../public/src/hide_password_icon.png" class="image-7"
                                            id="login-hide-password" style="cursor: pointer;" title="Sakrij lozinku" />
                                    </div><input type="password" class="text-field-2 textfieldpassword w-input"
                                        maxlength="256" name="login-password" data-name="login-password" placeholder=""
                                        id="login-password" required="" />
                                    <div><label class="w-checkbox checkbox-field"><input type="checkbox" id="checkbox"
                                                name="checkbox" data-name="Checkbox" class="w-checkbox-input" /><span
                                                class="w-form-label" for="checkbox">Zapamti me</span></label></div>
                                    <input type="submit" value="Prijavi se" data-value="Prijavi se"
                                        data-wait="../public/src/loading.gif" class="submit-button-2 w-button"
                                        id="login-submit" />

                                    <div class="div-block-77" id="login-error-div" style="display: none">
                                        <div style="" id="login-error-div2" class="div-block-266">
                                            <div class="text-block-19" id='login-error'><b>GRESKA:</b> <span>Pogrešna
                                                    email adresa ili lozinka</span></div>
                                        </div>
                                    </div>
                                    <a href="#" class="link-block-6 w-inline-block">
                                        <div data-w-id="eacab9bd-492a-1551-d636-2c4483ed8476"
                                            style="-webkit-transform:translate3d(0, -90px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-moz-transform:translate3d(0, -90px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-ms-transform:translate3d(0, -90px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);transform:translate3d(0, -90px, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0)"
                                            class="text-block-17">Zaboravili ste lozinku?</div>
                                    </a>
                                </form>
                                <div class="w-form-done"></div>
                                <div class="w-form-fail"></div>
                            </div>
                        </div>
                        <div class="div-block-23 registracijacontainer">
                            <div class="form-block-2 w-form">
                                <form id="email-form-2" action="return false" name="email-form-2"
                                    data-name="Email Form 2" method="get" class="form-2"
                                    data-wf-page-id="655506e07faa7f82a5f25613"
                                    data-wf-element-id="dbd58ca1-f8dc-b409-ed3a-9c036c632d34"><label
                                        for="signup-username" class="field-label2">Korisničko ime *</label><input
                                        type="text" class="text-field-2 w-input" maxlength="256" name="signup-username"
                                        data-name="signup-username" placeholder="" id="signup-username" required="" />
                                    <div class="div-block-22"><label for="email-3" class="field-label2">Email adresa
                                            *</label></div><input type="email"
                                        class="text-field-2 textfieldpassword w-input" maxlength="256"
                                        name="signup-email" data-name="signup-email" placeholder="" id="signup-email"
                                        required="" />
                                    <div class="div-block-22"><label for="email-4" class="field-label2">Lozinka
                                            *</label><img width="20" loading="lazy" alt="Show Password Icon"
                                            src="../public/src/show_password_icon.png" class="image-8"
                                            id="register-show-password" /><img width="20" loading="lazy"
                                            alt="Hide Password Icon" src="../public/src/hide_password_icon.png"
                                            class="image-7" id="register-hide-password" /></div><input type="password"
                                        class="text-field-2 textfieldpassword w-input" maxlength="256"
                                        name="signup-password" data-name="signup-password" placeholder=""
                                        id="signup-password" required="" />
                                    <div class="div-block-22"><label for="email-4" class="field-label2">Potvrdite
                                            lozinku
                                            *</label><img width="20" loading="lazy" alt="Show Password Icon"
                                            src="../public/src/show_password_icon.png" class="image-8"
                                            id="register-show-repeated-password" /><img width="20" loading="lazy"
                                            alt="Hide Password Icon" src="../public/src/hide_password_icon.png"
                                            class="image-7" id="reqister-hide-repeated-password" /></div><input
                                        type="password" class="text-field-2 textfieldpassword w-input" maxlength="256"
                                        name="signup-repeaterpassword" data-name="signup-repeaterpassword"
                                        placeholder="" id="signup-repeaterpassword" required="" />
                                    <div class="div-block-25">
                                        <div class="text-block-18">Vaši lični podaci će se koristiti radi poboljšanja
                                            vašeg iskustva na ovoj veb stranici, upravljanja pristupom vašem nalogu i u
                                            skladu s našom politikom privatnosti</div>
                                    </div><input type="submit" value="Registruj se" data-value="Registruj se"
                                        data-wait="../public/src/loading.gif" class="submit-button-2 w-button"
                                        id="register-submit" />
                                </form>
                                <div class="w-form-done"></div>
                                <div class="w-form-fail"></div>
                            </div>
                            <div class="div-block-77" id="register-error-div" style="display: none">
                                <div style="" id="register-error-div2" class="div-block-266">
                                    <div class="text-block-19" id='register-error'><b>GRESKA:</b> <span>Pogrešna email
                                            adresa ili lozinka</span></div>
                                </div>
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
    <script src="../public/js/animations.js?v=<?php echo time(); ?>"></script>
    <script src="../public/js/login.js?v=<?php echo time(); ?>"></script>
    <script src="../public/js/register.js?v=<?php echo time(); ?>"></script>
</body>

</html>