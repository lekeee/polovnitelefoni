const verifyBtn = document.querySelector('#verify-email');
verifyBtn.addEventListener('click', function(e){
    e.preventDefault();
    startLoadingAnimation();
    const user_id = verifyBtn.getAttribute('uid-value');
    console.log(user_id);
    fetch('../app/controllers/verificationController.php',{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'verify',
            user_id: user_id
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
        if(data.status === 'success'){
            verifyDone();
        }else{
            alert("Došlo je do greške, molimo Vas pokušajte kasnije!");
        }
    })
    .catch(error => {
        //stopLoadingAnimation("register-submit");
        console.log('Greska:', error);
    });
});

function verifyDone(){
    document.querySelector('#verify-email').style.display = "none";
    document.querySelector("#verified_button").style.display = "flex";
}

function startLoadingAnimation(){
    var submitButton = document.querySelector("#verify-email");
    const waitImage = new Image();
    waitImage.src = submitButton.getAttribute('data-wait');

    submitButton.innerHTML = '';

    submitButton.style.backgroundImage = `url('${waitImage.src}')`;
    submitButton.style.backgroundSize = '7%';
    submitButton.style.backgroundRepeat = 'no-repeat';
    submitButton.style.backgroundPosition = 'center';
    submitButton.disabled = true;
}
function stopLoadingAnimation(){
    var submitButton = document.querySelector(`#verify-email`);
    submitButton.innerHTML = submitButton.getAttribute('data-value');
    submitButton.style.backgroundImage = 'none';
    submitButton.disabled = false;
}