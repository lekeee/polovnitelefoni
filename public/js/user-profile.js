const clickIden = document.querySelector('.click-identificator');
const userAds = document.querySelector('.user-ads-ident');
const userInfo = document.querySelector('.user-info-ident');
const userAdsLink = userAds.querySelector('a');
const userInfoLink = userInfo.querySelector('a');
const userPreview = document.querySelector('.user-preview-container');

clickIden.style.width = `${userAds.offsetWidth}px`;

userAdsLink.addEventListener('click', function (e) {
    e.preventDefault();
    clickIden.style.width = `${userAds.offsetWidth}px`;
    clickIden.style.transform = `translateX(0px)`;
    userPreview.classList.remove('ads');
    userPreview.classList.add('info');
});

userInfoLink.addEventListener('click', function (e) {
    e.preventDefault();
    clickIden.style.width = `${userInfo.offsetWidth}px`;
    clickIden.style.transform = `translateX(${userAds.offsetWidth + 20}px)`;
    userPreview.classList.remove('info');
    userPreview.classList.add('ads');
});