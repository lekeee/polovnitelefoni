<?php
include_once (__DIR__ . '/Ad.php');
include_once (__DIR__ . '/../exceptions/adExceptions.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);


class Phone extends Ad
{
    public $accessories;

    public function __construct($user_id = null, $brand = null, $model = null, $title = null, $state = null, $stateRange = null, $description = null, $images = null, $price = null, $new_price = null, $views = null, $availability = null, $damage = null, $accessories = null)
    {

        parent::__construct($user_id, $brand, $model, $title, $state, $stateRange, $description, $images, $price, $new_price, $views, $availability, $damage);

        $this->accessories = $accessories;
    }

    public function create($user_id, $brand, $model, $title, $state, $stateRange, $description, $price, $images, $availability, $damage, $accessories)
    {
        try {
            $sql = "INSERT INTO oglasi (user_id, brand, model, title, state, stateRange, description, price, images, availability, damage, accessories)
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->con->prepare($sql);
            if (!$stmt) {
                die('Error in SQL query: ' . $this->con->error);
            }
            $imageFolder = $this->createImageFolder($user_id);
            $isVerified = 1;
            $deal = NULL;
            $newPrice = empty($price) ? $deal : $price;
            $stmt->bind_param("isssssssssss", $user_id, $brand, $model, $title, $state, $stateRange, $description, $newPrice, $imageFolder, $isVerified, $damage, $accessories);

            $result = $stmt->execute();
            $result = $stmt->affected_rows;

            $imagesUploaded = $this->saveImages('../../uploads/' . $imageFolder, $images);

            return $imagesUploaded && ($result > 0 ? true : false);
        } catch (Exception $e) {
            throw new AD_CANNOT_BE_CREATED();
        }
    }

    public function createImageFolder($user_id)
    {
        $folderName = uniqid($user_id . "_");
        $uploadDirectory = '../../uploads/' . $folderName;
        mkdir($uploadDirectory, 0777, true);
        return $folderName;
    }


    public function saveImages($uploadDirectory, $imageSrcArray)
    {
        try {
            $brojac = 0;
            foreach ($imageSrcArray as $key => $imageSrc) {
                $base64String = $imageSrc;
                list($type, $data) = explode(';', $base64String);
                list(, $data) = explode(',', $data);

                $imageData = base64_decode($data);
                if ($brojac === 0) {
                    $imageName = 'mainimage.png';
                } else {
                    $imageName = uniqid('image_' . $brojac . '_') . '.png';
                }
                $targetFile = $uploadDirectory . '/' . $imageName;
                file_put_contents($targetFile, $imageData);
                $brojac++;
            }
            return true;
        } catch (Exception $e) {
            throw new IMAGES_NOT_SAVED();
        }
    }
    public function select24($offset = 0, $limit = 24)
    {
        try {
            $sql = "SELECT * FROM oglasi LIMIT $limit OFFSET $offset";
            $result = $this->con->query($sql);
            return json_encode($result->fetch_all(MYSQLI_ASSOC));
        } catch (Exception $e) {
            throw new ADS_NOT_SELECTED();
        }
    }



    public function read($ad_id)
    {
        try {
            $sql = "SELECT * FROM oglasi WHERE ad_id=?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $ad_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 1)
                return json_encode($result->fetch_assoc());
            return NULL;
        } catch (Exception $e) {
            throw new AD_CANNOT_BE_READ();
        }
    }
    // public function checkVisit($ip, $ad_id)
    // {
    //     try {
    //         $sql = "SELECT * FROM visitors WHERE ip_address=? AND ad_id=?";
    //         $stmt = $this->con->prepare($sql);
    //         $stmt->bind_param("si", $ip, $ad_id);
    //         $stmt->execute();
    //         $result = $stmt->get_result();

    //         return $result->num_rows == 0 ? true : false;
    //     } catch (Exception $e) {
    //         throw new CHECK_VISIT_ERROR();
    //     }
    // }

    // public function addVisit($ip, $ad_id)
    // {
    //     try {
    //         if ($this->checkVisit($ip, $ad_id)) {
    //             $sql = "INSERT INTO visitors (ip_address, ad_id) 
    //                 VALUES (?,?)";

    //             $stmt = $this->con->prepare($sql);
    //             $stmt->bind_param("si", $ip, $ad_id);

    //             $stmt->execute();
    //             $results = $stmt->affected_rows;

    //             return $results > 0 ? true : false;
    //         }
    //         return false;
    //     } catch (Exception $e) {
    //         throw new ADD_VISIT_ERROR();
    //     }
    // }

    // public function totalVisits($ad_id)
    // {
    //     try {
    //         $sql = "SELECT COUNT(*) as count FROM visitors WHERE ad_id=?";
    //         $stmt = $this->con->prepare($sql);
    //         $stmt->bind_param("i", $ad_id);
    //         $stmt->execute();
    //         $result = $stmt->get_result();
    //         $row = $result->fetch_assoc();

    //         return $row['count'];
    //     } catch (Exception $e) {
    //         throw new TOTAL_VISIT_ERROR();
    //     }
    // }
    public function countSaves($ad_id)
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM sacuvani_oglasi WHERE ad_id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $ad_id);

            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                return $row['count'];
            }
            return 0;
        } catch (Exception $e) {
            throw new COUNT_SAVES_ERROR();
        }
    }
    public function save($user_id, $ad_id)
    {
        try {
            $sql = "INSERT INTO sacuvani_oglasi (user_id, ad_id) 
            VALUES (?,?)";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("ii", $user_id, $ad_id);

            $stmt->execute();
            if ($stmt->error) {
                throw new Exception("SQL execution error: " . $stmt->error);
            }
            $results = $stmt->affected_rows;

            return $results > 0 ? true : false;
        } catch (Exception $e) {
            throw new ADD_CANNOT_BE_SAVED();
        }
    }

    public function deleteSave($user_id, $ad_id)
    {
        try {
            $sql = "DELETE FROM sacuvani_oglasi WHERE user_id = ? AND ad_id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("ii", $user_id, $ad_id);

            $stmt->execute();
            if ($stmt->error) {
                throw new Exception("SQL execution error: " . $stmt->error);
            }
            $results = $stmt->affected_rows;

            return $results > 0 ? true : false;
        } catch (Exception $e) {
            throw new SAVE_CANNOT_BE_DELETED();
        }
    }
    public function filter($title = null, $sort = null, $brands = null, $models = null, $minPrice = null, $maxPrice = null, $new = false, $used = false, $damaged = false, $offset = 0, $limit = 24, $deal = true, $city = null)
    {
        try {
            if ($sort !== null && $sort == 0) {
                $sql = "SELECT o.*, COUNT(so.ad_id) AS broj_sacuvanih 
                FROM oglasi o LEFT JOIN sacuvani_oglasi so 
                ON o.ad_id = so.ad_id";
                if ($city !== null && $city !== '0') {
                    $sql .= " INNER JOIN users u ON u.user_id = o.user_id WHERE u.city='$city'";
                } else {
                    $sql .= " WHERE 1";
                }

                if ($title != 'null') {
                    $title = strtolower($title);
                    $sql .= " AND LOWER(o.title) LIKE '%$title%'";
                }
            } else {
                $sql = "SELECT * FROM oglasi";
                if ($city !== null && $city !== '0') {
                    $sql .= " INNER JOIN users u ON u.user_id = oglasi.user_id WHERE u.city='$city'";
                } else {
                    $sql .= " WHERE 1";
                }

                if ($title != 'null') {
                    $title = strtolower($title);
                    $sql .= " AND LOWER(oglasi.title) LIKE '%$title%'";
                }
            }

            $models = json_decode(urldecode($models), true);
            if ($brands !== null && !empty($brands)) {
                $brandConditions = [];
                $brandsArray = explode(",", $brands);

                $insertedBrands = [];
                $br = 0;
                $brandWithModels = [];
                foreach ($brandsArray as $brand) {
                    $exist = 0;
                    if ($models !== null && !empty($models)) {
                        for ($i = 0; $i < count($models); $i++) {
                            if (in_array($brand, $models[$i])) {
                                $brand2 = strtolower($brand);
                                $model = strtolower($models[$i]['model']);

                                $brandConditions[] = "(LOWER(brand) = '$brand2' AND LOWER(model) = '$model')";
                                $exist = 1;
                            }
                        }
                    }
                    $brandWithModels[$br] = $exist;
                    if ($brandWithModels[$br] == 0) {
                        $insertedBrands[] = "'" . $brand . "'";
                    }
                    $br++;
                }
                $insertedBrands = array_unique($insertedBrands);
                if (!empty($models) && !empty($insertedBrands)) {
                    $sql .= " AND (" . implode(" OR ", $brandConditions) . ")" . " OR brand IN (" . implode(", ", $insertedBrands) . ')';
                } else if (empty($models) && !empty($insertedBrands)) {
                    $sql .= " AND brand IN (" . implode(", ", $insertedBrands) . ')';
                } else if (!empty($models) && empty($insertedBrands)) {
                    $sql .= " AND (" . implode(" OR ", $brandConditions) . ")";
                }
            }

            if ($minPrice !== null) {
                $sql .= " AND ((price >= $minPrice";
            }

            if ($maxPrice !== null) {
                $sql .= " AND price <= $maxPrice)";
            }
            if ($deal == 'true') {
                $sql .= " OR price IS NULL)";
            } else {
                $sql .= " AND price IS NOT NULL)";
            }

            if ($new === 'true' && $used === 'false' && $damaged === 'false') {
                $sql .= " AND state = 1"; // novi
            } elseif ($new === 'false' && $used === 'true' && $damaged === 'false') {
                $sql .= " AND state = 0"; // polovni
            } elseif ($new === 'false' && $used === 'false' && $damaged === 'true') {
                $sql .= " AND damage IS NOT NULL"; // osteceni
            } elseif ($new === 'true' && $used === 'true' && $damaged === 'false') {
                $sql .= " AND (state = 1 OR state = 0)"; // novi i korisceni
            } elseif ($new === 'true' && $used === 'false' && $damaged === 'true') {
                $sql .= " AND (state = 1 OR damage IS NOT NULL)"; // novi i osteceni
            } elseif ($new === 'false' && $used === 'true' && $damaged === 'true') {
                $sql .= " AND (state = 0 OR damage IS NOT NULL)"; // polovni i osteceni
            } elseif ($new === 'true' && $used === 'true' && $damaged === 'true') {
                $sql .= " AND (state = 1 OR state = 0 OR damage IS NOT NULL)"; // svi
            }

            if ($sort !== null) {
                if ($sort == 0) {
                    $sql .= ' GROUP BY o.ad_id 
                    ORDER BY broj_sacuvanih DESC';
                } else if ($sort == 1) {
                    $sql .= " ORDER BY creation_date DESC";
                } else if ($sort == 2) {
                    $sql .= " ORDER BY price ASC";
                } else if ($sort == 3) {
                    $sql .= " ORDER BY price DESC";
                }
            }

            $sql .= " LIMIT $limit OFFSET $offset";
            // echo $sql;
            $result = $this->con->query($sql);
            if (!$result) {
                throw new Exception("Database error: " . $this->con->error);
            }

            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            throw new FILTERS_ERROR();
        }
    }

    public function mostViewedAd()
    {
        try {
            $sql = "SELECT * FROM oglasi
                    ORDER BY views DESC LIMIT 1";

            $result = $this->con->query($sql);
            $mostViewedAd = $result->fetch_assoc();

            return json_encode($mostViewedAd);
        } catch (Exception $e) {
            throw new MOST_VIEWED_AD_ERROR();
        }
    }

    public function mostSavedAd()
    {
        try {
            $sql = "SELECT o.*, COUNT(*) AS broj_sacuvanih 
                    FROM sacuvani_oglasi so
                    INNER JOIN oglasi o ON so.ad_id = o.ad_id
                    GROUP BY o.ad_id 
                    ORDER BY broj_sacuvanih DESC LIMIT 1";

            $result = $this->con->query($sql);
            $mostSavedAd = $result->fetch_assoc();

            return json_encode($mostSavedAd);
        } catch (Exception $e) {
            throw new MOST_SAVED_AD_ERROR();
        }
    }

    public function newestAd()
    {
        try {
            $sql = "SELECT * FROM oglasi 
                    ORDER BY creation_date DESC LIMIT 1";

            $result = $this->con->query($sql);
            $newestAd = $result->fetch_assoc();

            return json_encode($newestAd);
        } catch (Exception $e) {
            throw new NEWEST_AD_ERROR();
        }
    }
    public function deleteAd($ad_id)
    {
        try {
            $this->deleteAdfromSaves($ad_id);
            // $this->deleteAdfromVisit($ad_id);
            // echo "tu sam";
            if ($this->saveDeletedAdData($ad_id)) {
                $sql = "DELETE FROM oglasi WHERE ad_id = ?";
                $stmt = $this->con->prepare($sql);
                $stmt->bind_param("i", $ad_id);

                $stmt->execute();
                if ($stmt->error) {
                    throw new Exception("SQL execution error: " . $stmt->error);
                }
                $results = $stmt->affected_rows;

                return $results > 0 ? true : false;
            }

        } catch (Exception $e) {
            throw new AD_CANNOT_BE_DELETED();
        }
    }

    public function deleteAdfromSaves($ad_id)
    {
        try {
            $sql = "DELETE FROM sacuvani_oglasi WHERE ad_id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $ad_id);

            $stmt->execute();
            if ($stmt->error) {
                throw new Exception("SQL execution error: " . $stmt->error);
            }
            return true;
        } catch (Exception $e) {
            throw new DELETE_AD_FROM_SAVES_ERROR();
        }
    }

    // public function deleteAdfromVisit($ad_id)
    // {
    //     try {
    //         $sql = "DELETE FROM visitors WHERE ad_id = ?";

    //         $stmt = $this->con->prepare($sql);
    //         $stmt->bind_param("i", $ad_id);


    //         $stmt->execute();
    //         if ($stmt->error) {
    //             throw new Exception("SQL execution error: " . $stmt->error);
    //         }
    //         return true;
    //     } catch (Exception $e) {
    //         throw new DELETE_AD_FROM_VISITS_ERROR();
    //     }
    // }

    public function saveDeletedAdData($ad_id)
    {
        try {
            $sql = "SELECT user_id, brand, model, creation_date FROM oglasi WHERE ad_id = ?";

            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $ad_id);

            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $sql = "INSERT INTO obrisani_oglasi (ad_id, user_id, brand, model, creation_date) 
                    VALUES (?,?,?,?,?)";
                $stmt = $this->con->prepare($sql);
                $stmt->bind_param("iisss", $ad_id, $row['user_id'], $row['brand'], $row['model'], $row['creation_date']);
                $stmt->execute();

                $results = $stmt->affected_rows;
                return $results > 0 ? true : false;
            }
            return false;
        } catch (Exception $e) {
            throw new SAVE_DELETED_AD_DATA_ERROR();
        }
    }

    public function countAllAds()
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM oglasi";

            $stmt = $this->con->prepare($sql);

            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                return $row['count'];
            }
            return 0;
        } catch (Exception $e) {
            throw new COUNT_ALL_ADS_ERROR();
        }
    }


    public function countAllFilteredAds($title = null, $sort = null, $brands = null, $models = null, $minPrice = null, $maxPrice = null, $new = false, $used = false, $damaged = false, $offset = 0, $limit = 24, $deal = true, $city = null)
    {
        try {
            $sql = "SELECT COUNT(*) as ukupno_oglasa FROM oglasi";
            if ($city !== null && $city !== '0') {
                $sql .= " INNER JOIN users u on u.user_id = oglasi.user_id WHERE u.city = '$city'";
            } else {
                $sql .= " WHERE 1";
            }

            if ($title != 'null') {
                $title = strtolower($title);
                $sql .= " AND LOWER(oglasi.title) LIKE '%$title%'";
            }
            $models = json_decode(urldecode($models), true);
            if ($brands !== null && !empty($brands)) {
                $brandConditions = [];
                $brandsArray = explode(",", $brands);

                $insertedBrands = [];
                $br = 0;
                $brandWithModels = [];
                foreach ($brandsArray as $brand) {
                    $exist = 0;
                    if ($models !== null && !empty($models)) {
                        for ($i = 0; $i < count($models); $i++) {
                            if (in_array($brand, $models[$i])) {
                                $model = $models[$i]['model'];
                                $brandConditions[] = "(brand = '$brand' AND model = '$model')";
                                $exist = 1;
                            }
                        }
                    }
                    $brandWithModels[$br] = $exist;
                    if ($brandWithModels[$br] == 0) {
                        $insertedBrands[] = "'" . $brand . "'";
                    }
                    $br++;
                }
                $insertedBrands = array_unique($insertedBrands);
                if (!empty($models) && !empty($insertedBrands)) {
                    $sql .= " AND (" . implode(" OR ", $brandConditions) . ")" . " OR brand IN (" . implode(", ", $insertedBrands) . ')';
                } else if (empty($models) && !empty($insertedBrands)) {
                    $sql .= " AND brand IN (" . implode(", ", $insertedBrands) . ')';
                } else if (!empty($models) && empty($insertedBrands)) {
                    $sql .= " AND (" . implode(" OR ", $brandConditions) . ")";
                }
            }

            if ($minPrice !== null) {
                $sql .= " AND ((price >= $minPrice";
            }

            if ($maxPrice !== null) {
                $sql .= " AND price <= $maxPrice)";
            }
            if ($deal == 'true') {
                $sql .= " OR price IS NULL)";
            } else {
                $sql .= " AND price IS NOT NULL)";
            }


            if ($new === 'true' && $used === 'false' && $damaged === 'false') {
                $sql .= " AND state = 1"; // novi
            } elseif ($new === 'false' && $used === 'true' && $damaged === 'false') {
                $sql .= " AND state = 0"; // polovni
            } elseif ($new === 'false' && $used === 'false' && $damaged === 'true') {
                $sql .= " AND damage IS NOT NULL"; // osteceni
            } elseif ($new === 'true' && $used === 'true' && $damaged === 'false') {
                $sql .= " AND (state = 1 OR state = 0)"; // novi i korisceni
            } elseif ($new === 'true' && $used === 'false' && $damaged === 'true') {
                $sql .= " AND (state = 1 OR damage IS NOT NULL)"; // novi i osteceni
            } elseif ($new === 'false' && $used === 'true' && $damaged === 'true') {
                $sql .= " AND (state = 0 OR damage IS NOT NULL)"; // polovni i osteceni
            } elseif ($new === 'true' && $used === 'true' && $damaged === 'true') {
                $sql .= " AND (state = 1 OR state = 0 OR damage IS NOT NULL)"; // svi
            }
            $result = $this->con->query($sql);
            if (!$result) {
                throw new Exception("Database error: " . $this->con->error);
            }

            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            throw new FILTERS_ERROR();
        }
    }
    public function getAdFolder($ad_id)
    {
        try {
            $sql = "SELECT images FROM oglasi WHERE ad_id=?";
            $stmt = $this->con->prepare($sql);

            if (!$stmt) {
                die('Error in SQL query: ' . $this->con->error);
            }
            $imageFolder = null;
            $stmt->bind_param("i", $ad_id);
            $stmt->execute();
            $stmt->bind_result($imageFolder);
            $stmt->fetch();
            $stmt->close();

            return $imageFolder;
        } catch (Exception $e) {
            throw new GET_AD_FOLDER_ERROR();
        }
    }

    public function updateAd($ad_id, $brand, $model, $title, $state, $stateRange, $description, $price, $images, $availability, $damage, $accessories)
    {
        try {
            $sql = "UPDATE oglasi 
                    SET brand=?, model=?, title=?, state=?, stateRange=?, description=?, price=?, old_price=?, damage=?, accessories=? 
                    WHERE ad_id=?";
            $stmt = $this->con->prepare($sql);
            if (!$stmt) {
                die('Error in SQL query: ' . $this->con->error);
            }

            $adData = json_decode($this->read($ad_id), true);

            $brand = empty($brand) ? $adData['brand'] : $brand;
            $model = empty($model) ? $adData['model'] : $model;
            $title = empty($title) ? $adData['title'] : $title;
            $state = empty($state) ? $adData['state'] : $state;
            $stateRange = empty($stateRange) ? $adData['stateRange'] : $stateRange;
            $description = empty($description) ? $adData['description'] : $description;

            if (empty($price)) {
                $price = $adData['price'];
                $oldprice = $adData['old_price'];
            } else {
                $oldprice = $adData['price'];
            }

            $damage = empty($damage) ? $adData['damage'] : $damage;
            $accessories = empty($accessories) ? $adData['accessories'] : $accessories;

            $stmt->bind_param("ssssssssssi", $brand, $model, $title, $state, $stateRange, $description, $price, $oldprice, $damage, $accessories, $ad_id);
            $result = $stmt->execute();
            $affectedRows = $stmt->affected_rows;

            if ($result && $affectedRows > 0) {
                if (!empty($images)) {
                    $adFolder = $this->getAdFolder($ad_id);
                    $this->deleteImagesFromFolder($adFolder);
                    $imagesUploaded = $this->saveImages('../../uploads/' . $adFolder, $images);
                    return $imagesUploaded;
                }
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new AD_CANNOT_BE_UPDATED();
        }
    }

    public function getDeviceImage($brandName, $modelName)
    {
        try {
            $jsonFilePath = '../public/JSON/sortedData.json';
            $jsonData = file_get_contents($jsonFilePath);
            $data = json_decode($jsonData, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                die('Greška prilikom dekodiranja JSON fajla.');
            }

            foreach ($data as $brand) {
                if ($brand['brand_name'] == $brandName) {
                    foreach ($brand['device_list'] as $device) {
                        if ($device['device_name'] == $modelName) {
                            return $device['device_image'];
                        }
                    }
                }
            }
        } catch (Exception $e) {
            throw new GET_DEVICE_IMAGE_ERROR();
        }
    }

    public function deleteImagesFromFolder($folder)
    {
        try {
            $folderPath = '../../uploads/' . $folder . '/';

            if (file_exists($folderPath)) {
                $files = glob($folderPath . '*');

                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    }
                }
            } else {
                echo 'Folder ne postoji.';
            }
        } catch (Exception $e) {
            throw new DELETE_IMAGES_FROM_FOLDER_ERROR();
        }
    }

    public function deleteImagesFolder($ad_id)
    {
        try {
            $folder = $this->getAdFolder($ad_id);
            $folderPath = '../../uploads/' . $folder;

            if (file_exists($folderPath) && is_dir($folderPath)) {
                $this->deleteImagesFromFolder($folder);
                rmdir($folderPath);
                return true;
            }
            return false;
        } catch (Exception $e) {
            throw new DELETE_IMAGES_FOLDER_ERROR;
        }
    }

    public function returnUserAds($table, $id)
    {
        try {
            $sql = "SELECT * FROM $table WHERE user_id = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            $ads = $result->fetch_all(MYSQLI_ASSOC);
            if ($ads) {
                return json_encode($ads);
            } else {
                return json_encode([]);
            }
        } catch (Exception $e) {
            throw new RETURN_USER_ADS_ERROR();
        }
    }

    public function brandsPrecentage($id)
    {
        try {
            $activeAds = json_decode($this->returnUserAds("oglasi", $id), true);
            $deletedAds = json_decode($this->returnUserAds("obrisani_oglasi", $id), true);
            $brandCounts = [];
            foreach ($activeAds as $ad) {
                $brand = $ad['brand'];
                if (!isset($brandCounts[$brand])) {
                    $brandCounts[$brand] = 1;
                } else {
                    $brandCounts[$brand]++;
                }
            }

            foreach ($deletedAds as $ad) {
                $brand = $ad['brand'];
                if (!isset($brandCounts[$brand])) {
                    $brandCounts[$brand] = 1;
                } else {
                    $brandCounts[$brand]++;
                }
            }

            $totalAds = count($activeAds) + count($deletedAds);
            $brandPercentages = [];

            foreach ($brandCounts as $brand => $count) {
                $percentage = ($count / $totalAds) * 100;
                $brandPercentages[$brand] = $percentage;
            }

            return $brandPercentages;
        } catch (Exception $e) {
            throw new BRANDS_PRECENTAGE_ERROR();
        }
    }

    public function returnBrandsAndModels()
    {
        try {
            $sql = "SELECT DISTINCT brand, model FROM oglasi";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            return json_encode($result->fetch_all(MYSQLI_ASSOC));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function selectByTitle($title)
    {
        try {
            $sql = "SELECT *
                    FROM oglasi as o
                    INNER JOIN users as u
                    ON o.user_id = u.user_id
                    WHERE LOWER(title) LIKE ?";
            $stmt = $this->con->prepare($sql);
            $title = "%" . strtolower($title) . "%";
            $stmt->bind_param("s", $title);
            $stmt->execute();
            $result = $stmt->get_result();
            return json_encode($result->fetch_all(MYSQLI_ASSOC));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function addPhoneView($ad_id)
    {
        try {
            $sql = "UPDATE oglasi 
                    SET views = views + 1 
                    WHERE ad_id = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $ad_id);
            $stmt->execute();
            return $stmt->affected_rows > 0 ? true : false;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}