const newsletterBtn = document.querySelector('#newsletter-submit');
const newsletterBackground = document.querySelector('.newsletter-backgound-container');
const newsletterMain = document.querySelector('.newsletter-main-container');
const newsletterClose = document.querySelector('.close-newsletter');
const emailInput = document.querySelector('#subscribe-email');
const newsletterInfo = document.querySelector('#newsletter-info');


newsletterBtn.addEventListener('click', async function () {
    //! Dodati logiku za bazu
    if (emailInput.value.trim() == '') {
        return;
    }
    await fetch('../app/controllers/newsletterController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'subscribe',
            email: emailInput.value,
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
            if (data.status === 'success') {
                openNewsletterNotification();
                newsletterInfo.innerHTML = data.message;
            } else {
                openNewsletterNotification();
                newsletterInfo.innerHTML = data.message;
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });

});

newsletterClose.addEventListener('click', function () {
    closeNewsletterNotification();
});

newsletterBackground.addEventListener('click', function () {
    closeNewsletterNotification();
});

newsletterMain.addEventListener('click', function (e) {
    e.stopPropagation();
})

function openNewsletterNotification() {
    newsletterBackground.style.display = 'flex';
    newsletterMain.classList.remove('close');
    newsletterMain.classList.add('active');
}

function closeNewsletterNotification() {
    newsletterMain.classList.remove('active');
    newsletterMain.classList.add('close');
    setTimeout(() => {
        newsletterBackground.style.display = 'none';
    }, 300);
}