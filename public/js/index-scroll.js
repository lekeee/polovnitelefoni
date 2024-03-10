document.querySelector('.subscribeTrigger').addEventListener('click', function () {
    var subscribeContainer = document.querySelector('.subscribecontainer');

    var subscribeContainerTop = subscribeContainer.getBoundingClientRect().top;
    window.scrollTo({
        top: window.scrollY + subscribeContainerTop - 200,
        behavior: 'smooth'
    });
});

document.querySelector('.shopTrigger').addEventListener('click', function () {
    window.location.href = '../views/index.php';
    var shopContainer = document.querySelector('.filtersandproductscontainer');

    var shopContainerTop = shopContainer.getBoundingClientRect().top;
    window.scrollTo({
        top: window.scrollY + shopContainerTop - 50,
        behavior: 'smooth'
    });
});
