<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../pusher/pusher.css">
    <title>Document</title>
</head>
<body>
    <div class="main-div">
        <input type="hidden" name="" class="user_id" value="<?=$_SESSION['user_id']?>">
        <div class="left-div">
            <div>Aleksa</div>
            <div>Djordje</div>
        </div>
        <div class="right-div">
            <div class="chatbox">
                <input type="text" name="" id="" class="message-input">
                <input type="submit" value="Posalji" class="send-button">
            </div>
        </div>
    </div>
</body>
</html>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="../pusher/pusher.js"></script>