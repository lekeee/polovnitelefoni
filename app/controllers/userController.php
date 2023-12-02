<?php
    require_once "../classes/User.php";
    require_once "../config/config.php";
    require_once "../classes/Phone.php";
    include_once '../exceptions/userExceptions.php';

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
                        if($result === TRUE){
                            $response = array(
                                'status' => 'success',
                                'message' => 'Uspešno ste se registrovali'
                            );
                        }else if($result === FALSE){
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
            }else if($data['action'] === 'signout'){
                $user->logout();
                $response = array(
                    'status' => 'success',
                    'message' => "Uspesno ste se odjavili"
                );
            }else if($data['action'] === 'edit-account'){
                $name = $data['name'];
                $lastname = $data['lastname'];
                $username = $data['username'];
                $oldPassword = $data['oldPassword'];
                $newPassword = $data['newPassword'];
                $mobilePhone = $data['mobilePhone'];
                $city = $data['city'];
                $address = $data['address'];

                if(empty($name)){
                    $response = array(
                        'status' => 'error',
                        'message' => 'Polje Ime je obavezno!'
                    );
                }else if(empty($lastname)){
                    $response = array(
                        'status' => 'error',
                        'message' => 'Polje Prezime je obavezno!'
                    );
                }else if(empty($username)){
                    $response = array(
                        'status' => 'error',
                        'message' => 'Polje Korisnicko Ime je obavezno!'
                    );
                }else if(strlen($username) < 6 || strlen($username) > 20){
                    $response = array(
                        'status' => 'error',
                        'message' => 'Korisnicko ime nije adekvatno! (mora imati više od 6 a manje od 20 karaktera)'
                    );
                }else if(empty($city)){
                    $response = array(
                        'status' => 'error',
                        'message' => 'Polje Grad je obavezno!'
                    );
                }else if(empty($address)){
                    $response = array(
                        'status' => 'error',
                        'message' => 'Polje Adresa je obavezno!'
                    );
                }else{
                    try{
                        $result = $user->updateUser($name, $lastname, $username, $oldPassword, $newPassword, $mobilePhone, $city, $address);
                        if($result === TRUE){
                            $response = array(
                                'status' => 'success',
                                'message' => 'Uspesno ste ažurirali Vaše podatke!'
                            );
                        }else{
                            $response = array(
                                'status' => 'error',
                                'message' => $result
                            );
                        }
                    }catch(USERNAME_TAKEN_EXCEPTION $e){
                        $response = array(
                            'status' => 'error',
                            'message' => 'Korisničko ime koje ste uneli je zauzeto!'
                        );
                    }catch(WRONG_PASSWORD $e){
                        $response = array(
                            'status' => 'error',
                            'message' => 'Vaša stara lozinka je neispravna!'
                        );
                    }
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