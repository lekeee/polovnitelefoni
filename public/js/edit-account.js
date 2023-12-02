const editAccountForm = document.querySelector('#edit-account-form');
editAccountForm.addEventListener('submit', function(e){
    e.preventDefault();

    startLoadingAnimation("saveButton");

    const userName = editAccountForm.querySelector('#UserName');
    const userSurname = editAccountForm.querySelector('#UserSurname');
    const userUsername = editAccountForm.querySelector('#UserUsername');
    const userPhone = editAccountForm.querySelector('#UserPhoneNumber');
    const userCity = editAccountForm.querySelector('#UserCity');
    const userAddress = editAccountForm.querySelector('#UserAddress');
    const userOldPassword = editAccountForm.querySelector('#UserOldPassword');
    const userNewPassword = editAccountForm.querySelector('#UserNewPassword');
    const userConfirmedNewPassword = editAccountForm.querySelector('#UserConfirmedNewPassword');

    if(userName.value.trim() === ''){
        showErrorNotification('error', 'Polje Ime je obavezno!');
        return;
    }else if(userSurname.value.trim() === ''){
        showErrorNotification('error', 'Polje Prezime je obavezno!');
        return;
    }else if(userUsername.value.trim() === ''){
        showErrorNotification('error', 'Polje Korisnicko Ime je obavezno!');
        return;
    }else if(userUsername.value.length < 6 || userUsername.value.length > 20){
        showErrorNotification('error', 'Korisnicko ime nije adekvatno! (mora imati više od 6 a manje od 20 karaktera)' );
        return;
    }else if(userCity.value.trim() === ''){
        showErrorNotification('error', 'Polje Grad je obavezno!');
        return;
    }else if(userAddress.value.trim() === ''){
        showErrorNotification('error', 'Polje Adresa je obavezno!');
        return;
    }
    if(userOldPassword.value.trim() === ''){
        if(userNewPassword.value.trim() !== '' || userConfirmedNewPassword.value.trim() !== ''){
            showErrorNotification('error', 'Polje Trenutna Lozinka je obavezno!');
            return;
        }
    }else{
        if(userNewPassword.value.trim() === ''){
            showErrorNotification('error', 'Polje Nova Lozinka je obavezno!');
            return;
        }else if(userConfirmedNewPassword.value === ''){
            showErrorNotification('error', 'Polje Potvrdi Lozinku je obavezno!');
            return;
        }else{
            if(userNewPassword.value !== userConfirmedNewPassword.value){
                showErrorNotification('error', 'Morate ispravno potvrditi novu loiznku!');
                return;
            }
        }
    }

    updateUserData(userName.value, userSurname.value, userUsername.value, userOldPassword.value, userNewPassword.value, userPhone.value, userCity.value, userAddress.value);
});

function showErrorNotification(status, message){
    stopLoadingAnimation("saveButton");
    console.log(`${status} ${message}`);
    const errorDiv = document.querySelector('#edit-account-message');
    const errorText = errorDiv.querySelector('div');
    errorText.innerHTML = message;

    if(status === 'success'){
        errorDiv.classList.remove('edit-error');
        errorDiv.classList.add('edit-success');
    }else{
        errorDiv.classList.remove('edit-success');
        errorDiv.classList.add('edit-error');

    }

    window.location.href = "#edit-account-message";
}

function updateUserData(name, lastname, username, oldPassword, newPassword, mobilePhone, city, address){
    
    fetch('../app/controllers/userController.php',{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'edit-account',
            name: name,
            lastname: lastname,
            username: username,
            oldPassword: oldPassword,
            newPassword: newPassword,
            mobilePhone: mobilePhone,
            city: city,
            address: address
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
        stopLoadingAnimation("saveButton");
        showErrorNotification(data.status, data.message);
    })
    .catch(error => {
        console.log('Greska:', error);
    });
}

showMyCity();
function showMyCity(){
    const citySelect = document.querySelector('#UserCity');
    const myCity = citySelect.getAttribute('value');
    if(myCity !== ''){
        const cityOption = citySelect.querySelector(`option[value=${myCity}]`);
        cityOption.setAttribute('selected', 'selected');
    }
}

function showPassword(x){
    const showPasswordElement = document.querySelector(`#show${x}`);
    const hidePasswordElement = document.querySelector(`#hide${x}`);

    showPasswordElement.style.display = "none";
    hidePasswordElement.style.display = "block";

    const passwordInputID = showPasswordElement.getAttribute('input-id');
    const password = document.querySelector(`#${passwordInputID}`);
    password.type = "text";
}
function hidePassword(x){
    const showPasswordElement = document.querySelector(`#show${x}`);
    const hidePasswordElement = document.querySelector(`#hide${x}`);

    hidePasswordElement.style.display = "none";
    showPasswordElement.style.display = "block";

    const passwordInputID = hidePasswordElement.getAttribute('input-id');
    const password = document.querySelector(`#${passwordInputID}`);
    password.type = "password";
}