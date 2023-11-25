<?php
require_once "inc/header.php"; 

if($user->isLogged()){
    header("Location: index.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address'];

    //$user = new User(); ima ga u header
    $created = $user->create($name, $lastname, $username, $email, $password, $phone, $city, $address);

    if($created){
        $_SESSION['message']['type'] = 'success'; // success ili danger
        $_SESSION['message']['text'] = "Uspesno ste registrovali nalog";
        header("Location: index.php");
        exit();
    }
    else{
        $_SESSION['message']['type'] = 'danger'; // success ili danger
        $_SESSION['message']['text'] = "Doslo je do greske pri registraciji";
        header("Location: register.php");
        exit();
    }
}
?>



<div class="container">
    <h3 class="mt-5 mb-3">Registracija</h3>
    <form class="" method="POST" action="">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Ime</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group col-md-6">
                <label for="lastname">Prezime</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
            <div class="form-group col-md-6">
                <label for="username">Korisnicko ime</label>
                <input type="username" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group col-md-6">
                <label for="email">Email adresa</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="password">Lozinka</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group col-md-6">
                <label for="phone">Broj telefona</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group col-md-6">
                <label for="city">Grad</label>
                <select class="form-control" name="city" id="city" required>
                    <option value="" disabled selected hidden>Izaberi svoj grad</option>
                    <?php require_once "gradovi.php"; ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="address">Adresa</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Registruj se</button>
        </div>
        
    </form>
</div>

<?php require_once "inc/footer.php"; ?>