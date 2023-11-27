<?php
    require_once "../classes/User.php";
    require_once "../config/config.php";
    require_once "../classes/Phone.php";
    

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $data = json_decode(file_get_contents('php://input'), true);
        if(isset($data['action'])){
            $user = new User();
            if($data['action'] === 'login'){
                if(isset($data['email']) && isset($data['password'])){
                    $email = $data['email'];
                    $password = $data['password'];
                    $result = $user->login($email, $password);
                    if($result){
                        $response = array(
                            'status' => 'success',
                            'message' => 'Uspešno ste se prijavili'
                        );
                    }else{
                        $response = array(
                            'status' => 'error',
                            'message' => 'Pogrešna email adresa ili lozinka'
                        );
                    }
                }else{
                    $response = array(
                        'status' => 'error',
                        'message' => 'Došlo je do greške. Molimo pokušajte kasnije'
                    );
                }
            }else if($data['action'] === 'register'){
                if(isset($data['username']) && isset($data['email']) && isset($data['password']) && isset($data['repeatedPassword'])){
                    $username = $data['username'];
                    $email = $data['email'];
                    $password = $data['password'];
                    $repeatedPassword = $data['repeatedPassword'];

                    if($password === $repeatedPassword){
                        $result = $user->createPrimary($username, $email, $password);
                        if($result === true){
                            $response = array(
                                'status' => 'success',
                                'message' => 'Uspešno ste se registrovali'
                            );
                        }else if($result === false){
                            $response = array(
                                'status' => 'error',
                                'message' => 'Došlo je do greške prilikom registracije'
                            );
                        }else{
                            $response = array(
                                'status' => 'error',
                                'message' => $result
                            );
                        }
                    }else{
                        $response = array(
                            'status' => 'error',
                            'message' => 'Lozinke se ne poklapaju.'
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

    echo json_encode($response);
?>