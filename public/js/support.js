const nameContainer = document.querySelector('#name');
const lastnameContainer = document.querySelector('#lastname');
const emailContainer = document.querySelector('#email');
const problemContainer = document.querySelector('#problem');
const descriptionContainer = document.querySelector('#description');

async function sendMessageToSupport() {
    if (validation()) {
        await fetch('../app/controllers/supportController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'saveSupportData',
                name: nameContainer.value,
                lastname: lastnameContainer.value,
                email: emailContainer.value,
                problem: problemContainer.value,
                description: descriptionContainer.value
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
                    alert("Doslo je do greške, molimo pokušajte kasnije!");
                }
                else if (data.status === 'success') {
                    document.querySelector('.report-backgound-container').style.display = "flex";
                    const mainResult = document.querySelector('.report-main-container');
                    mainResult.classList.remove('close');
                    mainResult.classList.add('active');
                }
            })
            .catch(error => {
                console.log('Greska:', error);
            });
    }
}

function validation() {
    let isValid = true;

    if (nameContainer.value.trim() === '') {
        nameContainer.style.border = "1px solid red";
        isValid = false;
    } else {
        nameContainer.style.border = "";
    }

    if (lastnameContainer.value.trim() === '') {
        lastnameContainer.style.border = "1px solid red";
        if (isValid) scrollToContainer(lastnameContainer);
        isValid = false;
    } else {
        lastnameContainer.style.border = "";
    }

    if (emailContainer.value.trim() === '') {
        emailContainer.style.border = "1px solid red";
        if (isValid) scrollToContainer(emailContainer);
        isValid = false;
    } else {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailContainer.value.trim())) {
            emailContainer.style.border = "1px solid red";
            if (isValid) scrollToContainer(emailContainer);
            isValid = false;
        } else {
            emailContainer.style.border = "";
        }
    }

    if (problemContainer.value.trim() === '') {
        problemContainer.style.border = "1px solid red";
        if (isValid) scrollToContainer(problemContainer);
        isValid = false;
    } else {
        problemContainer.style.border = "";
    }

    if (descriptionContainer.value.trim() === '') {
        descriptionContainer.style.border = "1px solid red";
        if (isValid) scrollToContainer(descriptionContainer);
        isValid = false;
    } else {
        descriptionContainer.style.border = "";
    }

    return isValid;
}

function scrollToContainer(container) {
    // container.scrollIntoView({ behavior: "smooth", block: "start" });
    var subscribeContainerTop = container.getBoundingClientRect().top;
    window.scrollTo({
        top: window.scrollY + subscribeContainerTop - 100,
        behavior: 'smooth'
    });
}
