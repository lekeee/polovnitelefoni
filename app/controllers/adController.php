<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);



require_once "../classes/User.php";
require_once "../config/config.php";
require_once "../classes/Phone.php";
include_once '../exceptions/userExceptions.php';
require_once '../../vendor/autoload.php';

use Symfony\Component\Cache\Adapter\FilesystemAdapter;

$user = new User();
$cache = new FilesystemAdapter();
$phoneAds = new Phone();
$limit = 4;

function addToFavourite($data, $phoneAds)
{
    if (isset($data['user_id']) && isset($data['ad_id'])) {
        try {
            $user_id = $data['user_id'];
            $ad_id = $data['ad_id'];
            $result = $phoneAds->save($user_id, $ad_id);
            if ($result === true) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Uspešno ste sačuvali oglas u listu sačuvanih oglasa'
                );
            } else if ($result === false) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Došlo je do greške prilikom dodavanja oglasa u listu sačuvanih oglasa'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => $result
                );
            }

        } catch (Exception $e) {
            $response = array(
                'status' => 'error',
                'message' => 'Došlo je do greške prilikom dodavanja oglasa u listu sačuvanih oglasa'
            );
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Došlo je do greške prilikom dodavanja oglasa u listu sačuvanih oglasa'
        );
    }
    return $response;
}

function removeFromFavourite($data, $phoneAds)
{
    if (isset($data['user_id']) && isset($data['ad_id'])) {
        try {
            $user_id = $data['user_id'];
            $ad_id = $data['ad_id'];
            $result = $phoneAds->deleteSave($user_id, $ad_id);
            if ($result === true) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Uspešno ste obrisali oglas iz listu sačuvanih oglasa'
                );
            } else if ($result === false) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Došlo je do greške prilikom brisanja oglasa iz listu sačuvanih oglasa'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => $result
                );
            }

        } catch (Exception $e) {
            $response = array(
                'status' => 'error',
                'message' => 'Došlo je do greške prilikom brisanja oglasa iz listu sačuvanih oglasa'
            );
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Došlo je do greške prilikom brisanja oglasa iz listu sačuvanih oglasa'
        );
    }
    return $response;
}

function checkIsFavourite($data, $user)
{
    if (isset($data['user_id']) && isset($data['ad_id'])) {
        try {
            $user_id = $data['user_id'];
            $ad_id = $data['ad_id'];

            $myData = $user->mySaves();
            $mySaves = null;
            if ($myData !== null) {
                $mySaves = json_decode($user->mySaves(), true);
            }
            $savedAdsIds = [];
            if ($mySaves !== null) {
                $savedAdsIds = array_column($mySaves, 'ad_id');
            }
            $exist = in_array($ad_id, $savedAdsIds);

            if ($exist) {
                $response = array(
                    'status' => 'exist',
                    'message' => 'exist message'
                );
            } else {
                $response = array(
                    'status' => 'not-exist',
                    'message' => 'not-exist'
                );
            }
        } catch (Exception $e) {
            $response = array(
                'status' => 'error',
                'message' => 'Došlo je do greške prilikom brisanja oglasa iz listu sačuvanih oglasa'
            );
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Došlo je do greške prilikom brisanja oglasa iz listu sačuvanih oglasa'
        );
    }
    return $response;
}

function compareModels($a, $b)
{
    return strcmp($a['model'], $b['model']);
}

function getAds($phoneAds)
{
    $sort = $_GET['sort'];
    $brandsSelected = $_GET['brandsSelected'];
    $modelsSelected = $_GET['modelsSelected'];
    $minPrice = $_GET['minPrice'];
    $maxPrice = $_GET['maxPrice'];
    $oldState = $_GET['oldState'];
    $newState = $_GET['newState'];
    $damagedState = $_GET['damagedState'];
    $limit = $_GET['limit'];
    $offset = $_GET['page'] * $limit;
    $deal = $_GET['deal'];

    $cache = new FilesystemAdapter();
    try {
        if ($brandsSelected == NULL && $modelsSelected == NULL) {
            $cacheItem = $cache->getItem('ads-' . $offset . '-' . $limit);
            $cachedValue = $cacheItem->get();
            if ($cachedValue === null) {
                $result = $phoneAds->filter($sort, $brandsSelected, $modelsSelected, $minPrice, $maxPrice, $newState, $oldState, $damagedState, $offset, $limit, $deal);
                $cacheItem->set($result)->expiresAfter(180);
                $cache->save($cacheItem);
            } else {
                $result = $cachedValue;
            }
        } else {
            $result = $phoneAds->filter($sort, $brandsSelected, $modelsSelected, $minPrice, $maxPrice, $newState, $oldState, $damagedState, $offset, $limit, $deal);
        }
        $response = array(
            'status' => 'success',
            'message' => $result
        );
    } catch (Exception $e) {
        $response = array(
            'status' => 'error',
            'message' => 'Došlo je do greške prilikom filtriranja oglasa'
        );
    }
    return $response;
}

function newAds($data, $user, $phoneAds)
{
    if (
        isset($data['title']) && isset($data['brand'])
        && isset($data['model']) && isset($data['deviceState'])
        && isset($data['stateRange']) && isset($data['images'])
        && isset($data['description']) && isset($data['deal'])
        && isset($data['price']) && isset($data['terms'])
    ) {

        $userID = $user->getId();

        if ($userID != null) {
            $title = $data['title'];
            $brand = $data['brand'];
            $model = $data['model'];
            $deviceState = $data['deviceState'] == 'newState' ? 1 : 0;
            $stateRange = $data['stateRange'];
            $images = $data['images'];
            $description = $data['description'];
            $deal = $data['deal'];
            $price = $data['price'];
            $terms = $data['terms'];
            $accessories = $data['accessories'];
            $damages = $data['damages'];

            if ($terms) {
                try {
                    $result = $phoneAds->create($userID, $brand, $model, $title, $deviceState, $stateRange, $description, $price, $images, 1, $damages, $accessories);
                    if ($result === true) {
                        $response = array(
                            'status' => 'success',
                            'message' => 'Uspešno ste se prijavili'
                        );
                    } else if ($result === false) {
                        $response = array(
                            'status' => 'error',
                            'message' => 'Doslo je do greske'
                        );
                    }
                } catch (Exception $e) {
                    $response = array(
                        'status' => 'error',
                        'message' => $e->getMessage()
                    );
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Nisu prihvaceni uslovi za kreiranje oglasa'
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Korisnik nije prijavljen'
            );
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Došlo je do greške. Molimo pokušajte kasnije'
        );
    }
    return $response;
}


function countData($phoneAds)
{
    try {
        $result = $phoneAds->countAllAds();
        $response = array(
            'status' => 'success',
            'message' => $result
        );
    } catch (Exception $e) {
        $response = array(
            'status' => 'error',
            'message' => 'Došlo je do greške prilikom filtriranja oglasa'
        );
    }
    return $response;
}

function countFiltered($phoneAds)
{
    $sort = $_GET['sort'];
    $brandsSelected = $_GET['brandsSelected'];
    $modelsSelected = $_GET['modelsSelected'];
    $minPrice = $_GET['minPrice'];
    $maxPrice = $_GET['maxPrice'];
    $oldState = $_GET['oldState'];
    $newState = $_GET['newState'];
    $damagedState = $_GET['damagedState'];
    $limit = $_GET['limit'];
    $offset = $_GET['page'] * $limit;
    $deal = $_GET['deal'];

    try {
        $result = $phoneAds->countAllFilteredAds($sort, $brandsSelected, $modelsSelected, $minPrice, $maxPrice, $newState, $oldState, $damagedState, $offset, $limit, $deal);
        $response = array(
            'status' => 'success',
            'message' => $result
        );
    } catch (Exception $e) {
        $response = array(
            'status' => 'error',
            'message' => 'Došlo je do greške prilikom pribavljanja broja filtriranih oglasa'
        );
    }
    return $response;
}

function getSearchData($title, $phoneAds)
{
    try {
        $result = $phoneAds->selectByTitle($title);
        $widgets = createSearchResult(json_decode($result, true));
        if ($result != '[]') {
            $response = [
                'status' => 'success',
                'message' => $widgets
            ];
        } else {
            $response = [
                'status' => 'empty',
                'message' => 'Nema rezultata'
            ];
        }
    } catch (Exception $ex) {
        $response = [
            'status' => 'error',
            'message' => 'Došlo je do greške prilikom pribavljanja search-ovanih oglasa'
        ];
    }
    return $response;
}


function addView($data, $phoneAds)
{
    try {
        $result = $phoneAds->addPhoneView($data['adId']);
        $response = array(
            'status' => 'success',
            'message' => $result
        );
    } catch (Exception $e) {
        $response = array(
            'status' => 'error',
            'message' => 'Došlo je do greške prilikom dodavanja pregleda oglasa'
        );
    }
    return $response;
}


function createSearchResult($ads)
{
    $result = '';
    for ($i = 0; $i < count($ads); $i++) {
        $folderPath = "../../uploads/" . $ads[$i]['images'];
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
        <div class="list-widget">
            <div style="display: flex">
                <div class="widget-image" style="width: 50px; height: 50px">
                    <img src="<?php echo $putanja ?>" alt="Main Image">
                </div>
                <div class="widget-title-city" style="margin-left: 20px">
                    <a href="../views/ad.php?ad_id=<?php echo $ads[$i]['ad_id'] ?>">
                        <?php
                        if (strlen($ads[$i]['title']) > 40) {
                            $padded_string = substr($ads[$i]['title'], 0, 37);
                            echo $padded_string . '...';
                        } else {
                            echo $ads[$i]['title'];
                        }
                        ?>
                    </a>
                    <p>
                        <?php
                        echo $ads[$i]['city'];
                        ?>
                    </p>
                </div>
            </div>
            <div class="widget-price">
                <p>
                    <?php
                    if ($ads[$i]['price'] !== NULL) {
                        echo '€' . $ads[$i]['price'];
                    } else {
                        echo "Dogovor";
                    }
                    ?>
                </p>
            </div>
        </div>
        <?php
        $result .= ob_get_clean();
    }
    return $result;
}



if ($user->isLogged()) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['action'])) {
            if ($data['action'] === 'newAd') {
                $response = newAds($data, $user, $phoneAds);
            }
            if ($data['action'] === 'addToFavourite') {
                $response = addToFavourite($data, $phoneAds);
            }
            if ($data['action'] === 'removeFromFavourite') {
                $response = removeFromFavourite($data, $phoneAds);
            }
            if ($data['action'] === 'checkIsFavourite') {
                $response = checkIsFavourite($data, $user);
            }
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($_GET['action'] === 'search') {
            $response = getSearchData($_GET['title'], $phoneAds);
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Neispravan zahtev'
        );
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($data['action'] === 'addView') {
        $response = addView($data, $phoneAds);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] === 'getAds') {
        $response = getAds($phoneAds);
    }
    if ($_GET['action'] === 'countData') {
        $response = countData($phoneAds);
    }
    if ($_GET['action'] === 'countFilteredData') {
        $response = countFiltered($phoneAds);
    }
    if ($_GET['action'] === 'search') {
        $response = getSearchData($_GET['title'], $phoneAds);
    }
}

echo json_encode($response);
