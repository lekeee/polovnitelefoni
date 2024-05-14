<?php
require_once "../app/classes/Verification.php";
require_once "../app/config/config.php";
$verification = new Verification();
$uid = $_GET["uid"];
$userID = $verification->findCode($uid);
?>

<!DOCTYPE html>
<html data-wf-domain="verification-e726f8.webflow.io" data-wf-page="656c6d51d7f4528e475023c0"
    data-wf-site="656c6d51d7f4528e475023bc" lang="sr">

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
                <h2 class="heading-2">Zdravo, djordje.ivanovic!</h2>
                <div class="text-block">S radošću Vas dočekujemo u našoj zajednici. Pre nego što započnete, molimo vas
                    da potvrdite svoj nalog pritiskom na donje dugme.</div>
                <div class="div-block-7">
                    <a href="#" id="verify-email" uid-value="<?php echo $userID; ?>" class="button w-button"
                        data-value="Potvrdite Nalog" data-wait="../public/src/loading.gif">Potvrdite Nalog
                    </a>
                    <a href="#" class="button w-button" id="verified_button" style="cursor: default; display: none;">
                        <div style="display: flex; justify-content: center; align-items:center">
                            <img src="../public/src/done.png" alt="Uspešno Verifikovano" style="height: 20px">
                            <p style="margin: 0; padding: 0; margin-left: 10px">Uspešno Verifikovano</p>
                        </div>
                    </a>
                </div>
                <div class="text-block">Ako ovo ne uspe, obratite se našem timu za podršku</div>
                <div class="text-block novitext redtext">support@polovnitelefoni.com</div>
                <div class="text-block novitext">Ukoliko imate bilo kakvih pitanja, slobodno odgovorite na ovaj email –
                    uvek smo tu da vam pomognemo.</div>
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
    <!-- <script src="../public/js/verification-script.js?v=<?php echo time(); ?>" type="text/javascript"></script> -->
    <script src="../public/js/verification.js?v=<?php echo time(); ?>"></script>

</body>

</html>