<?php
require_once "app/config/config.php";
require_once "app/classes/User.php";
require_once "app/classes/Phone.php";

$user = new User();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>
</head>
<body>

<header class="header"> 
    <a href="index.php">Logo</a>
    <nav class="navbar">
        <?php if(!$user->isLogged()) : ?>
        <a href="register.php">Napravi nalog</a>
        <a href="login.php">Prijavi se</a>
        <?php else : ?>
        <a href="create_ad.php">Dodaj oglas</a>
        <a href="#">Profile</a>
        <a href="logout.php">Odjavi se</a>
        <?php endif; ?>
    </nav>
</header>
<?php if(isset($_SESSION['message'])) : ?>
    <div class="alert alert-<?php echo $_SESSION['message']['type'] ?> alert-dismissable fade show" role="alert">
    <?php
        echo $_SESSION['message']['text'];
        unset($_SESSION['message']);
    ?>
    </div>  
<?php endif; ?>