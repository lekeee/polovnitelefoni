const chatDiv = document.querySelector(".chat-form-div");
const usersDiv = document.querySelector(".users-div");
const mainChatDiv = document.querySelector('.main-chat-div');

let receiverId = '';
$(document).ready(function () {
    let token = $('#user-token').val();
    let con = new WebSocket(`ws://localhost:8080?token=${token}`);
    let user_id = $('#login-user-id').val();


    con.onopen = function (e) {
        console.log("uspesna konekcija!");
    }

    con.onmessage = function (e) {
        let data = JSON.parse(e.data);

        if (data.status_type == "Online") {
            $(`#status-div-${data.user_id_status}`).removeClass("offline-status-div");
            $(`#status-div-${data.user_id_status}`).addClass("online-status-div");
        }
        else if (data.status_type == "Offline") {
            $(`#status-div-${data.user_id_status}`).removeClass("online-status-div");
            $(`#status-div-${data.user_id_status}`).addClass("offline-status-div");
            //! DODATI FETCH
        }

        let klasa = "";
        if (data.from == "Me") {
            klasa = "sender-div";
        }
        else {
            klasa = "receiver-div";
        }

        if (receiverId == data.userId || data.from == "Me") {
            let htmlData = `
                <div class=${klasa}> 
                    ${data.message}
                    <br/>
                    <small class="small-data">
                        <b>${data.from}</b> 
                        <i>${data.dt}</i>
                    </small> 
                </div>
                `;

            $('.chat-div').append(htmlData);
            $('.chat-form-div .chat-div').scrollTop($('.chat-form-div .chat-div')[0].scrollHeight);
        }
        else {
            let count = $(`.count-unread-div.unread-msg-div-${data.userId}`).text();

            if (count == '') {
                count = 0;
            }
            count++;
            $(`.count-unread-div.unread-msg-div-${data.userId}`).text(count);
            $(`.count-unread-div.unread-msg-div-${data.userId}`).css('display', 'flex');
        }
    }

    con.onclose = function (e) {
        console.log("zatvorena konekcija");
    }

    $('.main-chat-div').on('submit', '#chat-form', function (e) {
        e.preventDefault();

        let msg = $('#send-input').val();

        if (msg.length !== 0) {
            let data = {
                userId: user_id,
                message: msg,
                receiverId: receiverId,
            }

            con.send(JSON.stringify(data));
        }

        $('.send-input').val('');
    });

})

function removeAllActiveSender() {
    const senders = document.querySelectorAll('.sender-container');
    senders.forEach(element => {
        element.classList.remove('active');
    });
}

async function showMessages(div) {
    removeAllActiveSender();
    div.classList.add('active');
    let user_id = $('#login-user-id').val();
    receiverId = div.querySelector("#user-id").value;
    let receiverName = div.querySelector(".user-name").innerHTML;

    $(`.unread-msg-div-${receiverId}`).text("");
    $(`.unread-msg-div-${receiverId}`).css('display', 'none');
    makeChatArea(receiverName);

    await fetch("../app/controllers/messagesController.php", {
        method: "POST",
        body: JSON.stringify({
            action: "fetch_chat",
            userId: user_id,
            receiverId: receiverId
        }),
        headers: {
            "Content-Type": "application/json"
        }
    })
        .then((response) => response.json())
        .then(function (response) {
            console.log(response);
            if (response.length > 0) {
                let klasa = "";
                let from = "";
                let seen = "";
                let displaySeen = "";
                for (let i = 0; i < response.length; i++) {
                    if (response[i].sender_id == user_id) {
                        klasa = "sender-div";
                        from = "Me";
                        if (response[i].status == 0) {
                            seen = "not-seen-icon.svg";
                        }
                        else {
                            seen = "seen-icon.svg"
                        }
                        displaySeen = "inline-block";
                    }
                    else {
                        klasa = "receiver-div";
                        from = receiverName;
                        displaySeen = "none";
                    }


                    let htmlData = `
                <div class=${klasa}> 
                    <p class="message-data">${response[i].msg}</p>
                    <small class="small-data">
                        <i>${response[i].sent_at}</i>
                    </small> 
                        </div>
                        `;
                    // <img src="icons/${seen}" style="display:${displaySeen}; width:16px; height:16px;"></img>

                    $('.chat-div').append(htmlData);
                    $('.chat-div').scrollTop($('.chat-div')[0].scrollHeight);
                }
            }
        });
}

function makeChatArea(receiverName) {
    var html =
        `
    <div class="chat-form-div">
        <div class="chat-header-container">
            <div class="chat-main-profile-image">
                <img src="../public/src/userShow2.svg">
            </div>
            <h3>${receiverName}<h3>
        </div>
        <div class="chat-main-div">
            <div class="chat-second-div">
                <form action="" method="post" id="chat-form">
                    <div class="send-div">
                        <input type="text" class="send-input" name="" id="send-input">
                        <button type="submit" class="send-btn"><i class="material-icons">send</i></button>
                    </div>
                </form>
                <div class="chat-div">
                
                </div>
            </div> 
        </div> 
    </div>
    `;
    $('.main-chat-div').html(html);
}