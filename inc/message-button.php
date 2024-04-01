<?php
if ($user->isLogged()) {
    ?>
    <link rel="stylesheet" href="../public/css/message-button.css?v=<?php echo time() ?>">
    <div class="message-btn-container" onclick="window.location.href='../views/messages.php'">
        <div class="message-img-container"></div>
    </div>
<?php } ?>