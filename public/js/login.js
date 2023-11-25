const loginForm = document.querySelector('#wf-form-Email-Form-1');
loginForm.addEventListener('submit', function(e){
    e.preventDefault();

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
        if(data.status === 'error'){
            const loginErrorDiv = document.querySelector('#login-error-div');
            loginErrorDiv.style.display = 'block';
            setTimeout(()=>{
                const loginErrorDiv2 = loginErrorDiv.querySelector('#login-error-div2');
                const loginError = loginErrorDiv.querySelector('#login-error');
                const errorText = loginError.querySelector('span');
                errorText.innerHTML = data.message;
                loginErrorDiv2.classList.toggle('animate');
            }, 50)
            console.log(data.message);
        }else{
            console.log('Uspesno ste se prijavili.');
            window.location.href = "../views/index.php";
        }
    })
    .catch(error => {
        console.log('Greska:', error);
    });
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
