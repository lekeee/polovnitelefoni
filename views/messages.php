<?php
require_once "../app/auth/checkAuthState.php";
?>
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
                    <input id="search-bar" type="text" placeholder="Pretraži">
                </div>
                <div class="messages-sender-container">
                    <?php
                    $token = $user->getToken($_SESSION['user_id']);
                    $msg = new Messages();
                    $users = $msg->selectUsersWithMessages($_SESSION['user_id']);
                    $unreadData = $msg->getUnreadMessages($_SESSION['user_id']);
                    $br = 0;
                    $notEmptyUsersDiv = false;

                    if (isset($_GET['id'])) {
                        $messagesExist = false;
                        $receiver_id = $_GET['id'];
                        if ($users !== NULL) {
                            foreach ($users as $userData) {
                                if ($userData[0] == $receiver_id) {
                                    $messagesExist = true;
                                    break;
                                }
                            }
                        }
                        if (!$messagesExist) {
                            $notExistUserEncoded = $user->returnOtherUser($receiver_id);
                            if ($notExistUserEncoded !== NULL) {
                                $notExistUser = json_decode($notExistUserEncoded, true);
                                $notEmptyUsersDiv = true;
                                ?>
                                <div class="header-div">
                                    <!-- Prepraviti da se ovo cuva u local storage -->
                                    <input type="hidden" name="" id="login-user-id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="" id="user-token" value="<?php echo $token; ?>">
                                </div>
                                <div class="sender-container needClick"">
                                    <input type="hidden" name="" id="user-id" value="<?php echo $receiver_id ?>">
                                    <div class="profile-image-status">
                                        <img src="../public/src/userShow2.svg">
                                        <div id="status-div-<?php echo $receiver_id ?>" class="
                                        <?php
                                        if ($notExistUser['login_status'] == 1) {
                                            if ($notExistUser['online_status'] == 1) {
                                                echo 'online';
                                            } else
                                                echo 'offline';
                                        } else
                                            echo 'offline';
                                        ?>-status-div
                                    ">
                                        </div>
                                    </div>
                                    <div class="sender-info-container">
                                        <h4 class="user-name">
                                            <?php
                                            if ($notExistUser['name'] !== null && $notExistUser['lastname'] !== null) {
                                                echo $notExistUser['name'] . ' ' . $notExistUser['lastname'];
                                            } else {
                                                echo $notExistUser['username'];
                                            }
                                            ?>
                                        </h4>
                                        <!-- <p class="user-description">Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p> -->

                                    </div>
                                    <div class="count-unread-div unread-msg-div-<?php echo $receiver_id; ?>"
                                        style="display:<?php echo $br != 0 ? 'flex' : 'none' ?>">
                                        <?php
                                        echo $br != 0 ? $br : "";
                                        $br = 0;
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                    if ($users !== NULL) {
                        foreach ($users as $userData) {
                            foreach ($unreadData as $countUnread) {
                                if ($countUnread['sender_id'] == $userData[0]) {
                                    $br = $countUnread['count_unread'];
                                }
                            }
                            $notEmptyUsersDiv = true;
                            $klasa = '';
                            if (isset($_GET['id']) && $userData[0] == $receiver_id) {
                                $klasa = 'needClick';
                            }
                            ?>
                            <div class="header-div">
                                <!-- Prepraviti da se ovo cuva u local storage -->
                                <input type="hidden" name="" id="login-user-id" value="<?php echo $_SESSION['user_id']; ?>">
                                <input type="hidden" name="" id="user-token" value="<?php echo $token; ?>">
                            </div>
                            <div class="sender-container <?php echo $klasa ?>">
                                <input type="hidden" name="" id="user-id" value="<?php echo $userData[0] ?>">
                                <div class="profile-image-status">
                                    <img src="../public/src/userShow2.svg">
                                    <div id="status-div-<?php echo $userData[0] ?>" class="
                                            <?php
                                            if ($userData[16] == 1) {
                                                if ($userData[17] == 1) {
                                                    echo 'online';
                                                } else
                                                    echo 'offline';
                                            } else
                                                echo 'offline';
                                            ?>-status-div
                                        ">
                                    </div>
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
                                    <!-- <p class="user-description"> -->
                                    <?php
                                    // $msg->setReceiverId($_SESSION['user_id']);
                                    // $msg->setSenderId($userData[0]);
                                    // $messagesEncoded = $msg->returnLastMessage();
                                    // if ($messagesEncoded != NULL) {
                                    //     $lastMessage = $messagesEncoded[0]['msg'];
                                    //     if (strlen($lastMessage) > 55) {
                                    //         $lastMessage = substr($lastMessage, 0, 55);
                                    //         $lastMessage .= '...';
                                    //     }
                                    //     if ($messagesEncoded[0]['status'] == 0) {
                                    //         echo "<b>" . $lastMessage . "</b>";
                                    //     } else {
                                    //         echo $lastMessage;
                                    //     }
                                    // }
                                    ?>
                                    <!-- </p> -->

                                </div>
                                <div class="count-unread-div unread-msg-div-<?php echo $userData[0]; ?>"
                                    style="display:<?php echo $br != 0 ? 'flex' : 'none' ?>">
                                    <?php
                                    echo $br != 0 ? $br : "";
                                    $br = 0;
                                    ?>
                                </div>
                            </div>
                        <?php }

                    } else if (!$notEmptyUsersDiv) { ?>
                            <div class="no-user-selected">
                                <img src="../public/src/begin-chat.svg" style="width: 60%">
                                <h4>Nemate poruke nisakim</h4>
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
    <script src="../public/js/messages.js?=<?php echo time(); ?>" type="module"></script>
    <script src="../public/js/login-script.js?v=<?php echo time(); ?>" type="text/javascript"></script>
</body>

</html>