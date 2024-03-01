<!DOCTYPE html>
<html data-wf-domain="polovni-telefoni.webflow.io" data-wf-page="655506e07faa7f82a5f25613"
    data-wf-site="655506e07faa7f82a5f25610">

<?php
require_once "../inc/headTag.php";
?>

<body class="body">
    <link rel="stylesheet" href="../public/css/messages.css?v=<?php echo time(); ?>">

    <?php
    require_once "../inc/header.php";
    require_once "../inc/bottomNavigator.php";
    require_once "../inc/mobileMenu.php";

    require_once "../app/classes/Messages.php";
    ?>

    <section class="messages-section">
        <div class="messages-main-div">
            <div class="messages-left-container">
                <div class="messages-search-container">
                    <div class="search-icon-container">
                        <img src="../public/src/search-icon.svg" width="24">
                    </div>
                    <input type="text" placeholder="Pretraži">
                </div>
                <div class="messages-sender-container">
                    <?php
                    $token = $user->getToken($_SESSION['user_id']);
                    $name = $userData["name"];
                    $users = $user->selectAll();
                    $msg = new Messages();
                    $unreadData = $msg->getUnreadMessages($_SESSION['user_id']);
                    $br = 0;

                    foreach ($users as $userData) {
                        if ($userData[1] == $name) {
                            continue;
                        }
                        foreach ($unreadData as $countUnread) {
                            if ($countUnread['sender_id'] == $userData[0]) {
                                $br = $countUnread['count_unread'];
                            }
                        }
                        ?>
                        <div class="header-div">
                            <!-- Prepraviti da se ovo cuva u local storage -->
                            <input type="hidden" name="" id="login-user-id" value="<?php echo $_SESSION['user_id']; ?>">
                            <input type="hidden" name="" id="user-token" value="<?php echo $token; ?>">
                        </div>
                        <div class="sender-container" onclick="showMessages(this)">
                            <input type="hidden" name="" id="user-id" value="<?php echo $userData[0] ?>">
                            <div class="profile-image-status">
                                <img src="../public/src/userShow2.svg">
                                <div id="status-div-<?php echo $userData[0] ?>"
                                    class="<?php echo $userData[4] == 0 ? "offline" : "online" ?>-status-div"></div>

                            </div>
                            <div class="sender-info-container">
                                <h4 class="user-name">
                                    <?php
                                    if ($userData[1] !== null && $userData[2] !== null) {
                                        echo $userData[1] . ' ' . $userData[2];
                                    } else {
                                        echo $userData[3];
                                    }
                                    ?>
                                </h4>
                                <p class="user-description">Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>

                            </div>
                            <div class="count-unread-div unread-msg-div-<?php echo $userData[0]; ?>"
                                style="display:<?php echo $br != 0 ? 'flex' : 'none' ?>">
                                <?php
                                echo $br != 0 ? $br : "";
                                $br = 0;
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="messages-right-container">
                <div class="main-chat-div">
                    <div class="no-user-selected">
                        <img src="../public/src/no-message-selected.svg">
                        <h4>Izaberite korisnika sa kojim želite da razmenjujete poruke</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    require_once "../inc/subscribeForm.php";
    require_once "../inc/footer.php";
    ?>
    <script src="../public/js-public/jquery.js"></script>
    <script src="../public/js/messages.js?=<?php echo time(); ?>"></script>
    <script src="../public/js/login-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>
</body>

</html>