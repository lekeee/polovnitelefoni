const subTriggers = document.querySelectorAll('.subscribeTrigger');
subTriggers.forEach(element => {
    element.addEventListener('click', scrollToSubscribe);
});


document.querySelector('.shopTrigger').addEventListener('click', function () {
    if (window.location.href.indexOf("/index.php") <= -1) {
        window.location.href = '../views/index.php';
    }
    var shopContainer = document.querySelector('.filtersandproductscontainer');

    var shopContainerTop = shopContainer.getBoundingClientRect().top;
    window.scrollTo({
        top: window.scrollY + shopContainerTop - 50,
        behavior: 'smooth'
    });
});

function scrollToSubscribe() {
    document.querySelector("#mobile-menu-close").click();
    var subscribeContainer = document.querySelector('.subscribecontainer');

    var subscribeContainerTop = subscribeContainer.getBoundingClientRect().top;
    window.scrollTo({
        top: window.scrollY + subscribeContainerTop - 200,
        behavior: 'smooth'
    });
}