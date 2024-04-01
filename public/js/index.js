async function addToFavourite(x, user_id, ad_id) {
    await fetch('../app/controllers/adController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'addToFavourite',
            user_id: user_id,
            ad_id: ad_id
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
                if (x !== null) {
                    x.querySelector("svg").classList.add('redLoveAnimation');
                    x.querySelector("svg").style.fill = "red";
                    x.querySelector("svg").style.stroke = "red";
                    setTimeout(function () {
                        x.querySelector("svg").classList.remove('redLoveAnimation')
                    }, 300);
                }
                const savesContainer = document.querySelector("#mySavesContainer");
                const savesCounter = document.querySelector('#mySavesCount');
                let counter = parseInt(savesCounter.innerHTML, 10);
                counter++;
                savesContainer.style.display = 'flex';
                savesCounter.innerHTML = counter;

                // Menjam tekst koji ide uz srce (Ako postoji)
                const heartText = document.querySelector('#saved-identificator');
                if (heartText !== null && heartText !== undefined) {
                    heartText.innerHTML = "Ukloni";
                }
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}

async function removeFromFavourite(x, user_id, ad_id, color) {
    await fetch('../app/controllers/adController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'removeFromFavourite',
            user_id: user_id,
            ad_id: ad_id
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
            if (x == null && data.status === 'success') {
                return true;
            } else if (x == null && data.status === 'error') {
                return false;
            }
            if (x != null && data.status === 'success') {
                if (x !== null) {
                    x.querySelector("svg").classList.add('redLoveAnimation');
                    x.querySelector("svg").style.fill = "none";
                    x.querySelector("svg").style.stroke = color;
                    setTimeout(function () {
                        x.querySelector("svg").classList.remove('redLoveAnimation')
                    }, 300);

                    // Menjam tekst koji ide uz srce (Ako postoji)
                    const heartText = document.querySelector('#saved-identificator');
                    if (heartText !== null && heartText !== undefined) {
                        heartText.innerHTML = "Sačuvaj oglas";
                    }
                }
                const savesContainer = document.querySelector("#mySavesContainer");
                const savesCounter = document.querySelector('#mySavesCount');
                let counter = parseInt(savesCounter.innerHTML, 10);
                counter--;
                if (counter === 0) {
                    savesContainer.style.display = 'none';
                }
                savesCounter.innerHTML = counter;
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}

async function isSaved(user_id, ad_id) {
    await fetch('../app/controllers/adController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'checkIsFavourite',
            user_id: user_id,
            ad_id: ad_id
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
            if (data.status === 'exist') {
                return 1;
            } else if (data.status === 'not-exist') {
                return 0;
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}

async function checkIsSaved(event, x, user_id, ad_id, color = 'black') {
    event.stopPropagation();
    await fetch('../app/controllers/adController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'checkIsFavourite',
            user_id: user_id,
            ad_id: ad_id
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
            if (data.status === 'exist') {
                removeFromFavourite(x, user_id, ad_id, color);
            } else if (data.status === 'not-exist') {
                addToFavourite(x, user_id, ad_id);
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}
function checkIsSaved2(event) {
    event.stopPropagation();
}

let firstTime = true;

async function FilterData(params, restart) {
    const loadingAnimationContainer = document.querySelectorAll('.loading-animation');
    loadingAnimationContainer.forEach(element => {
        document.querySelectorAll('.productsmaincontainer')[0].appendChild(element);
        element.style.display = 'inline-block';
    });
    const url = '../app/controllers/adController.php?' + params;
    await fetch(url, {
        method: 'GET'
    })
        .then(response => response.json())
        .then(async (data) => {
            if (data.status === 'success') {
                if (data.message.length == 0) {
                    console.log("nema rezultata");
                    const div1 = document.createElement('div');
                    div1.classList.add('no-result-main-container');
                    const img1 = document.createElement('img');
                    img1.src = '../public/src/not-found.svg';
                    const p1 = document.createElement('p');
                    p1.innerHTML = "Nije pronađen nijedan rezultat!";
                    div1.appendChild(img1);
                    div1.appendChild(p1);
                    const mainElement = document.querySelector('.productsmaincontainer');
                    mainElement.innerHTML = '';
                    mainElement.appendChild(div1);
                    // document.querySelector('.loadmorecontainer').style.display = 'none';
                    showLoadMoreButton();
                    if (!firstTime) {
                        scrollIntoAds();
                    }
                    return;
                }

                cacheAdsCounter(data.message.length);
                loadingAnimationContainer.forEach(element => {
                    document.querySelectorAll('.productsmaincontainer')[0].removeChild(element);
                    element.style.display = 'none';
                });
                if (typeof restart !== 'undefined' && restart === true) {
                    document.querySelectorAll('.productsmaincontainer')[0].innerHTML = '';
                }
                let jsonmodels = JSON.stringify(data.message);
                updateWidgets(jsonmodels);
                if (restart && !firstTime) scrollIntoAds();
                // params.action = 'countFilteredData';
                params.set('action', 'countFilteredData');
                await showAllAdsCounter(params);
                firstTime = false;
                showLoadMoreButton();
            }
        })
        .catch(error => console.error('Došlo je do greške:', error));
}

function showLoadMoreButton() {
    const btn = document.querySelector('.loadmorecontainer');
    const progressIndicator = btn.querySelector('.loadmoreindicatormain');

    if (allAdsCounter <= loadedAdsCounter) {
        btn.style.display = 'none';
    } else {
        btn.style.display = 'flex';
        const progress = loadedAdsCounter / allAdsCounter * 100;
        progressIndicator.style.width = `${progress}%`;
    }
}

function scrollIntoAds() {
    var mainContainer = document.querySelector('.productsmaincontainer');

    var mainContainerTop = mainContainer.getBoundingClientRect().top;
    window.scrollTo({
        top: window.scrollY + mainContainerTop - 100,
        behavior: 'smooth'
    });
}
async function updateWidgets(ads) {
    document.querySelectorAll('.loadmorebutton')[0].style.display = 'block';
    await fetch('../inc/widget.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            ads: ads
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
            document.querySelectorAll('.productsmaincontainer')[0].innerHTML += data;

            // checkLoadMoreButton();
            showLoadMoreButton();

            const elements = document.getElementsByClassName('widgetimagescontainer');
            for (let i = 0; i < elements.length; i++) {
                const imageVal = elements[i].getAttribute('bg-image');
                elements[i].style.backgroundImage = 'url("' + imageVal + '")';

            }

            const hoverElements = document.querySelectorAll('.hoverDetector');
            hoverElements.forEach(function (hoverElement) {
                hoverElement.addEventListener('mouseover', function () {
                    const imagePath = this.getAttribute('image-data');
                    const imageIndicator = this.getAttribute('image-indicator');
                    const parent = this.parentElement;

                    // Dodajte tranziciju za glatki prelaz
                    parent.style.transition = 'background-image 0.5s ease';

                    // Postavite novu sliku sa transparentnim prelazom
                    parent.style.backgroundImage = `linear-gradient(rgba(255,255,255,0), rgba(255,255,255,0)), url(${imagePath})`;

                    const indicators = parent.querySelectorAll('.imageindicatior');
                    indicators.forEach(function (indicator) {
                        indicator.classList.remove('active');
                    });
                    indicators[imageIndicator].classList.add('active');
                });
            });
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}

// function checkLoadMoreButton() {
//     if (loadedAdsCounter && allAdsCounter) {
//         const loadedAdsCounterInitialData = JSON.parse(loadedAdsCounter);
//         const allAdsCounterInitialData = JSON.parse(allAdsCounter);
//         if (Number(loadedAdsCounterInitialData.counter) === Number(allAdsCounterInitialData.counter)) {
//             document.querySelectorAll('.loadmorebutton')[0].style.display = 'none';
//         }
//     }
// }

function loadMore(x) {
    let currentPage = x.getAttribute('current-page');
    currentPage = parseInt(currentPage, 10);
    currentPage += 1;
    x.setAttribute('current-page', currentPage);

    getAds(currentPage);
}

async function showAllAdsCounter(params) {
    const url = '../app/controllers/adController.php?' + params;
    await fetch(url, {
        method: 'GET'
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const element = document.querySelector('.showingtitle');
                element.innerHTML = "Prikazuje se svih " + data.message[0]["ukupno_oglasa"] + " rezultata";
                cacheAllAdsCounter(data.message[0]["ukupno_oglasa"]);
            }
        })
        .catch(error => console.error('Došlo je do greške:', error));
}