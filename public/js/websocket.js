let con;

con = new WebSocket(`wss://185.119.89.240:8443?token=${localStorage.getItem('token')}`);

con.onopen = function (e) {
    console.log("uspesna konekcija");
}

con.onmessage = function (e) {
    let data = JSON.parse(e.data);

    if (data.message !== undefined) {
        document.getElementById('audio-tag').muted = false;
        document.getElementById('audio-tag').play();
        document.title = "Nova poruka";
        const msgButton = document.querySelector('.message-btn-container');
        if (msgButton !== null && msgButton !== undefined) {
            msgButton.classList.add('animate');
        }
    }
}

con.onclose = function (e) {
    localStorage.removeItem('token');
    console.log("zatvorena konekcija");
}

export { con };
