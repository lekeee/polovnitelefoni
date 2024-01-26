<?php
require_once "../classes/User.php";
require_once "../config/config.php";
include_once '../exceptions/userExceptions.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['action'])) {
        $user = new User();
        if ($data['action'] == 'getSavedAds') {
            try {
                $limit = 16;
                $offset = intval($data['page']) * $limit;
                $result = $user->mySaves($offset, $limit);
                if ($result !== NULL) {
                    $shows = savedWidget(json_decode($result, true));
                    $response = array(
                        'status' => 'success',
                        'message' => $shows
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
        }
    }
}
echo json_encode($response);

function savedWidget($ads)
{
    $result = "";
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
        <tr id="row_<?php echo $ads[$i]['ad_id'] ?>">
            <td class="table-image">
                <img src="<?php echo $putanja; ?>" alt="Slika proizvoda 1">
            </td>
            <td>
                <a href="../views/ad.php?ad_id=<?php echo $ads[$i]['ad_id'] ?>" class="saved-title">
                    <?php
                    if (strlen($ads[$i]['title']) > 40) {
                        $padded_string = substr($ads[$i]['title'], 0, 37);
                        echo $padded_string . '...';
                    } else {
                        echo $ads[$i]['title'];
                    }
                    ?>
                </a>
            </td>

            <td>
                <p class="saved-price">
                    <?php
                    if ($ads[$i]['price'] !== NULL) {
                        echo '€' . $ads[$i]['price'];
                    } else {
                        echo "Dogovor";
                    }
                    ?>
                </p>
            </td>
            <td class="saved-date">
                <?php
                $creationDateTime = $ads[$i]['creation_date'];
                $timestamp = strtotime($creationDateTime);
                $formattedDate = date("Y-m-d", $timestamp);
                echo $formattedDate;
                ?>
            </td>
            <td>
                <?php
                if ($ads[$i]['state'] === 1) {
                    echo 'Novo';
                } else {
                    echo 'Polovno';
                }
                ?>
            </td>
            <td class="saved-damage damage">
                <?php
                if ($ads[$i]['damage'] !== NULL) {
                    echo 'OŠTEĆENJE';
                }
                ?>
            </td>
            <td>
                <?php
                $user = new User();
                $userID = $user->getId();
                $adID = $ads[$i]['ad_id'];
                ?>
                <div class="saved-price-close-container"
                    onclick="removeFromMySave(<?php echo $userID ?>, <?php echo $ads[$i]['ad_id'] ?>)"></div>
            </td>
        </tr>
        <?php
        $result .= ob_get_clean();
    }
    return $result;
}

?>