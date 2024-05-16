const mainChatDiv = document.querySelector('.main-chat-div');
const needClickContainer = document.querySelector('.needClick');
const senderContainers = document.querySelectorAll('.sender-container');
const searchBar = document.querySelector("#search-bar");
let userElements = [];
let receiverId = '';
let user_id = $('#login-user-id').val();
let chatChannelCreated = false;
let id1 = 0, id2 = 0;

let pusher = new Pusher('3d990468bac14b8556de', {
    cluster: 'eu'
});

let notifyChannel = pusher.subscribe('channel-notification');
notifyChannel.bind('notifyuser', function(data){
    if(data.user_id == user_id && !chatChannelCreated){
        let count = $(`.count-unread-div.unread-msg-div-${data.from_user}`).text();
        if (count == '') {
            count = 0;
        }
        count++;
        $(`.count-unread-div.unread-msg-div-${data.from_user}`).text(count);
        $(`.count-unread-div.unread-msg-div-${data.from_user}`).css('display', 'flex');
    }
});

notifyChannel.bind('updateseen', function(data){
    if (data.action == "update_seen" ) {
        if(data.receiver_id == user_id)
            showDeliveredOrSeenIcon('block', true);
        if(data.sender_id == user_id && data.msg_id != null)
            showDeliveredOrSeenIcon('block', true);
    }
});

mainChatDiv.addEventListener('submit', async function send(e){
    e.preventDefault();
    const messageInput = document.querySelector('.send-input');
    let message = messageInput.value;
    await fetch('../pusher/pusherController.php', {
        method: 'POST',
        body: JSON.stringify({
            action: "sendmessage",
            user_id: user_id,
            receiver_id: receiverId,
            message: message
        }),
        headers: {
            'Content-Type' : 'application/json'
        }
    }).then(response => {
        //console.log(response)
        messageInput.value = '';
    })
    .catch(error => console.log(error));
});

function removeAllActiveSender() {
    const senders = document.querySelectorAll('.sender-container');
    senders.forEach(element => {
        element.classList.remove('active');
    });
}

export async function showMessages(div) {
    const mainElement = document.querySelector(".messages-main-div");
    mainElement.classList.remove('deactive');
    mainElement.classList.add('active');

    removeAllActiveSender();
    div.classList.add('active');
    receiverId = div.querySelector("#user-id").value;
    let receiverName = div.querySelector(".user-name").innerHTML;
    
    $(`.unread-msg-div-${receiverId}`).text("");
    $(`.unread-msg-div-${receiverId}`).css('display', 'none');
    makeChatArea(receiverName, receiverId);

    await fetch("../pusher/pusherController.php", {
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
        let numberChanged = response.numberChanged;
        response = response.messages;
        if (response.length > 0) {
            let klasa = "", from = "", seen = "", displaySeen = "";
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
                    <div class=${klasa} style="margin-bottom: 5px;" title="${getMounthAndYear(response[i].sent_at)}"> 
                        <p class="message-data">${response[i].msg}</p>
                        <small class="small-data" style="display: none">
                            ${getHoursAndMinutes(response[i].sent_at)}
                        </small>
                        <img src="../public/src/${seen}" style="display:none; width:16px; height:16px; margin-top: 2px"></img>
                    </div>
                        `;
                $('.chat-div').append(htmlData);
                $('.chat-div').scrollTop($('.chat-div')[0].scrollHeight);
            }
            if (response[response.length - 1].receiver_id == user_id && numberChanged != 0) {
                sendSeenNotification(user_id, receiverId);
            }
            else {
                showDeliveredOrSeenIcon();
            }
            setShowHide();
        }
            id1 = user_id; id2 = receiverId;
            [id1, id2] = compareIds(id1, id2);

            //console.log('channel-' + id1 + id2)
            let channel = pusher.subscribe('channel-' + id1 + id2);

            channel.bind('sendmessage', function(data){
                chatChannelCreated = true;
                let klasa = "";
                if (data.user_id == user_id) {
                    klasa = "sender-div";
                }
                else {
                    klasa = "receiver-div";
                }
                //if (receiverId == data.user_id || user_id == data.user_id) {
                if (receiverId != null && (receiverId == data.user_id || user_id == data.user_id)) {
                    showDeliveredOrSeenIcon('none');
                    let htmlData = `
                        <div class=${klasa} style="margin-bottom: 5px;" title="${data.dt.slice(0, 10)}"> 
                            <p class="message-data">${data.message}</p>
                            <small class="small-data" style="display: none">
                                ${data.dt.slice(-8).slice(0, 5)}
                            </small>
                            <img src="../public/src/delivered-icon.svg" style="display:none; width:16px; height:16px; margin-top: 2px"></img>
                        </div>
                            `;
                    $('.chat-div').append(htmlData);
                    setShowHide();
            
                    $('.chat-form-div .chat-div').scrollTop($('.chat-form-div .chat-div')[0].scrollHeight);
                    //update seen
                    if (klasa == "receiver-div") {
                        sendSeenNotification(receiverId, user_id, data.msg_id);
                        console.log('odje duva1')
                    }
                    showDeliveredOrSeenIcon();

                    // document.querySelector('.back-message').addEventListener('click', function(){
                    //     pusher.unsubscribe('channel-' + id1 + id2);
                    //     chatChannelCreated = false;
                    //     console.log('unsub');
                    //     $(`.count-unread-div.unread-msg-div-${data.from_user}`).text(0);
                    // });
                }
                else{
                    console.log('dodaj')
                    let count = $(`.count-unread-div.unread-msg-div-${data.user_id}`).text();
                    if (count == '') {
                        count = 0;
                    }
                    count++;
                    $(`.count-unread-div.unread-msg-div-${data.user_id}`).text(count);
                    $(`.count-unread-div.unread-msg-div-${data.user_id}`).css('display', 'flex');
                }
            });
        
    });
}

async function sendSeenNotification(sender_id, receiver_id, msg_id = null){
    await fetch("../pusher/pusherController.php", {
        method: "POST",
        body: JSON.stringify({
            action: "update_seen",
            sender_id: sender_id,
            receiver_id: receiver_id,
            msg_id: msg_id
        }),
        headers: {
            "Content-Type" : "application/json"
        }
    }).then(response => {})
    .catch(error => console.log(error));
}

function compareIds(id1, id2){
    if(parseInt(id1) > parseInt(id2)){
        let pom = id2;
        id2 = id1;
        id1 = pom;
    }
    return [id1, id2];
}

document.addEventListener('DOMContentLoaded', () => {
    const senderContainers = document.querySelectorAll('.sender-container');

    senderContainers.forEach(container => {
        container.addEventListener('click', () => {
            showMessages(container);
        });
    });
    if (needClickContainer !== null && needClickContainer !== undefined) {
        needClickContainer.click();
    }
});

function showDeliveredOrSeenIcon(show = 'block', seen = false) {
    const senderDivs = document.querySelectorAll(".sender-div");
    const lastSenderDiv = senderDivs[senderDivs.length - 1];
    if (lastSenderDiv !== undefined) {
        const imgElement = lastSenderDiv.querySelector('img');
        if (seen) {
            imgElement.src = "../public/src/seen-icon.svg";
        }
        imgElement.style.display = show;
    }
}

function setShowHide() {
    const senderDivs = document.querySelectorAll('.sender-div');
    const receiverDivs = document.querySelectorAll('.receiver-div');

    senderDivs.forEach(element => {
        element.addEventListener("click", function () {
            showHideTime(element);
        })
    });

    receiverDivs.forEach(element => {
        element.addEventListener("click", function () {
            showHideTime(element);
        })
    });
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

function makeChatArea(receiverName, receiverId) {
    var html =
        `
    <div class="chat-form-div">
        <div class="chat-header-container">
            <img class="back-message" src="../public/src/arrow-back.svg" style="width: 20px"/>
            <div class="chat-main-profile-image" style="cursor: pointer;" onclick="window.location.href='../views/user.php?id=${receiverId}'">
                <img src="../public/src/userShow2.svg">
            </div>
            <h3 onclick="window.location.href='../views/user.php?id=${receiverId}'">${receiverName}<h3>
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

        pusher.unsubscribe('channel-' + id1 + id2);
        chatChannelCreated = false;
        //console.log('unsub');
    })
}

senderContainers.forEach(container => {
    const usernameElement = container.querySelector('.user-name');
    const username = usernameElement.textContent.trim();
    userElements.push({ username: username.toLowerCase(), element: container });
});

searchBar.addEventListener("input", e => {
    const value = e.target.value;
    userElements.forEach(p => {
        const isVisible = p.username.includes(value.toLowerCase());
        p.element.classList.toggle("hide", !isVisible);
    })
});
