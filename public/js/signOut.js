function signOut(){
    fetch('../app/controllers/userController.php',{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'signout',
        })
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        } else {
            throw new Error('Doslo je do greske prilikom prihvatanja zahteva.');
        }
    })
    .then(data => {
        const stat = data.status;
        if(stat === 'success'){
            window.location.href = "../views/index.php";
        }
        else{
            console.log("Doslo je do greske");
        }
    })
    .catch(error => {
        console.log('Greska:', error);
    });
}