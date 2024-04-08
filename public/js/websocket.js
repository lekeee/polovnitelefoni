let con;

const addressS = `wss://185.119.89.240?token=${localStorage.getItem('token')}`;

con = new WebSocket(addressS, {
    headers:{
        'user-agent': 'Mozilla'
    }
});
//con = new WebSocket(`wss://polovni-telefoni.rs`);

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
