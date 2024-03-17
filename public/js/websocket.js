let token = localStorage.getItem('token');
let con;

con = new WebSocket(`ws://localhost:8080?token=${token}`);

con.onopen = function(e){
    console.log("uspesna konekcija");
}

con.onmessage = function(e){
    let data = JSON.parse(e.data);
    
    if(data.message !== undefined){
        document.getElementById('audio-tag').muted = false;
        document.getElementById('audio-tag').play();
        document.title = "Nova poruka";
    }
}

con.onclose = function(e){
    console.log("zatvorena konekcija");
}

export { con };