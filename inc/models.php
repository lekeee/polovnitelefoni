<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $brandName = $data['brandName'];

    $jsonContent = file_get_contents('../public/JSON/sortedDataNew.json');
    $dataJSON = json_decode($jsonContent, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Greška pri čitanju JSON datoteke.');
    }

    $foundBrand = null;

    foreach ($dataJSON as $brand) {
        if ($brand['brand_name'] === $brandName) {
            $foundBrand = $brand;
            break;
        }
    }

    if ($foundBrand !== null) {
        $options = '';

        foreach ($foundBrand['device_list'] as $model) {
            if (stripos($model['device_name'], "watch") === false) 
                $options .= "<option value='{$model['device_name']}'>{$model['device_name']}</option>";
        }

        $response = array(
            'status' => 'success',
            'message' => $options
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Izabrani brend ne postoji u našoj bazi'
        );
    }

    echo json_encode($response);
}
?>
