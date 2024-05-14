const mobileSearchTrigger = document.querySelector('#mobile-search');
const mobileSearchIcon = mobileSearchTrigger.querySelector('img');
const mobileSearchText = mobileSearchTrigger.querySelector('.text-block-35');

const mobileSearchContainer = document.querySelector('.mobile-search-main-container');
const mobileSearchMain = mobileSearchContainer.querySelector('.mobile-search');

mobileSearchTrigger.addEventListener('click', function (e) {
    e.preventDefault();

    if (mobileSearchContainer.classList.contains('close')) {
        showMobileSearch();
    } else if (mobileSearchContainer.classList.contains('open')) {
        hiddeMobileSearch();
    } else {
        showMobileSearch();
    }
})

function showMobileSearch() {
    document.body.style.overflowY = 'hidden';
    mobileSearchContainer.classList.remove('close');
    mobileSearchContainer.classList.add('open');
    setTimeout(() => {
        mobileSearchMain.classList.add('visible');
        mobileSearchIcon.src = '../public/src/close-icon.svg';
        mobileSearchText.style.display = "none";
    }, 350)
}

function hiddeMobileSearch() {
    mobileSearchMain.classList.remove('visible');
    mobileSearchContainer.classList.remove('open');
    mobileSearchContainer.classList.add('close');
    setTimeout(() => {
        document.body.style.overflowY = 'auto';
        mobileSearchIcon.src = '../public/src/search_icon.png';
        mobileSearchText.style.display = "block";
    }, 350);
}
