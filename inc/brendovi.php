<?php
    $jsonContent = file_get_contents('../public/JSON/sortedDataNew.json');
    $dataJSON = json_decode($jsonContent, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Greška pri čitanju JSON datoteke.');
    }

    foreach ($dataJSON as $brand) {
        if (!empty($brand["device_list"])) {
            echo "
                <option value='{$brand['brand_name']}'>{$brand['brand_name']}</option>
            ";
        }
    }
?>