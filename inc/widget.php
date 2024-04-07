<?php
include_once("../app/classes/Phone.php");
require_once "../app/config/config.php";
include_once("../app/classes/User.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $ads = $data['ads'];
    $adsConverted = json_decode($ads, true);
    echo showWidget($adsConverted);
}

function showWidget($ads)
{
    $phone = new Phone();
    $user = new User();
    $result = "";

    for ($i = 0; $i < count($ads); $i++) {
        $views = $ads[$i]['views'];
        $saves = $phone->countSaves($ads[$i]['ad_id']);
        $ownerData = json_decode($user->getUserDataFromId($ads[$i]['user_id']), true);


        $folderPath = "../uploads/" . $ads[$i]['images'];
        $putanja = '../public/src/noimage-icon.svg';
        $imagesCounter = 0;
        if (is_dir($folderPath)) {
            $files = array_diff(scandir($folderPath), array('..', '.'));
            foreach ($files as $file) {
                $imagesCounter++;
                $fileNameWithoutExtension = pathinfo($file, PATHINFO_FILENAME);
                if (strtolower($fileNameWithoutExtension) === 'mainimage') {
                    $putanja = "../uploads/" . $ads[$i]['images'] . '/' . $file;
                    break;
                }
            }
        }
        ob_start();
        ?>
        <div data-w-id="e63ee92c-45eb-6251-f08f-7749d59a348c" class="widgetcontainer gold">
            <div class="mainwidgetcontainer">
                <div class="widgetimagescontainer" bg-image="<?php echo $putanja; ?>"
                    style="display: flex; flex-direction: row; justify-content: space-between; backgroundImage='url(<?php echo $putanja; ?>)'">
                    <?php
                    $folderPath = "../uploads/" . $ads[$i]['images'];
                    $imagesCounter = 0;
                    if (is_dir($folderPath)) {
                        $files = array_diff(scandir($folderPath), array('..', '.'));
                        foreach ($files as $file) {
                            $imagesCounter++;
                            ?>
                            <div class="hoverDetector" image-data="<?php echo "../uploads/" . $ads[$i]['images'] . '/' . $file; ?>"
                                image-indicator="<?php echo $imagesCounter - 1; ?>"></div>
                            <?php
                        }
                    }
                    ?>

                    <div class="addtocontainer">
                        <div class="addtosavedcontainer" style="padding: 5px" <?php
                        if ($user->isLogged()) {
                            ?>
                                onclick="checkIsSaved(event, this, <?php echo $user->getId() ?>, <?php echo $ads[$i]['ad_id'] ?>)" <?php
                        } else {
                            ?> onclick="checkIsSaved2(event)" <?php
                        }
                        ?>>
                            <?php if ($user->isLogged()) {
                                $myData = $user->mySaves(0, 1000);
                                $mySaves = null;
                                if ($myData !== null) {
                                    $mySaves = json_decode($user->mySaves(0, 1000), true);
                                }
                                $savedAdsIds = [];
                                if ($mySaves !== null) {
                                    $savedAdsIds = array_column($mySaves, 'ad_id');
                                }

                                $exist = in_array($ads[$i]['ad_id'], $savedAdsIds); ?>
                                <svg fill="<?php echo $exist ? "red" : "none" ?>" stroke="<?php echo $exist ? "red" : "black" ?>"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" height="24">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                </svg>
                            <?php } else { ?>
                                <svg fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                </svg>
                            <?php } ?>
                        </div>
                        <?php
                        if ($ads[$i]["damage"] !== NULL) {
                            ?>
                            <div class="addtosavedcontainer" title="Oštećenje"
                                style="padding: 5px; margin-top: 5px; background-color: #ed6969; border-color: #ed6969; cursor: default">
                                <img src="../public/src/broken-phone.svg?v=<?php echo time(); ?>" alt="Broken Phone Icon"
                                    style="height: 100%" />
                            </div>
                        <?php } ?>

                        <!-- <div title="Premium oglas" class="premiumindicatorcontainer">
                        <img
                            src="../public/src/star-icon.svg" loading="lazy" alt="Star Icon"
                            style="width: 20px;" /></div> -->
                        <div data-w-id="47c839af-029e-d9bb-4594-b731a5f956f9" class="addtocomparecontainer"><img
                                src="../public/src/compare-icon.svg" loading="lazy" alt="Compare Icon" style="width: 20px;" />
                        </div>
                        <div data-w-id="3e330f58-2da6-4705-f661-2e6804eb87a4" class="quickviewicon"
                            onclick="openQuickView(this)" main-image="<?php echo $putanja ?>" ad-id="<?php echo $ads[$i]['ad_id'] ?>"
                            ad-title="<?php echo $ads[$i]['title'] ?>" brand="<?php echo $ads[$i]['brand'] ?>"
                            model="<?php echo $ads[$i]['model'] ?>" state="<?php echo $ads[$i]['state'] ?>"
                            rate="<?php echo $ads[$i]['stateRange'] ?>" visitors="<?php echo $views ?>"
                            saves="<?php echo $saves ?>" damage="<?php echo $ads[$i]['damage'] ?>"
                            accessories="<?php echo $ads[$i]['accessories'] ?>" price="<?php echo $ads[$i]['price'] ?>"
                            old-price="<?php echo $ads[$i]['old_price'] ?>" name="<?php echo $ownerData['name'] ?>"
                            lastname="<?php echo $ownerData['lastname'] ?>" city="<?php echo $ownerData['city'] ?>"
                            address="<?php echo $ownerData['address'] ?>" phone="<?php echo $ownerData['phone'] ?>"
                            owner-id="<?php echo $ownerData['user_id'] ?>">
                            <img src="../public/src/eye-icon.svg" loading="lazy" alt="Quick View Icon" style="width: 20px;" />
                        </div>
                    </div>
                    <div class="saleandstate">
                        <?php
                        if ($ads[$i]["damage"] !== NULL) {
                            ?>
                            <!-- <div class="brokenindicator" style="display: block">
                    <img src="../public/src/broken-phone-badge-ed6969.svg" loading="lazy" alt="Broken Phone Icon"
                        class="brokenimageindicator" />
                </div> -->
                        <?php } ?>
                        <div class="salecontainer">
                            <div class="salelabel">9%</div>
                        </div>
                        <?php
                        if ($ads[$i]["state"] == 1) {
                            ?>
                            <div class="oldornewproductcontainer newstate" style="display: block">
                                <div class="newproductlabel">Novo</div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="oldornewproductcontainer oldstate" style="display: block">
                                <div class="newproductlabel oldstate">
                                    <?php echo $ads[$i]['stateRange'] ?> /
                                    10
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="imagesindicatorcontainer">
                        <?php
                        for ($j = 0; $j < $imagesCounter; $j++) {
                            ?>
                            <div class="imageindicatior <?php if ($j === 0)
                                echo 'active' ?>"></div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="widget-description-container">
                    <div class="phonebrandadnmodelanduser">
                        <div class="brandandmodeltitle" style="text-transform: uppercase">
                            <?php
                            echo $ads[$i]["brand"] . ' ' . $ads[$i]['model'];
                            ?>
                        </div>
                    </div>
                    <div class="widgettitlecontainer" style="height: 41.82px; overflow: hidden;">
                        <a href="./ad.php?ad_id=<?php echo $ads[$i]['ad_id'] ?>" class="link">
                            <?php
                            if (strlen($ads[$i]['title']) > 60) {
                                $shortened_string = substr($ads[$i]['title'], 0, 60);
                                echo $shortened_string;
                            } else {
                                $padded_string = str_pad($ads[$i]['title'], 60);
                                echo $padded_string;
                            }
                            ?>
                        </a>
                    </div>
                    <div class="viewsadnsavescontainer">
                        <div class="viewscontainer">
                            <div class="viewslabel">
                                <?php
                                if ($views !== NULL) {
                                    if ($views >= 1000 && $views < 1000000) {
                                        echo number_format($views / 1000, 1) . 'k';
                                    } else {
                                        echo $views;
                                    }
                                } else {
                                    echo 0;
                                }
                                ?>

                            </div><img src="../public/src/eye-icon.svg" loading="lazy" alt="Views Icon" class="viewsicon" />
                        </div>
                        <div class="savescontainer">
                            <div class="saveslabel">
                                <?php
                                if ($saves !== NULL) {
                                    echo $saves;
                                } else {
                                    echo 0;
                                }
                                ?>

                            </div><img src="../public/src/love-icon.svg?v=<?php echo time() ?>" loading="lazy" alt="Heart Icon" class="savesicon" />
                        </div>
                    </div>
                    <div class="pricecontainer">
                        <div class="oldandnewprice">
                            <div class="oldpricelabel">
                                <strong class="bold-text-66">
                                    <?php
                                    if ($ads[$i]['old_price'] !== NULL) {
                                        echo '€' . $ads[$i]['old_price'];
                                    }
                                    ?>
                                </strong>
                            </div>
                            <div class="currentpricelabel">
                                <strong class="bold-text-7">
                                    <?php
                                    if ($ads[$i]['price'] !== NULL) {
                                        echo '€' . $ads[$i]['price'];
                                    } else {
                                        echo "Dogovor";
                                    }
                                    ?>
                                </strong>
                            </div>
                            <div class="formobile">
                                <strong class="bold-text-66">
                                    <?php
                                    if ($ads[$i]['old_price'] !== NULL) {
                                        echo $ads[$i]['old_price'];
                                    }
                                    ?>
                                </strong>
                            </div>
                        </div>
                        <div class="callcontainere callcontainer"><img src="../public/src/phone-call.svg" loading="lazy"
                                alt="Send Message Icon" class="callicon" /></div>
                    </div>
                    <div class="userdataandbroken">
                        <div class="citycontainer" style="margin-top: 20px">
                            <div class="usernamelabel" style="font-size: 16px;">
                                <?php
                                echo $ownerData['username'];
                                ?>
                            </div>
                            <div class="citylabel" style="font-size: 16px; margin-top: 5px">
                                <?php
                                echo $ownerData['city']
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolutedescriptionconteiner">
                <div class="descriptioncontainer">
                    <div class="descriptionlabel">
                        <?php
                        if ($ads[$i]['description'] !== NULL) {
                            $cleaned_text = strip_tags($ads[$i]['description']);
                            if (strlen($cleaned_text) > 60) {
                                $shortened_string2 = substr($cleaned_text, 0, 57);
                                echo $shortened_string2 . '... <a href="./ad.php?ad_id=' . $ads[$i]['ad_id'] . '" style="color: #ed6969; margin-left: 5px;">Pročitaj još</a>';
                            } else {
                                echo $ads[$i]['description'];
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $result .= ob_get_clean();
    }

    return json_encode($result);
}
?>