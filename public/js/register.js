const registerForm = document.querySelector('#email-form-2');
registerForm.addEventListener('submit', function(e){
    e.preventDefault();

    const registerErrorDiv = document.querySelector('#register-error-div');
    const registerErrorDiv2 = registerErrorDiv.querySelector('#register-error-div2');
    registerErrorDiv2.classList.remove("animate");
    registerErrorDiv.style.display = "none";

    const username = registerForm.querySelector('#signup-username').value;
    const email = registerForm.querySelector('#signup-email').value;
    const password = registerForm.querySelector('#signup-password').value;
    const repeatedPassword = registerForm.querySelector('#signup-repeaterpassword').value;

    if(password === repeatedPassword){
        register(username, email, password, repeatedPassword);
    }
});

function register(username, email, password, repeatedPassword){
    fetch('../app/controllers/userController.php',{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'register',
            username: username,
            email: email,
            password: password,
            repeatedPassword: repeatedPassword,
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
            console.log(data.message);
            const registerErrorDiv = document.querySelector('#register-error-div');
            registerErrorDiv.style.display = 'block';
            setTimeout(()=>{
                const registerErrorDiv2 = registerErrorDiv.querySelector('#register-error-div2');
                const registerError = registerErrorDiv.querySelector('#register-error');
                const errorText = registerError.querySelector('span');
                errorText.innerHTML = data.message;
                registerErrorDiv2.classList.toggle('animate');
            }, 50)
            console.log(data.message);
        }else{
            console.log('Uspesna registracija');
            window.location.href = "../views/index.php";
        }
    })
    .catch(error => {
        console.log('Greska:', error);
    });
}

const registerShowPassword = document.querySelector('#register-show-password');
const registerHidePassword = document.querySelector('#register-hide-password');
const password = registerForm.querySelector('#signup-password');

registerShowPassword.addEventListener('click', function(){
    this.style.display = "none";
    registerHidePassword.style.display = "block";
    password.type = "text";
});
registerHidePassword.addEventListener('click', function(){
    this.style.display = "none";
    registerShowPassword.style.display = "block";
    password.type = "password";
});

const registerShowRepeatedPassword = document.querySelector('#register-show-repeated-password');
const registerHideRepeatedPassword = document.querySelector('#reqister-hide-repeated-password');
const repeatedPassword = registerForm.querySelector('#signup-repeaterpassword')

registerShowRepeatedPassword.addEventListener('click', function(){
    this.style.display = "none";
    registerHideRepeatedPassword.style.display = "block";
    repeatedPassword.type = "text";
});
registerHideRepeatedPassword.addEventListener('click', function(){
    this.style.display = "none";
    registerShowRepeatedPassword.style.display = "block";
    repeatedPassword.type = "password";
});