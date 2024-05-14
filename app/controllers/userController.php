<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../classes/User.php";
require_once "../config/config.php";
require_once "../classes/Phone.php";
include_once '../exceptions/userExceptions.php';

$limit = 16;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['action'])) {
        $user = new User();
        if ($data['action'] === 'login') {
            if (isset($data['email']) && isset($data['password'])) {
                $email = $data['email'];
                $password = $data['password'];
                try {
                    $result = $user->login($email, $password);
                    if ($result === TRUE) {
                        $response = array(
                            'status' => 'success',
                            'message' => 'Uspešno ste se prijavili'
                        );
                    } else if ($result === FALSE) {
                        $response = array(
                            'status' => 'error',
                            'message' => 'Pogrešna email adresa ili lozinka'
                        );
                    }
                } catch (ACCOUNT_NOT_VERIFIED $e) {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Nalog mora biti verifikovan da biste mogli da se prijavite!'
                    );
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Došlo je do greške. Molimo pokušajte kasnije'
                );
            }
        } else if ($data['action'] === 'register') {
            if (isset($data['username']) && isset($data['email']) && isset($data['password']) && isset($data['repeatedPassword'])) {
                $username = $data['username'];
                $email = $data['email'];
                $password = $data['password'];
                $repeatedPassword = $data['repeatedPassword'];

                if ($password === $repeatedPassword) {
                    $result = $user->createPrimary($username, $email, $password);
                    if ($result === TRUE) {
                        $response = array(
                            'status' => 'success',
                            'message' => 'Uspešno ste se registrovali'
                        );
                    } else if ($result === FALSE) {
                        $response = array(
                            'status' => 'error',
                            'message' => 'Došlo je do greške prilikom registracije'
                        );
                    } else {
                        $response = array(
                            'status' => 'error',
                            'message' => $result
                        );
                    }
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Lozinke se ne poklapaju.'
                    );
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Došlo je do greške. Molimo pokušajte kasnije'
                );
            }
        } else if ($data['action'] === 'signout') {
            $user->logout();
            $response = array(
                'status' => 'success',
                'message' => "Uspesno ste se odjavili"
            );
        } else if ($data['action'] === 'edit-account') {
            $name = $data['name'];
            $lastname = $data['lastname'];
            $username = $data['username'];
            $oldPassword = $data['oldPassword'];
            $newPassword = $data['newPassword'];
            $mobilePhone = $data['mobilePhone'];
            $city = $data['city'];
            $address = $data['address'];

            if (empty($name)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Polje Ime je obavezno!'
                );
            } else if (empty($lastname)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Polje Prezime je obavezno!'
                );
            } else if (empty($username)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Polje Korisnicko Ime je obavezno!'
                );
            } else if (strlen($username) < 6 || strlen($username) > 20) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Korisnicko ime nije adekvatno! (mora imati više od 6 a manje od 20 karaktera)'
                );
            } else if (empty($city)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Polje Grad je obavezno!'
                );
            } else if (empty($address)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Polje Adresa je obavezno!'
                );
            } else {
                try {
                    $result = $user->updateUser($name, $lastname, $username, $oldPassword, $newPassword, $mobilePhone, $city, $address);
                    if ($result === TRUE) {
                        $response = array(
                            'status' => 'success',
                            'message' => 'Uspesno ste ažurirali Vaše podatke!'
                        );
                    } else {
                        $response = array(
                            'status' => 'error',
                            'message' => $result
                        );
                    }
                } catch (USERNAME_TAKEN_EXCEPTION $e) {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Korisničko ime koje ste uneli je zauzeto!'
                    );
                } catch (WRONG_PASSWORD $e) {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Vaša stara lozinka je neispravna!'
                    );
                }
            }
        } else if ($data['action'] === 'delete-account') {
            try {
                $username = $data['username'];
                $result = $user->deleteUser($username);
                if ($result === TRUE) {
                    $user->logout();
                    $response = array(
                        'status' => 'success',
                        'message' => 'Nalog je uspešno obrisan!'
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Došlo je do greške prilimo brisanja naloga!'
                    );
                }
            } catch (VERIFICATION_CANNOT_BE_DELETED $e) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Došlo je do greške prilimo brisanja verifikacionih kodova!'
                );
            } catch (INCORECT_USERNAME $e) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Uneto korisničko ime nije ispravno!'
                );
            } catch (USER_ADS_CANNOT_BE_DELETED $e) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Došlo je do greške prilikom brisanja korisnikovih oglasa!'
                );
            } catch (USER_CANNOT_BE_DELETED $e) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Došlo je do greše prilikom brisanja naloga!'
                );
            } catch (Exception $e) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Došlo je do greše prilikom brisanja naloga!'
                );
            }
        } else if ($data['action'] === 'getSavedAds') {
            try {
                $offset = intval($data['page']) * $limit;
                $result = $user->mySaves($offset, $limit);
                if ($result !== NULL) {
                    $response = array(
                        'status' => 'success',
                        'message' => $result
                    );
                } else {
                    $response = array(
                        'status' => 'empty',
                        'message' => 'Nema sačuvanih oglasa'
                    );
                }
            } catch (Exception $e) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Došlo je do greške prilikom prihvatanja sacuvanih oglasa'
                );
            }
        } else if ($data['action'] === 'getEmailAddress') {
            try {
                $username = $data['username'];
                $result = $user->getEmail($username);
                if ($result !== NULL) {
                    $response = array(
                        'status' => 'success',
                        'message' => $result
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Ne postoji email'
                    );
                }
            } catch (Exception $ex) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Došlo je do greške'
                );
            }
        } else if ($data['action'] === 'reportUser') {
            try {
                $userId = $data['userId'];
                $reportedId = $data['reportedId'];
                $msg = $data['msg'];
                $result = $user->reportUser($userId, $reportedId, $msg);
                if ($result) {
                    $response = array(
                        'status' => 'success',
                        'message' => 'Uspešno prijavljen korisnik'
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Došlo je do greške prilikom prijave korisnika'
                    );
                }
            } catch (Exception $ex) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Došlo je do greške'
                );
            }
        } else if ($data['action'] === 'returnRates') {
            $response = returnRates($user, $data);
        } else if ($data['action'] === 'rateUser') {
            $response = rateUser($user, $data);
        }
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Neispravan zahtev'
    );
}

echo json_encode($response);

function returnRates($user, $data)
{
    try {
        $userId = $data['userID'];
        $result = $user->returnRates($userId);
        $result2 = false;
        if ($user->isLogged()) {
            $result2 = $user->isRated($user->getId(), $userId);
        }
        if ($result !== null) {
            $response = [
                'status' => 'success',
                'message' => $result,
                'isRated' => $result2,
            ];
        } else {
            $response = [
                'status' => 'empty',
                'message' => 'Još uvek nema ocenass'
            ];
        }
    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'message' => 'Doslo je do greske prilikom pribavljanja ocena'
        ];
    }
    return $response;
}

function rateUser($user, $data)
{
    try {
        $userId = $data['userID'];
        $type = $data['tip'];
        if ($user->isLogged()) {
            $result = $user->addRate($user->getId(), $userId, $type);
            if ($result !== false) {
                $response = [
                    'status' => 'success',
                    'message' => $result,
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Došlo je do greške prilikom ocenjivanja korisnika'
                ];
            }
        } else {
            $response = [
                'status' => 'not-logged',
                'message' => 'Niste prijavljeni'
            ];
        }

    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'message' => 'Doslo je do greske prilikom ocenjivanja korisnika'
        ];
    }
    return $response;
}