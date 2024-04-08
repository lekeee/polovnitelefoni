const showNewPassword = document.querySelector("#showNewPassword");
const hideNewPassword = document.querySelector("#hideNewPassword");
const showRepeatedPassword = document.querySelector("#showRepeatedPassword");
const hideRepeatedPassword = document.querySelector("#hideRepeatedPassword");

showNewPassword.addEventListener('click', function () {
    this.style.display = 'none';
    hideNewPassword.style.display = 'block';
    const password = document.querySelector('#newPassword');
    password.type = 'text';
});
hideNewPassword.addEventListener('click', function () {
    this.style.display = 'none';
    showNewPassword.style.display = 'block';
    const password = document.querySelector('#newPassword');
    password.type = 'password';
});

showRepeatedPassword.addEventListener('click', function () {
    this.style.display = 'none';
    hideRepeatedPassword.style.display = 'block';
    const password = document.querySelector('#repeatedPassword');
    password.type = 'text';
});
hideRepeatedPassword.addEventListener('click', function () {
    this.style.display = 'none';
    showRepeatedPassword.style.display = 'block';
    const password = document.querySelector('#repeatedPassword');
    password.type = 'password';
});

const updatePasswordBtn = document.querySelector("#updatePassword");
updatePasswordBtn.addEventListener("click", function (e) {
    e.preventDefault();
    const newPassword = document.querySelector("#newPassword");
    const repeatedPassword = document.querySelector("#repeatedPassword");

    if (newPassword.value.trim() === '') {
        alert("Morate uneti novu lozinku");
        return;
    } else if (newPassword.value.length < 8) {
        alert("Lozinka mora biti duza od 8 karaktera");
        return;
    } else if (repeatedPassword.value.trim() === '') {
        alert("Morate potvrditi novu lozinku");
        return;
    } else if (newPassword.value !== repeatedPassword.value) {
        alert("Lozinke se ne poklapaju");
        return;
    }

    startLoadingAnimation();
    const user_id = this.getAttribute('uid-value');

    fetch('../app/controllers/resetPasswordController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'resetPassword',
            user_id: user_id,
            newPassword: newPassword.value
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
            // console.log(data);
            stopLoadingAnimation();
            if (data.status === 'success') {
                verifyDone();
            } else {
                alert("Došlo je do greške, molimo Vas pokušajte kasnije!");
            }
        })
        .catch(error => {
            stopLoadingAnimation();
            alert("Došlo je do greške, molimo Vas pokušajte kasnije! Greška: " + error);
            //console.log('Greska:', error);
        });
});

function verifyDone() {
    document.querySelector('#updatePassword').style.display = "none";
    document.querySelector("#updatedPassword").style.display = "flex";
}

function startLoadingAnimation() {
    var submitButton = document.querySelector("#updatePassword");
    const waitImage = new Image();
    waitImage.src = submitButton.getAttribute('data-wait');

    submitButton.innerHTML = '';

    submitButton.style.backgroundImage = `url('${waitImage.src}')`;
    submitButton.style.backgroundSize = '7%';
    submitButton.style.backgroundRepeat = 'no-repeat';
    submitButton.style.backgroundPosition = 'center';
    submitButton.disabled = true;
}
function stopLoadingAnimation() {
    var submitButton = document.querySelector(`#updatePassword`);
    submitButton.innerHTML = submitButton.getAttribute('data-value');
    submitButton.style.backgroundImage = 'none';
    submitButton.disabled = false;
}