<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .custom-dropdown {
            background-color: red;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-in-out;
        }

        .custom-checkbox-group {
            margin-bottom: 10px;
        }

        .custom-checkbox-group label {
            cursor: pointer;
        }
    </style>
    <title>Custom Checkbox Dropdown</title>
</head>
<body>

    <div class="custom-checkbox-group">
        <input type="checkbox" id="appleCheckbox" class="custom-brand-checkbox" data-target="appleDropdown">
        <label for="appleCheckbox">Apple</label>
    </div>

    <div class="custom-dropdown" id="appleDropdown">
        <div>
            <input type="checkbox" id="iphone11Checkbox">
            <label for="iphone11Checkbox">iPhone 11</label>
        </div>
        <div>
            <input type="checkbox" id="iphone12Checkbox">
            <label for="iphone12Checkbox">iPhone 12</label>
        </div>
        <!-- Dodajte ostale modele prema potrebi -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const brandCheckbox = document.getElementById('appleCheckbox');
            const brandDropdown = document.getElementById('appleDropdown');

            brandCheckbox.addEventListener('change', function () {
                if (brandCheckbox.checked) {
                    expandDropdown(brandDropdown);
                } else {
                    collapseDropdown(brandDropdown);
                }
            });

            function expandDropdown(element) {
                const height = element.scrollHeight;
                element.style.maxHeight = height + "px";
                element.classList.add('visible');
            }

            function collapseDropdown(element) {
                element.style.maxHeight = 0;
                element.classList.remove('visible');
            }
        });
    </script>

</body>
</html>
