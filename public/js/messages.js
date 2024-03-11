const chatDiv = document.querySelector(".chat-form-div");
const usersDiv = document.querySelector(".users-div");
const mainChatDiv = document.querySelector('.main-chat-div');

let receiverId = '';
let con;
$(document).ready(function () {
    let token = $('#user-token').val();
    con = new WebSocket(`ws://localhost:8080?token=${token}`);
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
        }

        if(data.action == "update_seen"){
            console.log();
            showDeliveredOrSeenIcon();
        }

        let klasa = "";
        if (data.from == "Me") {
            klasa = "sender-div";
        }
        else {
            klasa = "receiver-div";
        }

        if (receiverId == data.userId || data.from == "Me") {
            showDeliveredOrSeenIcon('none');
            let htmlData = `
                <div class=${klasa} style="margin-bottom: 5px;" onclick="showHideTime(this)" title="${data.dt.slice(0, 10)}"> 
                    <p class="message-data">${data.message}</p>
                    <small class="small-data" style="display: none">
                        ${data.dt.slice(-8).slice(0, 5)}
                    </small>
                    <img src="../public/src/delivered-icon.svg" style="display:none; width:16px; height:16px;"></img>
                </div>
                    `;
            $('.chat-div').append(htmlData);
            $('.chat-form-div .chat-div').scrollTop($('.chat-form-div .chat-div')[0].scrollHeight);
            if(klasa == "receiver-div"){
                let obj = {
                    action: "update_seen",
                    receiverId : data.userId,
                    senderId : data.receiverId,
                    msgId : data.msg_id
                }
                con.send(JSON.stringify(obj));
            }
            showDeliveredOrSeenIcon();
        }
        else {
            console.log("Primio si poruku");
            let count = $(`.count-unread-div.unread-msg-div-${data.userId}`).text();
            showDeliveredOrSeenIcon('none');
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

    const mainElement = document.querySelector(".messages-main-div");
    mainElement.classList.remove('deactive');
    mainElement.classList.add('active');

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
                            seen = "delivered-icon.svg";
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
                        <div class=${klasa} style="margin-bottom: 5px;" onclick="showHideTime(this)" title="${getMounthAndYear(response[i].sent_at)}"> 
                            <p class="message-data">${response[i].msg}</p>
                            <small class="small-data" style="display: none">
                                ${getHoursAndMinutes(response[i].sent_at)}
                            </small>
                            <img src="../public/src/${seen}" style="display:none; width:16px; height:16px;"></img>
                        </div>
                            `;
                    // <img src="icons/${seen}" style="display:${displaySeen}; width:16px; height:16px;"></img>

                    $('.chat-div').append(htmlData);
                    $('.chat-div').scrollTop($('.chat-div')[0].scrollHeight);
                }
                let obj = {
                    action: "update_seen",
                    receiverId : receiverId
                }
                con.send(JSON.stringify(obj));
                showDeliveredOrSeenIcon();
            }
        });
}

function showDeliveredOrSeenIcon(show = 'block') {
    const senderDivs = document.querySelectorAll(".sender-div");
    const lastSenderDiv = senderDivs[senderDivs.length - 1];
    if (lastSenderDiv !== undefined) {
        const imgElement = lastSenderDiv.querySelector('img');
        imgElement.style.display = show;
    }
}


function showHideTime(div) {
    const element = div.querySelector('small');
    const dValue = element.style.display;
    if (dValue === 'none') {
        element.style.display = 'block';
    } else {
        element.style.display = 'none';
    }
}

function getHoursAndMinutes(dateTimeString) {
    const dateTime = new Date(dateTimeString);
    const hours = dateTime.getHours();
    const minutes = dateTime.getMinutes();
    const formattedTime = (hours < 10 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes;
    return formattedTime;
}

function getMounthAndYear(dateTimeString) {
    const dateTime = new Date(dateTimeString);
    const month = dateTime.getMonth() + 1;
    const day = dateTime.getDate();
    const year = dateTime.getFullYear();
    const formattedTime = (day < 10 ? '0' : '') + day + '-' + (month < 10 ? '0' : '') + month + '-' + year.toString();
    return formattedTime;
}

function makeChatArea(receiverName) {
    var html =
        `
    <div class="chat-form-div">
        <div class="chat-header-container">
            <img class="back-message" src="../public/src/arrow-back.svg" style="width: 20px"/>
            <div class="chat-main-profile-image">
                <img src="../public/src/userShow2.svg">
            </div>
            <h3>${receiverName}<h3>
        </div>
        <div class="chat-main-div">
            <div class="chat-second-div">
                <form action="" method="post" id="chat-form">
                    <div class="send-div">
                        <textarea class="send-input" rows="1" id="send-input" placeholder="Poruka..."></textarea>
                        <button type="submit" class="send-btn">
                            <img src="../public/src/arrow-up.svg" width="30"/>
                        </button>
                    </div>
                </form>
                <div class="chat-div">
                
                </div>
            </div> 
        </div> 
    </div>
    `;
    $('.main-chat-div').html(html);

    const textarea = document.querySelector('#send-input');
    textarea.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    })

    const textareabutton = document.querySelector('.send-btn');
    textareabutton.addEventListener('click', function () {
        textarea.style.height = 'auto';
    });

    const backmessage = document.querySelector('.back-message');
    backmessage.addEventListener('click', function () {
        const mainElement = document.querySelector(".messages-main-div");
        mainElement.classList.remove('active');
        mainElement.classList.add('deactive');
    })
}

