window.addEventListener('DOMContentLoaded', async function() {
    await fetch('../pusher/pusherController.php', {
        method: "POST",
        body: JSON.stringify({action: 'status', status: 'online' }),
        headers: {
            "Content-Type": "application/json"
        }
    })
    .catch(function(error) {
        console.error('Fetch error:', error);
    });;
});

// window.addEventListener('beforeunload', function() {
//     fetch('../pusher/pusherController.php', {
//         method: 'POST',
//         body: JSON.stringify({action: 'status', status: 'offline' }),
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         async: false // Ovo je važno kako biste osigurali da se zahtev za ažuriranje statusa korisnika završi pre nego što korisnik napusti stranicu
//     })
//     .catch(function(error) {
//         console.error('Fetch error:', error);
//     });;
// });


var isOnIOS = navigator.userAgent.match(/iPad/i)|| navigator.userAgent.match(/iPhone/i);
var eventName = isOnIOS ? "pagehide" : "beforeunload";

window.addEventListener(eventName, function (event) { 
    event.stopPropagation();
    navigator.sendBeacon('../pusher/pusherController.php', JSON.stringify({action: 'status', status: 'offline' }));
} );


