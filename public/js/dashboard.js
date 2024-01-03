const deleteBtn = document.querySelector("#delete-button");
const deleteInput = document.querySelector("#delete-password");

deleteBtn.addEventListener('click', function () {
    const deleteText = deleteInput.value;
    fetch('../app/controllers/userController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'delete-account',
            username: deleteText
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
            console.log(data);
            if (data['status'] === 'success') {
                window.location.href = "../views/index.php";
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
});