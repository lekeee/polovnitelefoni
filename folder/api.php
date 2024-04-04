<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .firstcolumn{
            display: inline-block;
            width: 30%;
            background-color: lightgrey;
            padding-right: 100px;
        }
        .secondcolumn{
            display: inline;
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <label for="brandDropdown">Izaberite brend:</label>
    <select id="brandDropdown">
        <!-- Ovde će se dinamički dodavati opcije -->
    </select>
    <label for="deviceDropdown">Izaberite brend:</label>
    <select id="deviceDropdown">
    <option value=""> </option>
        <!-- Ovde će se dinamički dodavati opcije -->
    </select>
   
    <div id="specsdiv"></div>
</body>
</html>

<script type="module" src="api.js?v=<?php echo time(); ?>"></script>
