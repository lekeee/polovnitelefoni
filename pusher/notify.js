
let pusher = new Pusher('3d990468bac14b8556de', {
    cluster: 'eu'
});

let notifyChannel = pusher.subscribe('channel-notification');
notifyChannel.bind('notifyuser', function(data){
    document.getElementById('audio-tag').muted = false;
    document.getElementById('audio-tag').play();
    document.title = "Nova poruka";
    const msgButton = document.querySelector('.message-btn-container');
    if (msgButton !== null && msgButton !== undefined) {
        //moze da se prosledi i koliko neprocitanih ima
        msgButton.classList.add('animate');
    }
});