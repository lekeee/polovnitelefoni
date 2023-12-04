<?php
    require_once  "../app/classes/Verification.php";
    require_once "../app/config/config.php";
    $verification = new Verification();
    $uid = $_GET["uid"];
    $userID = $verification->findPasswordCode($uid);
?>

<!DOCTYPE html>
<html data-wf-domain="verification-e726f8.webflow.io" data-wf-page="656c6d51d7f4528e475023c0"
    data-wf-site="656c6d51d7f4528e475023bc">

<?php
    include_once "../inc/verificationAndResetHeader.php";
?>

<body class="body">
    <div class="div-block-2">
        <div class="div-block-3">
            <div class="div-block-6">
                <h1 class="heading">POLOVNI TELEFONI</h1>
            </div>
            <div class="div-block-5">
                <h2 class="heading-2">Problem prilikom prijave?</h2>
                <div class="text-block">Postoji zahtev za promenu vaše lozinke. Resetovanje lozinke je jednostavno. Samo
                    popunite polja ispod. Uskoro ćete ponovo biti online.</div>
                <div class="form-block w-form">
                    <form id="resetPassword" name="email-form" action="return false" method="post"
                        data-name="Email Form" class="form" data-wf-page-id="656c6d51d7f4528e475023c0"
                        data-wf-element-id="3c43c06e-946d-c9a9-e503-37929fed43c5">
                        <div class="div-block-9">
                            <label for="name">Nova lozinka</label>
                            <img src="../public/src/show_password_icon.png" loading="lazy" alt="Show Password"
                                class="image" style="cursor: pointer;" id="showNewPassword" />
                            <img src="../public/src/hide_password_icon.png" loading="lazy" alt="Hide Password"
                                class="image-2" style="cursor: pointer;" id="hideNewPassword" />
                        </div>
                        <input type="password" class="text-field w-input" maxlength="256" name="newPassword"
                            data-name="newPassword" placeholder="" id="newPassword" pattern=".{8,}"
                            title="Lozinka mora imati najmanje 8 karaktera." required="" />
                        <div class="div-block-9">
                            <label for="name-2">Potvrdite novu lozinku</label>
                            <img src="../public/src/show_password_icon.png" loading="lazy" alt="Show Password"
                                class="image" style="cursor: pointer;" id="showRepeatedPassword" />
                            <img src="../public/src/hide_password_icon.png" loading="lazy" alt="Hide Password"
                                class="image-2" style="cursor: pointer;" id="hideRepeatedPassword" />
                        </div>
                        <input type="password" class="text-field-2 w-input" maxlength="256" name="repeatedNewPassword"
                            data-name="repeatedNewPassword" placeholder="" id="repeatedPassword" required="" />
                        <div style="display: flex; justify-content: ceneter; align-items: center; width: 100%">
                            <a href="#" class="button w-button" id="updatePassword"
                                uid-value="<?php echo $userID ?>" style="max-width: 100%"
                                data-value="Ažuriraj Lozinku" data-wait="../public/src/loading.gif">Ažuriraj Lozinku</a>
                            <a href="#" class="button w-button" id="updatedPassword" style="max-width: 100%;  display: none" uid-value="<?php echo $userID ?>">
                                <div style="display: flex; justify-content: center; align-items:center;">
                                    <img src="../public/src/done.png" alt="Done" style="height: 20px">
                                    <p style="margin: 0; padding: 0; margin-left: 10px">Lozinka uspešno ažurirana</p>
                                </div>
                            </a>
                        </div>
                    </form>
                    <div class="w-form-done">
                        <div>Thank you! Your submission has been received!</div>
                    </div>
                    <div class="w-form-fail">
                        <div>Oops! Something went wrong while submitting the form.</div>
                    </div>
                </div>
                <div class="text-block">Ako niste podneli zahtev za promenu lozinke, jednostavno zanemarite ovaj email.
                    U suprotnom, molimo vas da popunite polja iznad i ažurirajte svoju lozinku.</div>
                <div class="text-block novitext">Pozdrav,</div>
                <div class="text-block novitext"><strong>Polovni Telefoni Tim</strong></div>
            </div>
            <div class="div-block-8">
                <div class="text-block-2">Treba vam još neka pomoć?</div><a href="#" class="link">Ovde smo, spremni za
                    razgovor</a>
            </div>
        </div>
    </div>
    <section class="section"></section>
    <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=656c6d51d7f4528e475023bc"
        type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script src="../public/js/resetPassword.js" type="text/javascript"></script>
</body>

</html>