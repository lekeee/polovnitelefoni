function addToFavourite(x, user_id, ad_id) {
    fetch('../app/controllers/adController.php', {
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
            // console.log(data);
            if (data.status === 'success') {
                if (x !== null) {
                    x.querySelector("svg").style.fill = "red";
                    x.querySelector("svg").style.stroke = "red";
                }
                const savesContainer = document.querySelector("#mySavesContainer");
                const savesCounter = document.querySelector('#mySavesCount');
                let counter = parseInt(savesCounter.innerHTML, 10);
                counter++;
                savesContainer.style.display = 'flex';
                savesCounter.innerHTML = counter;
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}

function removeFromFavourite(x, user_id, ad_id) {
    fetch('../app/controllers/adController.php', {
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
            // console.log(data);
            if (data.status === 'success') {
                if (x !== null) {
                    x.querySelector("svg").style.fill = "none";
                    x.querySelector("svg").style.stroke = "black";
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

function checkIsSaved(event, x, user_id, ad_id) {
    event.stopPropagation();
    fetch('../app/controllers/adController.php', {
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
            // console.log(data);
            if (data.status === 'exist') {
                removeFromFavourite(x, user_id, ad_id);
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

function FilterData(params, restart) {
    const url = '../app/controllers/adController.php?' + params;
    fetch(url, {
        method: 'GET'
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                if (restart) document.querySelectorAll('.productsmaincontainer')[0].innerHTML = '';
                let jsonmodels = JSON.stringify(data.message);
                updateWidgets(jsonmodels);
                if (restart) document.querySelectorAll('.productsmaincontainer')[0].scrollIntoView({ behavior: 'smooth' });
            }
        })
        .catch(error => console.error('Došlo je do greške:', error));
}

function updateWidgets(ads) {
    document.querySelectorAll('.loadmorebutton')[0].style.display = 'block';
    fetch('../inc/widget.php', {
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
            if (data.length === 0 || data.length < 4) document.querySelectorAll('.loadmorebutton')[0].style.display = 'none';
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

                    parent.style.backgroundImage = `url(${imagePath})`;
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

// function getAds(page) {
//     fetch('../app/controllers/adController.php', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//         },
//         body: JSON.stringify({
//             action: 'getAds',
//             page: page,
//         })
//     })
//         .then(response => {
//             if (response.ok) {
//                 return response.json();
//             } else {
//                 throw new Error('Doslo je do greske prilikom prihvatanja zahteva.');
//             }
//         })
//         .then(data => {
//             // console.log(data.message);
//             updateWidgets(data.message);
//         })
//         .catch(error => {
//             console.log('Greska:', error);
//         });
// }

function loadMore(x) {
    let currentPage = x.getAttribute('current-page');
    currentPage = parseInt(currentPage, 10);
    currentPage += 1;
    x.setAttribute('current-page', currentPage);

    getAds(currentPage);
}