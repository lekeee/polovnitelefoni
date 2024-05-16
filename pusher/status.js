window.addEventListener('DOMContentLoaded', async function() {
    await fetch('../pusher/pusherController.php', {
        method: "POST",
        body: JSON.stringify({action: 'status', status: 'online' }),
        headers: {
            "Content-Type": "application/json"
        }
    });
});

window.addEventListener('beforeunload', function() {
    fetch('../pusher/pusherController.php', {
        method: 'POST',
        body: JSON.stringify({action: 'status', status: 'offline' }),
        headers: {
            'Content-Type': 'application/json'
        },
        async: false // Ovo je važno kako biste osigurali da se zahtev za ažuriranje statusa korisnika završi pre nego što korisnik napusti stranicu
    });
});