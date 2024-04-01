<?php
include_once "../app/auth/userAuthentification.php";
require_once "../app/config/config.php";
include_once "../app/classes/Phone.php";
include_once '../app/exceptions/userExceptions.php';

$phone = new Phone();
$adId = $_GET['ad_id'];
if (isset($adId)) {
    try {
        $phoneAd = $phone->read($adId);
        $adData = json_decode($phoneAd, true);
        //$visitorsData = $phone->totalVisits($adId);
        $visitorsData = $adData['views'];
        $adOwner = json_decode($user->getUserDataFromId($adData['user_id']), true);
        $savesCount = $phone->countSaves($adId);

        $myData = $user->mySaves();
        $mySaves = null;
        if ($myData !== null) {
            $mySaves = json_decode($user->mySaves(), true);
        }
        $savedAdsIds = [];
        if ($mySaves !== null) {
            $savedAdsIds = array_column($mySaves, 'ad_id');
        }
        $saved = in_array($adData['ad_id'], $savedAdsIds);

    } catch (Exception $e) {
        header('Location: index.php');
    }
}
if (!isset($phoneAd)) {
    header('Location: index.php');
}
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
    <link href="../public/css/ad-images.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="../public/css/loader.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="../public/css/loading-animation.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <section class="phoneview">
        <div class="div-block-687">
            <div class="div-block-688">
                <a href="../views/index.php" class="lightlink">Pocetna</a>
                <div class="text-block-45 lighttext">/</div>
                <a href="../views/index.php?brand=<?php echo $adData["brand"] ?>#productscontainer" class="lightlink">
                    <?php echo $adData["brand"] ?>
                </a>
                <div class="text-block-45 lighttext">/</div>
                <a href="../views/index.php?brand=<?php echo $adData["brand"] ?>&model=<?php echo $adData['model'] ?>#productscontainer"
                    class="link">
                    <?php echo $adData['model'] ?>
                </a>
            </div>
            <div class="div-block-689">
                <div class="div-block-690">
                    <div class="div-block-692">
                        <div class="slider-container" style="position: relative">
                            <div class="slider">
                                <div class="slides">
                                    <?php $folderPath = "../uploads/" . $adData['images'];
                                    $files = array_diff(scandir($folderPath), array('..', '.'));
                                    foreach ($files as $file) {
                                        $putanja = "../uploads/" . $adData['images'] . '/' . $file;
                                        $imageSize = getimagesize($putanja);
                                        $width = $imageSize[0];
                                        $height = $imageSize[1];
                                        ?>

                                        <div style="display: block; width: 100%; height: 100%; padding: 20px">
                                            <a href="#" class="lightbox-link w-lightbox">
                                                <img src="<?php echo $putanja; ?>" loading="lazy"
                                                    sizes="(max-width: 479px) 100vw, (max-width: 767px) 95vw, (max-width: 991px) 77vw, (max-width: 1279px) 38vw, 608px"
                                                    srcset="<?php echo $putanja; ?> 500w, <?php echo $putanja; ?> 600w"
                                                    alt="<?php echo $adData['brand'] . $adData['model'] ?>"
                                                    class="image-41" />
                                                <script type="application/json" class="w-json">
                                                                    {
                                                                        "items": [{
                                                                            "_id": "656ed08ea98a280693a4f870<?php echo $adId ?>",
                                                                            "origFileName": "<?php echo $file; ?>",
                                                                            "fileName": "<?php echo $file; ?>",
                                                                            "fileSize": <?php echo filesize($putanja); ?>,
                                                                            "height": <?php echo $height; ?>,
                                                                            "url": "<?php echo $putanja; ?>",
                                                                            "width": <?php echo $width; ?>,
                                                                            "type": "image"
                                                                        }],
                                                                        "group": "phoneImage"
                                                                    }
                                                                </script>
                                            </a>
                                        </div>

                                    <?php } ?>
                                </div>
                                <div class="prev">
                                    <img src="../public/src/arrow_left_icon.svg" alt="Arrow Left"
                                        srcset="../public/src/arrow_left_icon.svg" style="fill: #000">
                                </div>
                                <div class="next">
                                    <img src="../public/src/arrow_right_icon.svg" alt="Right Left"
                                        srcset="../public/src/arrow_right_icon.svg">
                                </div>

                                <?php
                                if ($adData['damage'] !== NULL) {
                                    ?>
                                    <div class="damage-identificator" title="Uređaj je oštećen">
                                        <img src="../public/src/broken-phone.svg" alt="" srcset="">
                                    </div>

                                    <?php
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                    <div class="thumbnails-container">
                        <div class="thumbnails">

                            <?php
                            $counter = 0;
                            foreach ($files as $file) {
                                $putanja = "../uploads/" . $adData['images'] . '/' . $file;
                                if ($counter == 0) {
                                    ?>
                                    <div class="thumbnail selected" data-index="<?php echo $counter ?>">
                                        <img src="<?php echo $putanja; ?>" alt="Thumbnail 1">
                                    </div>
                                <?php } else { ?>
                                    <div class="thumbnail" data-index="<?php echo $counter ?>">
                                        <img src="<?php echo $putanja; ?>" alt="Thumbnail 1">
                                    </div>
                                <?php } ?>
                                <?php $counter++;
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="div-block-723">
                    <div class="div-block-691">
                        <h1 class="heading-6">
                            <?php echo $adData['title'] ?>
                        </h1>
                        <div class="div-block-718">
                            <div class="div-block-717">
                                <div class="div-block-693">
                                    <div class="text-block-46 newmodel">Brend:</div><a href="#" class="link-2">
                                        <?php echo $adData['brand'] ?>
                                    </a>
                                    <div class="text-block-46">|</div>
                                    <div class="text-block-46 newmodel">Model:</div><a href="#" class="link-3">
                                        <?php echo $adData['model'] ?>
                                    </a>
                                </div>
                                <div class="div-block-695">
                                    <div class="deviceState">
                                        <?php
                                        if ($adData['state'] === 0) {
                                            echo "<p><b>" . $adData['stateRange'] . " / 10</b></p>";
                                            echo '<script>
                                                document.getElementsByClassName("deviceState")[0].style.borderColor = "#FBBD28";
                                                document.getElementsByClassName("deviceState")[0].style.backgroundColor = "#FBBD28";
                                                document.getElementsByClassName("deviceState")[0].style.borderRadius = "20px";
                                            </script>';
                                        } else if ($adData['state'] === 1) {
                                            echo "<p><b>Novo</b></p>";
                                        }
                                        ?>
                                    </div>
                                    <div class="div-block-696">
                                        <div class="text-block-47">
                                            <?php
                                            echo '<p>' . $visitorsData . '</p>';
                                            ?>
                                            <img src="../public/src/eye-icon.svg" alt="Eye" srcset="">
                                        </div>
                                    </div>
                                    <div class="div-block-696">
                                        <div class="text-block-47">
                                            <?php
                                            echo '<p>' . $savesCount . '</p>';
                                            ?>
                                            <img src="../public/src/favourite_icon.png" alt="Eye" srcset=""
                                                style="width: 20px">
                                        </div>
                                    </div>
                                </div>
                                <div class="div-block-700">
                                    <div class="div-block-697"><img src="../public/src/done-icon.png" loading="lazy"
                                            alt="Available" class="image-31" />
                                        <div class="text-block-48">Na stanju</div>
                                    </div>
                                    <?php if (!empty($adData['damage'])) { ?>
                                        <!-- <div class="div-block-699">
                                            <div class="text-block-49">OŠTEĆENJE</div>
                                        </div> -->
                                    <?php } ?>

                                </div>
                                <div class="div-block-701">
                                    <h2 class="heading-8">
                                        <?php
                                        if (empty($adData['price'])) {
                                            echo "Dogovor";
                                        } else {
                                            echo '€' . $adData['price'];
                                        }
                                        ?>
                                    </h2>
                                    <h2 class="heading-9">
                                        <?php
                                        if (!empty($adData['old_price'])) {
                                            if (!empty($adData['price'])) {
                                                echo '€' . $adData['old_price'];
                                            }
                                        }
                                        ?>
                                    </h2>
                                </div>
                            </div>

                            <div data-w-id="0eacc543-0b81-e5be-a1e1-d7c3709a619c" class="div-block-719"
                                onclick="window.location.href='user.php?id=<?php echo $adData['user_id'] ?>'">
                                <img src="../public/src/userShow2.svg" loading="lazy" alt="User Profile Image"
                                    class="image-39" style="width: 64px; height: 64px" />
                                <h1 class="heading-10">
                                    <?php echo $adOwner['name'] . ' ' . $adOwner['lastname'] ?>
                                </h1>
                                <div class="text-block-57">
                                    <?php echo $adOwner['city'] ?>
                                </div>
                                <div class="text-block-60">
                                    <?php echo $adOwner['address'] ?>
                                </div>
                            </div>
                        </div>
                        <div class="access-damaged-container">
                            <div class="access-damaged-actions-container">
                                <div class="access-action-container active" onclick="showAccess(this)" id="access-ident"
                                    style="border-left: none; border-right:none;">
                                    <p>Dodatna oprema</p>
                                </div>
                                <div class="access-action-container" onclick="showDamaged(this)" id="damaged-ident"
                                    style="border-right: none;">
                                    <p>Oštećenja</p>
                                </div>
                            </div>
                            <div class="access-container">
                                <?php
                                if ($adData['accessories'] !== NULL && $adData['accessories'] !== '') {
                                    $access = explode(',', $adData['accessories']);
                                    for ($i = 0; $i < count($access); $i++) {
                                        if ($access[$i] !== '') {
                                            ?>
                                            <p class="access-item">
                                                <?php echo $access[$i] ?>
                                            </p>
                                            <?php
                                        }
                                    }
                                } else {
                                    echo "<i>Nema dodatne opreme</i>";
                                }
                                ?>
                            </div>
                            <div class="damaged-container" style="display: none">
                                <?php
                                if ($adData['damage'] !== NULL && $adData['damage'] !== '') {
                                    $damages = explode(',', $adData['damage']);
                                    for ($i = 0; $i < count($damages); $i++) {
                                        if ($damages[$i] !== '') {
                                            ?>
                                            <p class="damaged-item">
                                                <?php echo $damages[$i] ?>
                                            </p>
                                            <?php
                                        }
                                    }
                                } else {
                                    echo "<i style='margin: 5px;'>Nema oštećenja</i>";
                                }
                                ?>
                            </div>
                        </div>
                        <div style="margin-top: 10px;">
                            <div class="div-block-702">
                                <div class="div-block-703">
                                    <div class="div-block-720">
                                        <div class="div-block-712">
                                            <div class="div-block-714">
                                                <div class="text-block-56">
                                                    <?php echo $adOwner['phone'] ?>
                                                </div>
                                                <div class="div-block-704">
                                                    <div class="div-block-716"
                                                        ownerid="<?php echo $adData['user_id'] ?>"
                                                        myid="<?php echo $user->getId(); ?>"
                                                        onclick="openMessages(this)">
                                                        <img src="../public/src/message-icon.png" loading="lazy"
                                                            alt="Message" class="image-32 messagebtn" />
                                                        <div class="text-block-50">Kontaktiraj vlasnika</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div data-w-id="3a24efa4-af9d-9de5-42c6-e9ec9ee2e77d" class="div-block-713">
                                                <img src="../public/src/call-icon.png" loading="lazy" alt="Call User"
                                                    class="image-37" />
                                            </div>
                                            <div data-w-id="6938d356-7183-26a9-3423-51e3d414b225" class="div-block-715">
                                                <img src="../public/src/close_icon.png" loading="lazy" alt="Close Icon"
                                                    class="image-38" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="div-block-721">
                                        <div class="div-block-705" <?php
                                        if ($user->isLogged()) {
                                            ?>
                                                onclick="checkIsSaved(event, this,<?php echo $user->getId() ?>, <?php echo $_GET['ad_id'] ?>, '#818ea0') "
                                                <?php
                                        } else {
                                            ?> onclick="checkIsSaved2(event)" <?php
                                        }
                                        ?>>
                                            <svg fill="<?php echo $saved == 1 ? "red" : "none" ?>"
                                                stroke="<?php echo $saved == 1 ? "red" : "#818ea0" ?>" width="20"
                                                height="20" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                            </svg>
                                            <div class="text-block-51" id="saved-identificator">
                                                <?php
                                                if ($saved == 1) {
                                                    echo "Ukloni";
                                                } else {
                                                    echo "Sačuvaj oglas";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="div-block-722">
                                        <div class="div-block-705"><img src="../public/src/compare.png" loading="lazy"
                                                alt="Compare" class="image-33" />
                                            <div class="text-block-51">Uporedi</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="div-block-706"><img src="../public/src/delivery.png" loading="lazy"
                                    alt="Delivery" class="image-34" />
                                <div class="text-block-52">Način isporuke u dogovoru sa vlasnikom</div>
                            </div>
                        </div>
                        <div class="div-block-707" style="margin-top: 10px;"><img src="../public/src/bag-orange.png"
                                loading="lazy" alt="Bag Icon" class="image-40" />
                            <div>
                                <div class="text-block-53">Drugi ljudi žele ovaj proizvod. </div>
                                <div class="text-block-54">
                                    <?php
                                    if ($savesCount === 0) {
                                        echo "Još uvek niko nema ovaj proizvod u svojoj listi sačuvanih oglasa.";
                                    } else if ($savesCount === 1) {
                                        echo $savesCount . ' korisnik ima ovaj proizvod u svojoj listi sačuvanih oglasa.';
                                    } else {
                                        echo $savesCount . ' ljudi ima ovaj proizvod u svojoj listi sačuvanih oglasa.';
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="div-block-708">
                            <div class="text-block-55">Kategorije: </div><a href="#" class="link-4">Mobilni Telefoni,
                            </a><a href="#" class="link-5">
                                <?php echo $adData['brand'] ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-5">
        <div class="div-block-731">
            <div class="div-block-725">
                <div class="div-block-726">
                    <div data-w-id="ca06c0df-f122-2eb0-711c-53d97785762d" class="text-block-62 active">Opis</div>
                    <div data-w-id="dd0bd59b-ada1-078f-c925-4c84938e584f" class="text-block-62" id="specificationsLabel"
                        onclick="getSpecifications('<?php echo $adData['brand'] ?>', '<?php echo $adData['model'] ?>')">
                        Specifikacije</div>
                    <div data-w-id="05341f4c-4ed0-2258-5d8c-0234a92e6582" class="text-block-62">3D Model</div>
                </div>
            </div>
            <div class="div-block-730">
                <div class="div-block-727">
                    <div class="div-block-729 w-clearfix">
                        <div class="div-block-728">
                            <div class="div-block-739"></div>
                            <div data-w-id="6fca3ad3-2131-9081-d970-14fd01504b49" class="div-block-740">
                                <div class="rich-text-block w-richtext">
                                    <?php echo $adData['description'] ?>
                                </div>
                            </div>
                        </div>
                        <div class="div-block-728">
                            <div class="div-block-737"></div>
                            <div class="div-block-738 specsdiv">
                                <div class="loadingSpecifications">
                                    <?php
                                    include_once ('../inc/loadingSpecifications.php');
                                    ?>
                                </div>
                                <!-- <div id="loader-container"
                                    style="width: 100%; display: flex; justify-content: center; padding: 20px">
                                    <div class="loader"></div>
                                </div> -->
                            </div>
                        </div>
                        <div class="div-block-736 _3dmodelshow">
                            <h1 class="heading-13">Uskoro!</h1>
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

    <script src="../public/js-public/jquery.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <script src="../public/js/login-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <script src="../public/js/ad-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <script src="../public/js/ad-images-galery.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <script src="../public/js/specifications.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <script src="../public/js/index.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <script src="../public/js/ad.js?v=<?php echo time(); ?>" type="text/javascript"></script>
</body>

</html>