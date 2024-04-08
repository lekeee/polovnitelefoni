const userReportBackground = document.querySelector('.report-backgound-container');
const userReportMainContainer = document.querySelector('.report-main-container');
const reportMessageContainer = document.querySelector('.report-message')

const reportContent = document.querySelector('.report-content');
const reportSuccess = document.querySelector('.report-success');
const secondButton = document.querySelector('.exit');

const positiveRates = document.querySelector('#positive-rates');
const negativeRates = document.querySelector('#negative-rates');
const positiveEmoji = document.querySelector('.positive-emoji');
const negativeEmoji = document.querySelector('.negative-emoji');

const brandColors = [
    '#4CAF50', '#00BCD4', '#E91E63', '#FFC107', '#9E9E9E',
    '#FF5722', '#3F51B5', '#673AB7', '#FF9800', '#2196F3',
    '#FFEB3B', '#9C27B0', '#03A9F4', '#F44336', '#795548',
    '#607D8B', '#009688', '#FF5722', '#8BC34A', '#03A9F4',
    '#FFC107', '#CDDC39', '#607D8B', '#9E9E9E', '#9C27B0'
];

getUserAds();
getUserRates();

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
    await fetch('../app/controllers/userController.php', {
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
                // console.log(data.message)
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
                if (data.numbers === 0) {
                    document.querySelector('.loading-container').style.display = 'none';
                    document.querySelector('.not-found-container').style.display = 'flex';
                }
                if (data.numbers !== 0)
                    adsMainContainer.innerHTML = data.message;

                if (data.numbers === 0 && data.deletedAds === 0) {
                    document.querySelector('.donut-container').innerHTML = "<i style='color: #818ea0'>Nema informacija</i>";
                }

                const deletedAdsCount = parseInt(data.deletedAds);
                // localStorage.setItem("userAdsCount", deletedAdsCount + parseInt(data.numbers));
                document.querySelector("#addedAds").innerHTML = deletedAdsCount + parseInt(data.numbers);
                document.querySelector("#activeAds").innerHTML = parseInt(data.numbers);

                getBrandsData();
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

async function getBrandsData() {
    const userID = getUserID();
    await fetch('../app/controllers/userAdsController.php', {
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
                const values = createBrandsArray(data.message);
                generateDonut(values, brandColors);
                createDonutLegend(data.message);
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

function createBrandsArray(data) {
    const brands = Object.keys(data);
    let values = [];
    brands.forEach(brand => {
        values.push(data[brand]);
    });
    return values;
}

function createDonutLegend(data) {
    const brands = Object.keys(data);
    const mainBrandContainer = document.querySelector('.donut-info');
    for (let i = 0; i < brands.length; i++) {
        const div1 = document.createElement('div');
        div1.classList.add('donut-info-row');
        const div2 = document.createElement('div');
        div2.classList.add("color-identificator");
        div2.style.backgroundColor = brandColors[i];
        const p1 = document.createElement('p');
        p1.innerText = brands[i];
        div1.appendChild(div2);
        div1.appendChild(p1);
        mainBrandContainer.appendChild(div1);
    }
}

async function getUserRates() {
    const userID = getUserID();
    await fetch('../app/controllers/userController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'returnRates',
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
                positiveRates.innerHTML = data.message['broj_pozitivnih'];
                negativeRates.innerHTML = data.message['broj_negativnih'];
                if (data.isRated != null) {
                    if (data.isRated['tip'] == 1) {
                        positiveEmoji.classList.add('active');
                    } else if (data.isRated['tip'] == 0) {
                        negativeEmoji.classList.add('active');
                    }
                }
            }
            else if (data.status === 'empty') {
                positiveRates.innerHTML = 0;
                negativeRates.innerHTML = 0;
            } else {
                console.log("Doslo je do greske: " + data.message);
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}

positiveEmoji.addEventListener('click', () => rateUser(1));
negativeEmoji.addEventListener('click', () => rateUser(0));

async function rateUser(tip) {
    positiveEmoji.disabled = true;
    const userID = getUserID();
    await fetch('../app/controllers/userController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'rateUser',
            userID: userID,
            tip: tip
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
                if (tip == 1) {
                    if (negativeEmoji.classList.contains('active')) {
                        negativeEmoji.classList.remove('active');
                        negativeRates.innerHTML = parseInt(negativeRates.innerHTML) - 1;
                    }
                    positiveEmoji.classList.add('active');
                    positiveRates.innerHTML = parseInt(positiveRates.innerHTML) + 1;
                } else {
                    if (positiveEmoji.classList.contains('active')) {
                        positiveEmoji.classList.remove('active');
                        positiveRates.innerHTML = parseInt(positiveRates.innerHTML) - 1;
                    }
                    negativeEmoji.classList.add('active');
                    negativeRates.innerHTML = parseInt(negativeRates.innerHTML) + 1;
                }
            }
            else if (data.status === 'empty') {
            } else {
                console.log("Doslo je do greske: " + data.message);
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}