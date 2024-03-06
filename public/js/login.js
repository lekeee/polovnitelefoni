const loginForm = document.querySelector('#wf-form-Email-Form-1');
let email = '';
loginForm.addEventListener('submit', function (e) {
    e.preventDefault();

    startLoadingAnimation("login-submit");

    const loginErrorDiv = document.querySelector('#login-error-div');
    const loginErrorDiv2 = loginErrorDiv.querySelector('#login-error-div2');
    loginErrorDiv2.classList.remove("animate");
    loginErrorDiv.style.display = "none";

    email = loginForm.querySelector('#login-email').value;
    const password = loginForm.querySelector('#login-password').value;
    login(email, password);
});

function login(email, password) {
    fetch('../app/controllers/userController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'login',
            email: email,
            password: password
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
            stopLoadingAnimation("login-submit");
            if (data.status === 'error') {
                showNotification2(4, data.message, true);
            } else {
                console.log('Uspesno ste se prijavili.');
                window.location.href = "../views/index.php";
                //showNotification(2, email);
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}

function showNotification2(action, data, resend = false) {
    const loginErrorDiv = document.querySelector('#login-error-div');
    loginErrorDiv.style.display = 'block';
    setTimeout(() => {
        const loginErrorDiv2 = loginErrorDiv.querySelector('#login-error-div2');
        const loginError = loginErrorDiv.querySelector('#login-error');
        const boldText = loginError.querySelector('b');
        let errorText = loginError.querySelector('span');

        if (action === 1) {
            errorText.innerHTML = data;
        } else if (action === 2) {
            boldText.innerHTML = "Obaveštenje";
            errorText.innerHTML = `Na Vašu email adresu (${data}) smo poslasli verifikacioni link. Molimo vas da verifikujete email adresu a nakon toga ćete moći da se prijavite.<br><span onclick='resendVerificationLink("${data}")' style="color: var(--blue-color); text-decoration: none; cursor: pointer;">Ponovo posalji verifikacioni link</span>`;
        } else if (action === 3) {
            boldText.innerHTML = "Obaveštenje";
            errorText.innerHTML = "Na Vašu email adresu (<b>" + data + "</b>) smo poslali verifikacioni kod.";
        } else if (action === 4) {
            boldText.innerHTML = "Obaveštenje";
            if (resend) {
                const link = `<p class='resend-link' onclick="getEmailFromUsername('${email}')" style='cursor: pointer; color: #0086e6; display: inline-block; margin-left: 5px;'>Pošalji verifikacioni mail</p>`;
                data += link;
            }
            errorText.innerHTML = data;
        } else if (action === 5) {
            boldText.innerHTML = "Greška";
            errorText.innerHTML = data;
        } else {
            boldText.innerHTML = "Obaveštenje";
            errorText.innerHTML = `Uspešno ste se registrovali. Na Vašu email adresu ('${data}') smo poslasli verifikacioni link. Molimo vas da verifikujete email adresu da biste mogli da koristite nalog.`;
        }

        loginErrorDiv2.classList.toggle('animate');
    }, 100);
}


async function getEmailFromUsername(usernameORemail) {
    const element = document.querySelector('.resend-link');
    element.innerHTML = "Šalje se...";
    element.removeAttribute('onclick');
    element.style.cursor = "default";
    await fetch('../app/controllers/userController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'getEmailAddress',
            username: usernameORemail
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
            if (data.status === 'error') {
                showNotification2(1, "Došlo je do greške prilikom slanja verifikacionog email-a. Molimo pokupajte kasnije");
            } else {
                resendVerificationLink2(data.message);
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}


function resendVerificationLink2(email) {
    fetch('../app/controllers/verificationController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'resend',
            email: email
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
            if (data.status === 'error') {
                showNotification2(1, data.message);
            } else {
                // showNotification2(2, email);
                const element = document.querySelector('.resend-link');
                element.innerHTML = "Poslato";
                element.removeAttribute('onclick');
                element.style.cursor = "default";
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}

const showPassword = document.querySelector('#login-show-password');
const hidePassword = document.querySelector('#login-hide-password');

showPassword.addEventListener('click', function () {
    this.style.display = 'none';
    hidePassword.style.display = 'block';
    const password = loginForm.querySelector('#login-password');
    password.type = 'text';
});
hidePassword.addEventListener('click', function () {
    this.style.display = 'none';
    showPassword.style.display = 'block';
    const password = loginForm.querySelector('#login-password');
    password.type = 'password';
});


const forgotPassword = document.querySelector("#forgotPassword");
forgotPassword.addEventListener("click", async function (e) {
    if (this.getAttribute('href')) {
        e.preventDefault();
        const email = document.querySelector('#login-email').value;
        if (email.trim() === '') {
            showNotification2(5, "Morate uneti vaše korisničko ime ili email adresu da biste resetovali lozinku");
            return;
        } else {
            const loginErrorDiv = document.querySelector('#login-error-div');
            const loginErrorDiv2 = loginErrorDiv.querySelector('#login-error-div2');
            loginErrorDiv2.classList.remove("animate");
            loginErrorDiv.style.display = "none";
            this.removeAttribute("href");
            this.querySelector('div').innerHTML = "Molimo sačekajte...";
        }

        await fetch('../app/controllers/resetPasswordController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'sendReset',
                email: email
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
                this.querySelector('div').innerHTML = "Zaboravili ste lozinku?";
                if (data.status === 'success') {
                    showNotification2(4, "Na Vašu email adresu smo poslali link za resetovanje lozinke. Nakon što resetujete lozinku moći ćete da se prijavite!");
                } else {
                    showNotification2(5, "Došlo je do greške, molimo Vas pokušajte kasnije!");
                }
            })
            .catch(error => {
                alert("Došlo je do greške, molimo Vas pokušajte kasnije!");
            });
    }
});

