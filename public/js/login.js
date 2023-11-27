const loginForm = document.querySelector('#wf-form-Email-Form-1');
loginForm.addEventListener('submit', function(e){
    e.preventDefault();

    startLoadingAnimation();

    const loginErrorDiv = document.querySelector('#login-error-div');
    const loginErrorDiv2 = loginErrorDiv.querySelector('#login-error-div2');
    loginErrorDiv2.classList.remove("animate");
    loginErrorDiv.style.display = "none";

    const email = loginForm.querySelector('#login-email').value;
    const password = loginForm.querySelector('#login-password').value;
    login(email, password);
});

function startLoadingAnimation(){
    var submitButton = document.querySelector("#login-submit");
    const originalValue = submitButton.value;
    const waitImage = new Image();
    waitImage.src = submitButton.getAttribute('data-wait');

    submitButton.value = '';

    submitButton.style.backgroundImage = `url('${waitImage.src}')`;
    submitButton.style.backgroundSize = '7%';
    submitButton.style.backgroundRepeat = 'no-repeat';
    submitButton.style.backgroundPosition = 'center';
}

function stopLoadingAnimation(){
    var submitButton = document.querySelector("#login-submit");
    submitButton.value = submitButton.getAttribute('data-value');
    submitButton.style.backgroundImage = 'none';
}

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
        stopLoadingAnimation();
        if(data.status === 'error'){
            console.log(data.message);
            showNotification(1, data.message);
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

function showNotification(action, data){
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
    }, 50);
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
