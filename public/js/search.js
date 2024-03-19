const searchContainer = document.querySelector(".search-cont");
const searchInput = searchContainer.querySelector("input");
const searchResult = searchContainer.querySelector('.search-result-container');
const searchTutorial = searchContainer.querySelector('.search-tutorial-container');
let typingTimer;

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
            if (data.status === 'success') {
                searchTutorial.style.display = 'none';
                notFound.style.display = 'none';
                searchResultMain.style.display = 'block';

                searchResultMain.innerHTML = data.message;
                const height = searchResult.offsetHeight;
                console.log(height);
                searchResult.style.bottom = `-${height}px`;
            } else if (data.status === 'empty') {
                searchResultMain.style.display = 'none';
                notFound.style.display = "flex";
                searchResult.style.bottom = `-300px`;
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}