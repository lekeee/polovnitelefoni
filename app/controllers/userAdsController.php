<?php
require_once "../classes/Phone.php";
require_once "../config/config.php";
include_once '../exceptions/adExceptions.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['action'])) {
        $phone = new Phone();
        if ($data['action'] === 'getUserAds') {
            $userID = $data['userID'];
            try {
                $ads = $phone->returnUserAds("oglasi", $userID);
                $deletedAds = $phone->returnUserAds("obrisani_oglasi", $userID);
                if ($ads !== NULL) {
                    $res = array();
                    foreach (json_decode($ads, true) as $ad) {
                        $putanja = getMainImagePath($ad);
                        $resx = showListWidget($ad, $putanja);
                        array_push($res, $resx);
                    }
                    $response = array(
                        'status' => 'success',
                        'message' => $res,
                        'numbers' => count(json_decode($ads, true)),
                        'deletedAds' => count(json_decode($deletedAds, true))
                    );
                } else {
                    $response = array(
                        'status' => 'empty',
                        'message' => "Korisnik nema oglase"
                    );
                }
            } catch (Exception $ex) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Došlo je do greške prilikom prihvatanja korisnikovih oglasa'
                );
            }
        } else if ($data['action'] === 'getBrandsData') {
            $userID = $data['userID'];
            try {
                $brands = $phone->brandsPrecentage($userID);
                if ($brands !== NULL) {
                    $response = array(
                        'status' => 'success',
                        'message' => $brands
                    );
                } else {
                    $response = array(
                        'status' => 'empty',
                        'message' => "Korisnik nema oglase"
                    );
                }
            } catch (Exception $ex) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Došlo je do greške prilikom prihvatanja korisnikovih oglasa'
                );
            }
        }
    }
}

echo json_encode($response);


function getMainImagePath($ad)
{
    $folderPath = "../../uploads/" . $ad['images'];
    $putanja = '../public/src/noimage-icon.svg';
    $imagesCounter = 0;
    if (is_dir($folderPath)) {
        $files = array_diff(scandir($folderPath), array('..', '.'));
        foreach ($files as $file) {
            $imagesCounter++;
            $fileNameWithoutExtension = pathinfo($file, PATHINFO_FILENAME);
            if (strtolower($fileNameWithoutExtension) === 'mainimage') {
                $putanja = "../uploads/" . $ad['images'] . '/' . $file;
                return $putanja;
            }
        }
    }
}


function showListWidget($ad, $putanja)
{
    $result = "";
    ob_start();
    ?>
    <div class="user-widget">
        <img src="<?php echo $putanja ?>" alt="" class="widget-image">
        <div class="widget-info-container">
            <a href="../views/ad.php?ad_id=<?php echo $ad['ad_id'] ?>">
                <?php
                if (strlen($ad['title']) > 40) {
                    echo substr($ad['title'], 0, 40) . '...';
                } else {
                    echo $ad['title'];
                }
                ?>
            </a>
            <div class="stars-and-rate">
                <?php
                if ($ad['state'] == 1) {
                    ?>
                    <img src="../public/src/start-rating5.png" style="width: 100px">
                    <?php
                } else {
                    if ($ad['stateRange'] < 2) {
                        ?>
                        <img src="../public/src/start-rating1.png" style="width: 100px">
                        <?php
                    } else if ($ad['stateRange'] < 4) {
                        ?>
                            <img src="../public/src/start-rating2.png" style="width: 100px">
                        <?php
                    } else if ($ad['stateRange'] < 6) {
                        ?>
                                <img src="../public/src/start-rating3.png" style="width: 100px">
                        <?php
                    } else if ($ad['stateRange'] < 8) {
                        ?>
                                    <img src="../public/src/start-rating4.png" style="width: 100px">
                        <?php
                    } else {
                        ?>
                                    <img src="../public/src/start-rating5.png" style="width: 100px">
                        <?php
                    }
                    ?>
                    <p>
                        <?php echo $ad['stateRange'] ?>/10
                    </p>
                    <?php
                }
                ?>
            </div>
            <div class="old-and-new-price">
                <?php
                if ($ad['old_price'] !== NULL) {
                    ?>
                    <p class="old-price">
                        <?php echo $ad['old_price'] . '€' ?>
                    </p>
                    <?php
                }
                if ($ad['price'] !== NULL) {
                    ?>
                    <p class="new-price">
                        <?php echo $ad['price'] . '€' ?>
                    </p>
                    <?php
                } else {
                    ?>
                    <p class="new-price">Dogovor</p>
                    <?php
                }
                ?>

            </div>
            <div class="description">
                <?php
                $opis = strip_tags($ad['description']);
                if (strlen($opis) > 80) {
                    ?>
                    <p>
                        <?php
                        $x = substr($opis, 0, 80) . '...';
                        echo $x ?>
                    </p>
                    <?php
                } else {
                    ?>
                    <p>
                        <?php echo $opis ?>
                    </p>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="action-container">
            <div class="action-compare-container">
                <div class="content-container">
                    <img src="../public/src/compare-icon.svg" alt="">
                </div>
            </div>
            <div class="action-compare-container">
                <div class="content-container">
                    <img src="../public/src/love-icon.svg" alt="">
                </div>
            </div>
        </div>
    </div>
    <?php
    $result .= ob_get_clean();
    return $result;
}