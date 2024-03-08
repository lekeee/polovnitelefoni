const userReportBackground = document.querySelector('.report-backgound-container');
const userReportMainContainer = document.querySelector('.report-main-container');
const reportMessageContainer = document.querySelector('.report-message')

const reportContent = document.querySelector('.report-content');
const reportSuccess = document.querySelector('.report-success');
const secondButton = document.querySelector('.exit');

const brandColors = ['#4CAF50', '#00BCD4', '#E91E63', '#FFC107', '#9E9E9E'];

getUserAds();


userReportMainContainer.addEventListener('click', function (e) {
    e.stopPropagation();
});
userReportBackground.addEventListener('click', hiddeReportUser);

function showReportUser(x) {
    if (x !== 1) {
        alert("Morate biti ulogovani da biste prijavili korisnika!");
        return;
    }
    userReportBackground.style.display = "flex";
    userReportMainContainer.classList.remove('close');
    userReportMainContainer.classList.add('active');
}

function hiddeReportUser() {
    userReportMainContainer.classList.remove('active');
    userReportMainContainer.classList.add('close');
    setTimeout(() => {
        userReportBackground.style.display = "none";
    }, 300);
}

reportMessageContainer.addEventListener('input', function () {
    this.style.borderColor = "#ddd";
});

function reportUser(userId, reportedId, x) {
    x.disabled = true;
    const reportMessage = reportMessageContainer.value;
    if (reportMessage.trim() === '') {
        reportMessageContainer.style.borderColor = "red";
        return;
    }
    sendReportRequest(userId, reportedId, reportMessage);
}

async function sendReportRequest(userId, reportedId, msg) {
    fetch('../app/controllers/userController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'reportUser',
            userId: userId,
            reportedId: reportedId,
            msg: msg
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
                console.log("Doslo je do greske: " + data.message);
            } else {
                console.log(data.message)
                reportContent.style.display = "none";
                reportSuccess.style.display = "block";
                const lbl = secondButton.querySelector('label');
                lbl.innerText = "Zatvori";
                lbl.style.cursor = "pointer";
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}

function getUserAds() {
    const userID = getUserID();
    fetch('../app/controllers/userAdsController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'getUserAds',
            userID: userID
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
                const adsMainContainer = document.querySelector('.ads-container');
                adsMainContainer.innerHTML = data.message;
            }
            else if (data.status === 'empty') {
                console.log("Korisnik nema oglase");
            } else {
                console.log("Doslo je do greske: " + data.message);
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}

function getUserID() {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');
    return id;
}

function getBrandsData() {
    const userID = getUserID();
    fetch('../app/controllers/userAdsController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'getBrandsData',
            userID: userID
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
                const brands = Object.keys(data.message);
                let values = [];
                brands.forEach(brand => {
                    values.push(data.message[brand]);
                });
                generateDonut(values, brandColors);
            }
            else if (data.status === 'empty') {
                console.log("Korisnik nema oglase");
            } else {
                console.log("Doslo je do greske: " + data.message);
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}


getBrandsData();