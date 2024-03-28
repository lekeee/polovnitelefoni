function showHeaderMobileCategories() {
    const element = document.querySelector('#header-phone-list');
    if (element.style.display == 'none') {
        element.style.display = 'block';
        element.style.opacity = '1';
    } else {
        element.style.display = 'none';
        element.style.opacity = '0';
    }

    element.addEventListener('click', function (e) {
        e.stopPropagation();
    });
}