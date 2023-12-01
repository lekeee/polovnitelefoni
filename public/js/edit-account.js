const editAccountForm = document.querySelector('#edit-account-form');
editAccountForm.addEventListener('submit', function(e){
    e.preventDefault();
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
        showErrorNotification('error', 'Korisnicko ime nije adekvatno');
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
    console.log(`${status} ${message}`);
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
        if(data.status === 'error'){
            console.log(typeof data.message);
            switch(data.message){
                case 'PASSWORD_ERROR':
                    console.log('greska lozinke');
                    break;
                case 'USERNAME_TAKEN':
                    console.log('greska username');
                    break;
                default:
                    break;
            }
        }else{

        }
    })
    .catch(error => {
        console.log('Greska:', error);
    });
}

showMyCity();
function showMyCity(){
    const citySelect = document.querySelector('#UserCity');
    const myCity = citySelect.getAttribute('value');
    const cityOption = citySelect.querySelector(`option[value=${myCity}]`);
    cityOption.setAttribute('selected', 'selected');
}