<?php
require_once "inc/header.php"; 

if($user->isLogged()){
    header("Location: index.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    //$user = new User(); ima ga u header
    $result = $user->login($email, $password);

    if(!$result){
        $_SESSION['message']['type'] = 'danger'; // success ili danger
        $_SESSION['message']['text'] = "Netacan email ili lozinka";
        header("Location: login.php");
        exit();
    }
    
    header("Location: index.php");
    exit();
    
    
    
}

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <h3 class="text-center py-5">Login</h3>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Lozinka</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>
                <button type="submit" class="btn btn-primary">Prijavi se</button>
            </form>
            <span>Nemate nalog? </span><a href="register.php">Napravi nalog</a>
        </div>
    </div>
</div>

<?php require_once "inc/footer.php"; ?>