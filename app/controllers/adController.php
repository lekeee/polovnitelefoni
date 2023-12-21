<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    require_once "../classes/User.php";
    require_once "../config/config.php";
    require_once "../classes/Phone.php";
    include_once '../exceptions/userExceptions.php';

    $user = new User();

    if($user->isLogged()){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = json_decode(file_get_contents('php://input'), true);
            if(isset($data['action'])){
                if($data['action'] === 'newAd'){
                    if(isset($data['title']) && isset($data['brand'])
                        && isset($data['model']) && isset($data['deviceState'])
                        && isset($data['stateRange']) && isset($data['images'])
                        && isset($data['description']) && isset($data['deal'])
                        && isset($data['price']) && isset($data['terms'])){
                        
                        $userID = $user->getId();

                        if($userID != null){
                            $phoneAds = new Phone();

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
                            
                            if($terms){
                                try{
                                    $result = $phoneAds->create($userID, $brand, $model, $title, $deviceState, $stateRange, $description, $price, $images, 1, $damages, $accessories);
                                    if($result === true){
                                        $response = array(
                                            'status' => 'success',
                                            'message' => 'Uspešno ste se prijavili'
                                        );
                                    }else if($result === false){
                                        $response = array(
                                            'status' => 'error',
                                            'message' => 'Doslo je do greske'
                                        );
                                    }
                                }catch(Exception $e){
                                    $response = array(
                                        'status' => 'error',
                                        'message' => $e->getMessage()
                                    );
                                }
                            }else{
                                $response = array(
                                    'status' => 'error',
                                    'message' => 'Nisu prihvaceni uslovi za kreiranje oglasa'
                                );
                            }
                        }else{
                            $response = array(
                                'status' => 'error',
                                'message' => 'Korisnik nije prijavljen'
                            );
                        }
                    }else{
                        $response = array(
                            'status' => 'error',
                            'message' => 'Došlo je do greške. Molimo pokušajte kasnije'
                        );
                    }
                }
            }
        }else{
            $response = array(
                'status' => 'error',
                'message' => 'Neispravan zahtev'
            );
        }
    }else{
        $response = array(
            'status' => 'error',
            'message' => 'Korisnik nije prijavljen'
        );
    }
    echo json_encode($response);
?>