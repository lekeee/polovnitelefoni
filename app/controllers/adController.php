<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../classes/User.php";
require_once "../config/config.php";
require_once "../classes/Phone.php";
include_once '../exceptions/userExceptions.php';

$user = new User();
$phoneAds = new Phone();
$limit = 4;

if ($user->isLogged()) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['action'])) {
            if ($data['action'] === 'newAd') {
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
            }
            if ($data['action'] === 'addToFavourite') {
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
            }
            if ($data['action'] === 'removeFromFavourite') {
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
            }
            if ($data['action'] === 'checkIsFavourite') {
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
            }
            if ($data['action'] === 'getAds') {
                try {
                    $offset = intval($data['page']) * $limit;
                    $result = $phoneAds->select24($offset, $limit);
                    $response = array(
                        'status' => 'success',
                        'message' => $result
                    );
                } catch (Exception $e) {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Došlo je do greške prilikom prihvatanja oglasa'
                    );
                }
            }
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $sort = $_GET['sort'];
        $brandsSelected = $_GET['brandsSelected'];
        $modelsSelected = $_GET['modelsSelected'];
        $minPrice = $_GET['minPrice'];
        $maxPrice = $_GET['maxPrice'];
        $oldState = $_GET['oldState'];
        $newState = $_GET['newState'];
        $damagedState = $_GET['damagedState'];
        $offset = $_GET['page'] * $limit;

        try {
            $result = $phoneAds->filter($sort, $brandsSelected, $modelsSelected, $minPrice, $maxPrice, $newState, $oldState, $damagedState, $offset, $limit);
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
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Neispravan zahtev'
        );
    }
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['action'])) {
            if ($data['action'] === 'getAds') {
                $offset = $data['page'] * $limit;
                try {
                    $result = $phoneAds->select24($offest, $limit);
                    $response = array(
                        'status' => 'success',
                        'message' => $result
                    );
                } catch (Exception $e) {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Došlo je do greške prilikom brisanja oglasa iz listu sačuvanih oglasa'
                    );
                }
            }
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $sort = $_GET['sort'];
        $brandsSelected = $_GET['brandsSelected'];
        $modelsSelected = $_GET['modelsSelected'];
        $minPrice = $_GET['minPrice'];
        $maxPrice = $_GET['maxPrice'];
        $oldState = $_GET['oldState'];
        $newState = $_GET['newState'];
        $damagedState = $_GET['damagedState'];
        $offset = $_GET['offset'] * $limit;

        try {
            $result = $phoneAds->filter($sort, $brandsSelected, $modelsSelected, $minPrice, $maxPrice, $newState, $oldState, $damagedState, $offset, $limit);
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
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Neispravan zahtev'
        );
    }
}
echo json_encode($response);
?>