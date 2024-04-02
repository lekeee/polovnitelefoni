const searchContainer = document.querySelector(".search-cont");
const searchInput = searchContainer.querySelector("input");
const searchResult = searchContainer.querySelector('.search-result-container');
const searchTutorial = searchContainer.querySelector('.search-tutorial-container');
let typingTimer;
let mobile = false;

searchInput.addEventListener('focus', function () {
    searchResult.style.display = 'block';
    searchContainer.style.borderEndEndRadius = '0px';
    searchContainer.style.borderEndStartRadius = '0px';
});

document.addEventListener('click', function (event) {
    if (!searchContainer.contains(event.target)) {
        searchResult.style.display = 'none';
        searchContainer.style.borderEndEndRadius = '25px';
        searchContainer.style.borderEndStartRadius = '25px';
    }
});

searchInput.addEventListener("input", () => {
    mobile = false;
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => {
        if (searchInput.value !== "") {
            sendTitle(searchInput.value);
        }
    }, 600);
});



function sendTitle(title) {
    fetch(`../app/controllers/adController.php?action=search&title=${title}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
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
            const searchResultMain = document.querySelector('.search-result');
            const notFound = document.querySelector('.search-not-found');
            if (data !== null) {
                if (data.status === 'success') {
                    searchTutorial.style.display = 'none';
                    notFound.style.display = 'none';
                    searchResultMain.style.display = 'block';

                    searchResultMain.innerHTML = data.message;
                    const height = searchResult.offsetHeight;
                    console.log(height);
                    searchResult.style.bottom = `-${height}px`;

                    if (mobile) {
                        showMobileSearchResult(data.status, data.message);
                    }

                } else if (data.status === 'empty') {
                    searchResultMain.style.display = 'none';
                    notFound.style.display = "flex";
                    searchResult.style.bottom = `-300px`;
                    if (mobile) {
                        showMobileSearchResult(data.status, data.message);
                    }
                }
            } else {
                searchResultMain.style.display = 'none';
                notFound.style.display = "flex";
                searchResult.style.bottom = `-300px`;
                if (mobile) {
                    showMobileSearchResult(data.status, data.message);
                }
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}



//! Za mobilni search
const mobileInput = document.querySelector('.mobileSearch');

mobileInput.addEventListener("input", () => {
    mobile = true;
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => {
        if (mobileInput.value !== "") {
            sendTitle(mobileInput.value);
        }
    }, 600);
});

function showMobileSearchResult(status, message) {
    const mobileSearchIdentificator = document.querySelector('.mobile-search-identificator');
    const mobileSearchResult = document.querySelector('.mobile-search-result');
    const searchIdentificator = document.querySelector('.search-identificator');
    const mobileNotFound = document.querySelector('.mobile-search-identificator.not-found');

    if (status === 'success') {
        mobileSearchIdentificator.style.display = 'none';
        mobileNotFound.style.display = 'none';
        searchIdentificator.style.paddingTop = '0px';
        mobileSearchResult.style.display = 'block';
        mobileSearchResult.innerHTML = message;
    } else {
        mobileSearchResult.style.display = 'none';
        searchIdentificator.style.paddingTop = '40px';
        mobileNotFound.style.display = 'flex';
    }
}