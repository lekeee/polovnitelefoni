<?php
require_once "inc/header.php";

if(!$user->isLogged()){
    header("Location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $user_id = $user->getId();
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $title = $_POST['title'];
    if($_POST['state'] == "novo"){
        $state = 0;
    }
    else if($_POST['state'] == "korisceno"){
        $state = 1;
    }
    $description = $_POST['description'];
    $price = $_POST['price'];


    
    $folderName = uniqid($user_id."_"); // Generiše jedinstveno ime foldera za slike
    $uploadDirectory = "uploads/" . $folderName; // Putanja do foldera za smeštaj slika
    mkdir($uploadDirectory); // Kreira folder

    $images = $_FILES['images'];
    $slikaBrojac = 1;
    //echo count($_FILES['images']['name']);
    foreach ($images['tmp_name'] as $key => $tmp_name) {
        $originalFileName = basename($images['name'][$key]);
    
        // Generišemo novo ime slike sa brojačem
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $newFileName = 'slika' . $slikaBrojac . '.' . $extension;

        $targetFile = $uploadDirectory . '/' . $newFileName;
        
        move_uploaded_file($tmp_name, $targetFile);
        
        $slikaBrojac++;
    }

    
    $phone = new Phone();
    $created = $phone->create($user_id, $brand, $model, $title, $state, $description, $price, $folderName);

    if($created){
        echo '<script>alert("Oglas je kreiran");</script>';
    }
    else {
        echo '<script>alert("Greska pri kreiranju oglasa");</script>';
    }   
    
}
 
?>

<div class="container" style="margin-top: 70px" >
    <form method="POST" action="" enctype="multipart/form-data" id="create-ad-form">
        <div class="form-group mb-3">
            <label for="brand">Brand</label>
            <input type="text" class="form-control" id="brand" name="brand" required>
        </div>
        <div class="form-group mb-3">
            <label for="model">Model</label>
            <input type="text" class="form-control" id="model" name="model" required>
        </div>
        <div class="form-group mb-3">
            <label for="title">Naslov oglasa</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group mb-3">
            <label for="images">Slike</label>
            <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple required>
            
            <div id="image-preview"></div>
        </div>
        <div class="form-group mb-3">
            <label for="state">Stanje</label>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="state" id="novo" value="novo" required>
            <label class="form-check-label" for="novo">
                Novo
            </label>
            </div>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="state" id="korisceno" value="korisceno" required>
            <label class="form-check-label" for="korisceno">
                Korišćeno
            </label>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="description">Opis oglasa</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>
        <div class="form-group mb-3">
            <label for="price">Cena</label>
            <input type="text" class="form-control" id="price" name="price" required>
        </div>
        <button type="submit" id="create-ad-btn" class="btn btn-primary mb-3">Kreiraj oglas</button>
    </form>
</div>

<?php require_once "inc/footer.php" ?>

<script>
var imagePreview = document.getElementById('image-preview');
document.getElementById('images').addEventListener('change', function (e) {
        for (var i = 0; i < e.target.files.length; i++) {
            var image = e.target.files[i];
            var imageElement = document.createElement('img');
            
            imageElement.classList.add("add-image");
            imageElement.src = URL.createObjectURL(image);
            imageElement.style.maxWidth = '100px'; // Podesite veličinu slike 
            imagePreview.appendChild(imageElement);
        }
    }); 

    

    /*var imagePreview = document.getElementById('image-preview');
    var br = 0;

    document.getElementById('images').addEventListener('change', function (e) {
        for (var i = 0; i < e.target.files.length; i++) {
            var image = e.target.files[i];
            var imageElement = document.createElement('img');

            imageElement.src = URL.createObjectURL(image);
            imageElement.style.maxWidth = '100px'; // Podesite veličinu slike 
            imagePreview.appendChild(imageElement);
        }
        // Stvaranje input elementa
        if(br >= 0){
            var inputElement = document.createElement('input');
            inputElement.setAttribute('type', 'file');
            inputElement.setAttribute('name', 'images[]');
            // Postavljanje odabrane datoteke u input element
            inputElement.files = e.target.files;
            inputElement.style.display = 'none';
            // Dodavanje elementa u DOM (unutar forme)
            var formElement = document.getElementById('create-ad-form'); 
            formElement.appendChild(inputElement);
        }
        br++;
    }); */
</script>