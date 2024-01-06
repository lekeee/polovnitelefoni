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
<tr>
    <td class="table-image">
        <img src="<?php echo $putanja; ?>" alt="Slika proizvoda 1">
    </td>
    <td>
        <a href="" class="saved-title">
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
        <?php echo $ads[$i]['creation_date'] ?>
    </td>
    <td>Novo</td>
    <td class="saved-damage damage">OŠTEĆENJE</td>
    <td>
        <div class="saved-price-close-container"></div>
    </td>
</tr>
<?php
        $result .= ob_get_clean();
    }
    return $result;
}

?>