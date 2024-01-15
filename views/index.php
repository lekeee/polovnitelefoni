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

    <?php
    $phone = new Phone();
    $ads = json_decode($phone->select24(), true);
    ?>

    <link href="../public/css/index.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <section class="mainpageselection">
        <div class="mainpagediv">
            <div class="darkbackground"></div>
            <div class="darkbackground2">
                <div class="quickviewcontainer">
                    <div class="quickviewmaincontainer">
                        <div class="quickclosecont">
                            <div data-w-id="3f23a2f6-5da1-b2b6-03b3-6f1d670aeb62" class="quickviewclosecontainer"
                                onclick="closeQuickView()"><img src="../public/src/close-icon.svg" loading="lazy"
                                    alt="Close Icon" class="closequickviewicon" /></div>
                        </div>
                        <div class="quickviewmaindatacontainer">
                            <div class="imagescontainerquickview" style="padding: 20px; padding-right: 10px;">
                                <div style="width: 100%">
                                    <div style="width: 100%;border: 1px solid #ddd;display: flex; justify-content: center; align-items: center;"
                                        class="quick-view-image-container">
                                        <div class="slider-container"
                                            style="position: relative; width: 100%; height: 100%">
                                            <div class="slider" style="width: 100%; height: 100%">
                                                <div class="slides" style="width: 100%; height: 100%">
                                                    <div
                                                        style="display: block; width: 100%; height: 100%; padding: 20px">
                                                        <a href="#" class="lightbox-link w-lightbox">
                                                            <img src="" alt="Main Image" class="image-41"
                                                                id="quick-view-image">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="datacontainerquickview" style="padding: 20px; padding-right: 10px;">
                                <h1 class="heading-6" id="quick-view-title">
                                </h1>
                                <div class="div-block-718" style="margin-top: 20px;">
                                    <div class="div-block-717" style="justify-content: space-around;">
                                        <div class="div-block-693">
                                            <div class="text-block-46 newmodel">Brend:</div>
                                            <a href="#" class="link-2" id='quick-view-brand'>
                                            </a>
                                            <div class="text-block-46">|</div>
                                            <div class="text-block-46 newmodel">Model:</div>
                                            <a href="#" class="link-3" id="quick-view-model">
                                            </a>
                                        </div>
                                        <div class="div-block-695">
                                            <div class="div-block-734">
                                                <img src="#" loading="lazy"
                                                    data-w-id="7be535bf-1c91-1e9c-1d34-3ebf71a74e93"
                                                    sizes="(max-width: 479px) 100vw, (max-width: 767px) 23vw, 120px"
                                                    alt="Star Rating of 5" class="image-30" id="quick-view-rate" />
                                            </div>
                                            <div style="display: inline-block">
                                                <div class="div-block-696">
                                                    <div class="text-block-47">
                                                        <p id="quick-view-visitors"></p>
                                                        <img src="../public/src/eye-icon.svg" alt="Eye" srcset="">
                                                    </div>
                                                </div>

                                                <div class="div-block-696">
                                                    <div class="text-block-47">
                                                        <p id="quick-view-saves"></p>
                                                        <img src="../public/src/favourite_icon.png" alt="Eye" srcset=""
                                                            style="width: 20px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="div-block-700">
                                            <div class="div-block-697"><img src="../public/src/done-icon.png"
                                                    loading="lazy" alt="Available" class="image-31" />
                                                <div class="text-block-48">
                                                    Na stanju
                                                </div>
                                            </div>
                                            <div class="div-block-699" id="quick-view-damage">
                                                <div class="text-block-49">OŠTEĆENJE</div>
                                            </div>
                                        </div>
                                        <div class="div-block-701">
                                            <h2 class="heading-8" id="quick-view-price" style="font-size: 40px">
                                            </h2>
                                            <h2 class="heading-9" id="quick-view-old-price">
                                            </h2>
                                        </div>
                                    </div>
                                    <div data-w-id="0eacc543-0b81-e5be-a1e1-d7c3709a619c" class="div-block-719"><img
                                            src="../public/src/userShow.png" loading="lazy" alt="User Profile Image"
                                            class="image-39" />
                                        <h1 class="heading-10" id="quick-view-user" style="text-align: center;">
                                        </h1>
                                        <div class="text-block-57" id="quick-view-city" style="text-align: center;">
                                        </div>
                                        <div class="text-block-60" id="quick-view-address" style="text-align: center;">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="div-block-702" style="margin-top: 20px">
                                        <div class="div-block-703">
                                            <div class="div-block-720">
                                                <div class="div-block-712">
                                                    <div class="div-block-714">
                                                        <div class="text-block-56" id="quick-view-phone">
                                                        </div>
                                                        <div class="div-block-704">
                                                            <div class="div-block-716"><img
                                                                    src="../public/src/message-icon.png" loading="lazy"
                                                                    alt="Message" class="image-32 messagebtn" />
                                                                <div class="text-block-50">Kontaktiraj vlasnika</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div data-w-id="3a24efa4-af9d-9de5-42c6-e9ec9ee2e77d"
                                                        class="div-block-713">
                                                        <img src="../public/src/call-icon.png" loading="lazy"
                                                            alt="Call User" class="image-37" />
                                                    </div>
                                                    <div data-w-id="6938d356-7183-26a9-3423-51e3d414b225"
                                                        class="div-block-715">
                                                        <img src="../public/src/close_icon.png" loading="lazy"
                                                            alt="Close Icon" class="image-38" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="div-block-721">
                                                <div class="div-block-705"><img src="../public/src/heart-grey.png"
                                                        loading="lazy" width="20" alt="Favourite" />
                                                    <div class="text-block-51">Sačuvaj oglas</div>
                                                </div>
                                            </div>
                                            <div class="div-block-722">
                                                <div class="div-block-705"><img src="../public/src/compare.png"
                                                        loading="lazy" alt="Compare" class="image-33" />
                                                    <div class="text-block-51">Uporedi</div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="div-block-706"><img src="../public/src/delivery.png" loading="lazy"
                                            alt="Delivery" class="image-34" />
                                        <div class="text-block-52">Način isporuke u dogovoru sa vlasnikom</div>
                                    </div>
                                </div>
                                <div class="div-block-707" style="margin-top: 20px">
                                    <img src="../public/src/bag-orange.png" loading="lazy" alt="Bag Icon"
                                        class="image-40" />
                                    <div>
                                        <div class="text-block-53">Drugi ljudi žele ovaj proizvod. </div>
                                        <div class="text-block-54" id="quick-view-saves-count">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shopandsavecontainer">
                <div class="shopandsaveleftcontainertext">
                    <h1 class="shopandsavetext">Kupujte i</h1>
                    <div class="shopandsaveleftcontainerspandiv">
                        <div class="shopandsaveleftspantext">Uštedite na</div>
                    </div>
                    <h1 class="shopandsavetext">Proizvodima</h1>
                </div>
                <div class="shopandsaverightcontainer">
                    <div class="startfrompricecontainer">
                        <div class="startfromonlyprice">
                            <div class="startfromprice">počev od</div>
                            <div class="startfrompricetext"><strong class="bold-text">€79.00</strong></div>
                        </div>
                        <div class="startfromdesccontainer">
                            <div class="startfromdesctext">Ne propustite ovu specijalnu priliku danas</div>
                        </div>
                    </div><a href="#" class="button shopnowbutton w-button">Kupi odmah</a>
                </div>
            </div>
            <div class="threeinrowcontainers">
                <div class="mostvisitedcontainer">
                    <?php
                    try {
                        $mostViewedAdData = $phone->mostViewedAd();
                        $mostViewedAd = NULL;
                        if ($mostViewedAdData !== NULL) {
                            $mostViewedAd = json_decode($mostViewedAdData, true);
                            //print_r($mostViewedAd);
                        }
                    } catch (Exception $e) {
                        echo "GRESKA";
                    }
                    ?>
                    <div class="mostvisitedleft">
                        <div class="mostviewedbrandmodelcont">

                            <div class="mostviewedheadtitle">
                                Najposećeniji oglas
                            </div>
                            <h1 class="mostviewedmodelandbrandtitle">
                                <?php
                                if ($mostViewedAd !== NULL) {
                                    echo $mostViewedAd['title'];
                                }
                                ?>
                            </h1>
                        </div>
                        <div class="mostviewedpricecontainer">
                            <div class="mostviewedpricetitle">
                                <?php
                                if ($mostViewedAd !== NULL) {
                                    $ownerID = $mostViewedAd['user_id'];
                                    $userData = $user->getUserDataFromId($ownerID);
                                    $userDataDecoded = json_decode($userData, true);
                                    echo $userDataDecoded['name'] . ' ' . $userDataDecoded['lastname'];
                                }
                                ?>
                            </div>
                            <div class="priceviewcontainer">
                                <div class="priceviewmainprice">
                                    <strong class="bold-text-2">
                                        <?php
                                        if ($mostViewedAd !== NULL) {
                                            echo $mostViewedAd['price'] !== NULL ? '€' . $mostViewedAd['price'] : 'Dogovor';
                                        }
                                        ?>
                                    </strong>
                                </div>
                                <div class="priceviewoldprice">
                                    <strong class="bold-text-3">
                                        <?php
                                        if ($mostViewedAd !== NULL && $mostViewedAd['old_price'] !== NULL) {
                                            echo '€' . $mostViewedAd['old_price'];
                                        }
                                        ?>
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mostvisitedright"><img
                            src="https://assets-global.website-files.com/65830899613e5c9e21ea6f21/65835b32664720bce6668a45_iPhone15ProMax-modified.png"
                            loading="lazy"
                            sizes="(max-width: 479px) 42vw, (max-width: 767px) 187.06597900390625px, (max-width: 991px) 24vw, (max-width: 1279px) 13vw, 178.3854217529297px"
                            srcset="https://assets-global.website-files.com/65830899613e5c9e21ea6f21/65835b32664720bce6668a45_iPhone15ProMax-modified-p-500.png 500w, https://assets-global.website-files.com/65830899613e5c9e21ea6f21/65835b32664720bce6668a45_iPhone15ProMax-modified.png 608w"
                            alt="iPhone 15 Pro Max" class="mostvisitedrightimage" /></div>
                </div>
                <div class="mostsavedcontainer">
                    <?php
                    try {
                        $mostSavedAdData = $phone->mostSavedAd();
                        $mostSavedAd = NULL;
                        if ($mostSavedAdData !== NULL) {
                            $mostSavedAd = json_decode($mostSavedAdData, true);
                            //print_r($mostViewedAd);
                        }
                    } catch (Exception $e) {
                        echo "GRESKA";
                    }
                    ?>
                    <div class="mostvisitedleft">
                        <div class="mostsavedheadcontainer">
                            <div class="mostsavedheadtitle">
                                Najsačuvaniji oglas
                            </div>
                            <h1 class="mostviewedmodelandbrandtitle">
                                <?php
                                if ($mostSavedAd !== NULL) {
                                    echo $mostSavedAd['title'];
                                }
                                ?>
                            </h1>
                        </div>
                        <div class="mostsavedpricecontainer">
                            <div class="mostviewedpricetitle">
                                <?php
                                if ($mostSavedAd !== NULL) {
                                    $ownerID = $mostSavedAd['user_id'];
                                    $userData = $user->getUserDataFromId($ownerID);
                                    $userDataDecoded = json_decode($userData, true);
                                    echo $userDataDecoded['name'] . ' ' . $userDataDecoded['lastname'];
                                }
                                ?>
                            </div>
                            <div class="priceviewcontainer">
                                <div class="priceviewmainprice">
                                    <strong class="bold-text-2">
                                        <?php
                                        if ($mostSavedAd !== NULL) {
                                            echo $mostSavedAd['price'] !== NULL ? '€' . $mostSavedAd['price'] : 'Dogovor';
                                        }
                                        ?>
                                    </strong>
                                </div>
                                <div class="priceviewoldprice">
                                    <strong class="bold-text-3">
                                        <?php
                                        if ($mostSavedAd !== NULL && $mostSavedAd['old_price'] !== NULL) {
                                            echo '€' . $mostSavedAd['old_price'];
                                        }
                                        ?>
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mostvisitedright"><img
                            src="https://assets-global.website-files.com/65830899613e5c9e21ea6f21/65835bea3d2703d29296b84a_samsung-galaxy-s22-5g-bora-purple-modified.png"
                            loading="lazy" alt="Samsung Galaxy S22" class="mostvisitedrightimage" /></div>
                </div>
                <div class="newestcontainer">
                    <?php
                    try {
                        $newestAdData = $phone->newestAd();
                        $newestAd = NULL;
                        if ($newestAdData !== NULL) {
                            $newestAd = json_decode($newestAdData, true);
                            //print_r($mostViewedAd);
                        }
                    } catch (Exception $e) {
                        echo "GRESKA";
                    }
                    ?>
                    <div class="mostvisitedleft">
                        <div class="newestheadcontainer">
                            <div class="newestheadtitle">Najnoviji oglas</div>
                            <h1 class="mostviewedmodelandbrandtitle">
                                <?php
                                if ($newestAd !== NULL) {
                                    echo $newestAd['title'];
                                }
                                ?>
                            </h1>
                        </div>
                        <div class="newestpricecontainer">
                            <div class="mostviewedpricetitle">
                                <?php
                                if ($newestAd !== NULL) {
                                    $ownerID = $newestAd['user_id'];
                                    $userData = $user->getUserDataFromId($ownerID);
                                    $userDataDecoded = json_decode($userData, true);
                                    echo $userDataDecoded['name'] . ' ' . $userDataDecoded['lastname'];
                                }
                                ?>
                            </div>
                            <div class="priceviewcontainer">
                                <div class="priceviewmainprice">
                                    <strong class="bold-text-2">
                                        <?php
                                        if ($newestAd !== NULL) {
                                            echo $newestAd['price'] !== NULL ? '€' . $newestAd['price'] : 'Dogovor';
                                        }
                                        ?>
                                    </strong>
                                </div>
                                <div class="priceviewoldprice">
                                    <strong class="bold-text-3">
                                        <?php
                                        if ($newestAd !== NULL && $newestAd['old_price'] !== NULL) {
                                            echo '€' . $newestAd['old_price'];
                                        }
                                        ?>
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mostvisitedright"><img
                            src="https://assets-global.website-files.com/65830899613e5c9e21ea6f21/65835d1a2168277e395a7e95_RedmiNote13Pro.png"
                            loading="lazy"
                            sizes="(max-width: 479px) 42vw, (max-width: 767px) 158.36805725097656px, (max-width: 991px) 21vw, (max-width: 1279px) 118.78472900390625px, 158.36805725097656px"
                            srcset="https://assets-global.website-files.com/65830899613e5c9e21ea6f21/65835d1a2168277e395a7e95_RedmiNote13Pro-p-500.png 500w, https://assets-global.website-files.com/65830899613e5c9e21ea6f21/65835d1a2168277e395a7e95_RedmiNote13Pro.png 510w"
                            alt="Redmi Note 13 Pro" class="mostvisitedrightimage" /></div>
                </div>
            </div>
            <div class="currentpageindicator">
                <div class="pocetnalabel">Početna</div>
                <div class="separatorlabel">/</div>
                <div class="pocetnalabel blackones">Šop</div>
            </div>
            <div class="showindpropertzcontainer">
                <div data-w-id="74356a1c-d9dd-5682-428a-0e61ff5c9155" class="filtericoncontainer"
                    onclick="openFilters()"><img
                        src="https://assets-global.website-files.com/65830899613e5c9e21ea6f21/6585c71b4e111a123b652fb1_9044512_filter_icon.svg"
                        loading="lazy" width="20" alt="Filter Icon" class="filtericonslika" />
                    <div class="filtertitle">Filtriraj proizvode</div>
                </div>
                <div class="showingcountercontainer">
                    <div class="showingtitle">Prikazuje se svih
                        <?php echo count($ads) ?> rezultata
                    </div>
                </div>
                <div class="sortingcontainer">
                    <div class="sortingform w-form">
                        <form id="sorting-form" name="sorting-form" data-name="Sorting Form" method="get"
                            class="sortingforma" data-wf-page-id="65830899613e5c9e21ea6f3d"
                            data-wf-element-id="646e3d9e-b677-b897-f157-8f2582673ac0">
                            <select id="sorting" name="sorting" data-name="sorting" class="adssorting w-select">
                                <option value="0">Sortiraj po: popularnosti</option>
                                <option value="1">Sortiraj po: prvo najnoviji</option>
                                <option value="2">Sortiraj po ceni: prvo najjeftinije</option>
                                <option value="3">Sortiraj po ceni: prvo najskuplje</option>
                            </select>
                            <div class="sortingseparator"></div>
                            <div class="sortingshowtitle">Prikazuj: </div><select id="showCount" name="showCount"
                                data-name="showCount" class="adsshowing w-select">
                                <option value="1">16 oglasa</option>
                                <option value="2">32 oglasa</option>
                                <option value="3">48 oglasa</option>
                                <option value="4">64 oglasa</option>
                            </select>
                            <div class="sortingseparator"></div><img
                                src="../public/src/grid-icon.svg?v=<?php echo time() ?>" alt="GridView Icon"
                                class="gridviewicon" /><img src="../public/src/list-icon.svg?v=<?php echo time(); ?>"
                                width="22" alt="List View Icon" class="listviewicon" />
                        </form>
                        <div class="w-form-done"></div>
                        <div class="w-form-fail"></div>
                    </div>
                </div>
            </div>
            <div class="filtersandproductscontainer">
                <div class="filterleftmaincontainer">
                    <div class="closefiltercontainer" onclick="closeFilters()"><img src="../public/src/close-icon.svg"
                            loading="lazy" data-w-id="946eb081-061a-dfbf-c305-7bd716350914" alt="Close Icon"
                            class="closeicon" /></div>
                    <div class="filterleftcontainer">
                        <div class="brandtitlecontainer">
                            <h2 class="brandmodeltitle">Brend i model uređaja</h2>
                        </div>
                        <div class="brandsandmodelscontainer">
                            <div class="brandmodelform w-form">
                                <form id="brandModelForm" name="email-form-2" data-name="Email Form 2" method="get"
                                    class="brandmodelforma" data-wf-page-id="65830899613e5c9e21ea6f3d"
                                    data-wf-element-id="76941605-2b56-9887-edca-674a10bd80eb">

                                    <?php
                                    $jsonContent = file_get_contents('../public/JSON/sortedData.json');
                                    $dataJSON = json_decode($jsonContent, true);


                                    if (json_last_error() !== JSON_ERROR_NONE) {
                                        die('Greška pri čitanju JSON datoteke.');
                                    }

                                    foreach ($dataJSON as $brand) {
                                        if (!empty($brand["device_list"])) {
                                            echo "
                                                    <div class='custom-dropdown-menu'>
                                                        <div class='dropdown-click-toggler'>
                                                            <div class='custom-checkbox-group'>
                                                                <input type='checkbox' id='{$brand['key']}Checkbox' class='custom-brand-checkbox' data-target='{$brand['key']}Dropdown'>
                                                                <label for='{$brand['key']}Checkbox'>{$brand['brand_name']}</label>
                                                            </div>
                                                            <label class='openDropDown'>+</label>
                                                        </div>";

                                            echo "
                                                        <div class='custom-dropdown' id='{$brand['key']}Dropdown'>";
                                            foreach ($brand['device_list'] as $model) {
                                                if (stripos($model['device_name'], "watch") === false) {
                                                    echo "
                                                                <div class='custom-dropdown-item' brand-selector={$brand['brand_name']}>
                                                                    <input type='checkbox' id='{$model['device_name']}Checkbox'>
                                                                    <label for='{$model['device_name']}Checkbox'>{$model['device_name']}</label>
                                                                </div>
                                                            ";
                                                }
                                            }
                                            echo "</div></div>";
                                        }
                                    }
                                    ?>

                                </form>
                                <div class="w-form-done"></div>
                                <div class="w-form-fail"></div>
                            </div>
                        </div>
                        <div class="pricefiltercontainer">
                            <h2 class="pricefiltertitle">Filtriraj po ceni</h2>
                            <div class="pricefiltercontainer">

                                <div class="priceslidercontainer">
                                    <div class="sliderneeded" style="padding-right: 20px; padding-bottom: 30px">
                                        <div class="price-input">
                                            <div class="field">
                                                <span>Min</span>
                                                <input type="number" class="input-min" value="0">
                                            </div>
                                            <div class="separator">-</div>
                                            <div class="field">
                                                <span>Max</span>
                                                <input type="number" class="input-max" value="2500">
                                            </div>
                                        </div>
                                        <div class="slider" style="background-color: #ddd">
                                            <div class="progress"></div>
                                        </div>
                                        <div class="range-input">
                                            <input type="range" class="range-min" min="0" max="2500" value="0"
                                                step="50">
                                            <input type="range" class="range-max" min="0" max="2500" value="2500"
                                                step="50">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="statecontainer">
                            <div class="statetextcontainer">
                                <h2 class="pricefiltertitle">Stanje uređaja</h2>
                            </div>
                            <div class="stateform w-form">
                                <form id="email-form-4" name="email-form-4" data-name="Email Form 4" method="get"
                                    class="stateforma" data-wf-page-id="65830899613e5c9e21ea6f3d"
                                    data-wf-element-id="8681febf-e878-6f79-a7fa-914c627cee0f">
                                    <div class="statechecklboxcontainer"><label
                                            class="w-checkbox statedevicecheckbox"><input type="checkbox" id="oldState"
                                                name="oldState" data-name="old State"
                                                class="w-checkbox-input statecheckbox" /><span
                                                class="statecheckboxlabel w-form-label" for="oldState">Polovan
                                                uređaj</span></label><label
                                            class="w-checkbox statedevicecheckbox"><input type="checkbox" id="newState"
                                                name="newState" data-name="new State"
                                                class="w-checkbox-input statecheckbox" /><span
                                                class="statecheckboxlabel w-form-label" for="newState">Novi
                                                uređaj</span></label><label
                                            class="w-checkbox statedevicecheckbox"><input type="checkbox"
                                                id="damagedState" name="damagedState" data-name="damaged State"
                                                class="w-checkbox-input statecheckbox" /><span
                                                class="statecheckboxlabel w-form-label" for="damagedState">Oštećen
                                                uređaj</span></label></div>
                                </form>
                                <div class="w-form-done"></div>
                                <div class="w-form-fail"></div>
                            </div>
                        </div>
                        <div class="submitfilterscontainer">
                            <a href="#" class="filterbutton w-button" id="sumbitFilters">Primeni filtere</a>
                            <a href="#" class="filterbutton removefilters w-button" id="resetFilters">Resetuj
                                filtere</a>
                        </div>
                    </div>
                </div>
                <div class="productscontainer">
                    <div class="filterstlabela"></div>
                    <div class="productsmaincontainer"></div>
                    <div class="loadmorecontainer">
                        <a href="#" current-page="0" class="loadmorebutton w-button" onclick="loadMore(this)">Učitaj
                            još</a>
                    </div>
                </div>
            </div>
            <div class="recentlyviewedcontainer">
                <div class="recentlytextconatainer">
                    <h3 class="receantlylabel">Poslednje pogledani oglasi</h3>
                </div>
                <div class="recentlymaincontainer">
                </div>
            </div>
        </div>
    </section>

    <?php
    require_once "../inc/subscribeForm.php";
    require_once "../inc/footer.php";
    ?>

    <script src="../public/js-public/jquery.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <script src="../public/js/login-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <script src="../public/js/index.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <script src="../public/js/filter-range-slider.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <script src="../public/js/index-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <script src="../public/js/filters.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <script src="../public/js/ad-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>
</body>

</html>