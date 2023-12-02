const loginForm = document.querySelector('#wf-form-Email-Form-1');
loginForm.addEventListener('submit', function(e){
    e.preventDefault();

    startLoadingAnimation("login-submit");

    const loginErrorDiv = document.querySelector('#login-error-div');
    const loginErrorDiv2 = loginErrorDiv.querySelector('#login-error-div2');
    loginErrorDiv2.classList.remove("animate");
    loginErrorDiv.style.display = "none";

    const email = loginForm.querySelector('#login-email').value;
    const password = loginForm.querySelector('#login-password').value;
    login(email, password);
});

function login(email, password){
    fetch('../app/controllers/userController.php',{
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
        if(data.status === 'error'){
            console.log(data.message);
            showNotification2(1, data.message);
        }else{
            console.log('Uspesno ste se prijavili.');
            window.location.href = "../views/index.php";
            //showNotification(2, email);
        }
    })
    .catch(error => {
        console.log('Greska:', error);
    });
}

function showNotification2(action, data){
    const loginErrorDiv = document.querySelector('#login-error-div');
    loginErrorDiv.style.display = 'block';
    setTimeout(()=>{
        const loginErrorDiv2 = loginErrorDiv.querySelector('#login-error-div2');
        const loginError = loginErrorDiv.querySelector('#login-error');
        const boldText= loginError.querySelector('b');
        const errorText = loginError.querySelector('span');

        if(action === 1){
            errorText.innerHTML = data;
        }else{
            boldText.innerHTML = "Obaveštenje";
            errorText.innerHTML = `Uspešno ste se registrovali. Na Vašu email adresu ('${data}') smo poslasli verifikacioni link. Molimo vas da verifikujete email adresu da biste mogli da koristite nalog.`;
        }

        loginErrorDiv2.classList.toggle('animate');
    }, 100);
}

const showPassword = document.querySelector('#login-show-password');
const hidePassword = document.querySelector('#login-hide-password');

showPassword.addEventListener('click', function(){
    this.style.display = 'none';
    hidePassword.style.display = 'block';
    const password = loginForm.querySelector('#login-password');
    password.type = 'text';
});
hidePassword.addEventListener('click', function(){
    this.style.display = 'none';
    showPassword.style.display = 'block';
    const password = loginForm.querySelector('#login-password');
    password.type = 'password';
});
