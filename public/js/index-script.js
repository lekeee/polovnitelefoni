document.addEventListener('DOMContentLoaded', function () {
    let dropDownOpened = [];

    const brandCheckboxes = document.getElementsByClassName('custom-brand-checkbox');
    const brandDropdowns = document.getElementsByClassName('custom-dropdown');
    const dropDownTogglers = document.getElementsByClassName('openDropDown');

    for (let i = 0; i < brandDropdowns.length; i++) {
        const dropDownCheckboxes = brandDropdowns[i].querySelectorAll('input[type="checkbox"]');
        for (let j = 0; j < dropDownCheckboxes.length; j++) {
            dropDownCheckboxes[j].addEventListener('change', checkIsAllModelsChecked);
        }
    }

    for (let i = 0; i < dropDownTogglers.length; i++) {
        const dropDownToggler = dropDownTogglers[i];
        dropDownToggler.addEventListener('click', createToggleHandler(i));
    }

    for (let i = 0; i < brandCheckboxes.length; i++) {
        const brandCheckbox = brandCheckboxes[i];
        brandCheckbox.addEventListener('change', createCheckerHandler(i));
    }



    function checkIsAllModelsChecked() {
        for (let i = 0; i < brandCheckboxes.length; i++) {
            const dropdownElements = brandDropdowns[i].querySelectorAll('input[type="checkbox"]');

            let counter = 0;
            for (let j = 0; j < dropdownElements.length; j++) {
                if (dropdownElements[j].checked) counter++;
            }
            brandCheckboxes[i].checked = counter > 0;
        }
    }

    function createCheckerHandler(index) {
        return function () {
            checkAllChildren(index)
        }
    }

    function checkAllChildren(index) {
        const brandDropdown = brandDropdowns[index];
        const elements = brandDropdown.querySelectorAll('input[type="checkbox"]');

        if (brandCheckboxes[index].checked) {
            for (let i = 0; i < elements.length; i++) {
                elements[i].checked = true;
            }
        } else {
            for (let i = 0; i < elements.length; i++) {
                elements[i].checked = false;
            }
        }
    }

    function createToggleHandler(index) {
        return function () {
            checkForExpand(index);
        };
    }

    function checkForExpand(i) {
        if (dropDownOpened[i] !== 1) {
            expandDropdown(brandDropdowns[i]);
            dropDownOpened[i] = 1;
            dropDownTogglers[i].innerHTML = "-";
        } else {
            collapseDropdown(brandDropdowns[i]);
            dropDownOpened[i] = 0;
            dropDownTogglers[i].innerHTML = "+";
        }
    }

    function expandDropdown(element) {
        const height = element.scrollHeight;
        element.style.maxHeight = height + "px";
        element.classList.add('visible');
    }

    function collapseDropdown(element) {
        element.style.maxHeight = 0;
        element.classList.remove('visible');
    }

    document.querySelectorAll('.filtericoncontainer')[0].addEventListener('click', function () {
        document.querySelectorAll('.darkbackground')[0].style.display = 'block';
        document.querySelectorAll('.filterleftmaincontainer')[0].classList.remove('deactive');
        document.querySelectorAll('.filterleftmaincontainer')[0].classList.add('active');
    });
    document.querySelectorAll('.closeicon')[0].addEventListener('click', function () {
        closeFiltersContainer();
    });

});
function closeFiltersContainer(){
    document.querySelectorAll('.filterleftmaincontainer')[0].classList.remove('active');
    document.querySelectorAll('.filterleftmaincontainer')[0].classList.add('deactive');
    setTimeout(() => {
        document.querySelectorAll('.darkbackground')[0].style.display = 'none';
    }, 300);
}

function openQuickView(x) {
    document.querySelector('body').style.overflowY = "hidden";

    // console.log(x);
    const darkBackground = document.querySelector('.darkbackground2');
    const quickViewContainer = document.querySelector('.quickviewcontainer');
    const mainimage = x.getAttribute('main-image');
    const title = x.getAttribute('ad-title');
    const brand = x.getAttribute('brand');
    const model = x.getAttribute('model');
    const state = x.getAttribute('state');
    const rate = x.getAttribute('rate');
    const visitors = x.getAttribute('visitors');
    const saves = x.getAttribute('saves');
    const damage = x.getAttribute('damage');
    const accessories = x.getAttribute('accessories');
    const price = x.getAttribute('price');
    const oldprice = x.getAttribute('old-price');
    const name = x.getAttribute('name');
    const lastname = x.getAttribute('lastname');
    const city = x.getAttribute('city');
    const address = x.getAttribute('address');
    const phone = x.getAttribute('phone');

    darkBackground.style.display = 'flex';
    quickViewContainer.classList.remove('deactive');
    quickViewContainer.classList.add('active');

    document.querySelector('#quick-view-image').src = mainimage;
    document.querySelector('#quick-view-title').innerHTML = title;
    document.querySelector('#quick-view-brand').innerHTML = brand;
    document.querySelector('#quick-view-model').innerHTML = model;

    const rated = document.querySelector('#quick-view-rate');
    if (state == 0) {
        if (rate < 2) rated.src = "../public/src/start-rating1.png";
        else if (rate < 4) rated.src = "../public/src/start-rating2.png";
        else if (rate < 6) rated.src = "../public/src/start-rating3.png";
        else if (rate < 8) rated.src = "../public/src/start-rating4.png";
        else rated.src = "../public/src/start-rating5.png";
    } else {
        rated.src = "../public/src/start-rating5.png";
    }

    document.querySelector("#quick-view-visitors").innerHTML = visitors;
    document.querySelector("#quick-view-saves").innerHTML = saves;

    if (damage != '') {
        document.querySelector('#quick-view-damage').style.display = "block";
    } else {
        document.querySelector('#quick-view-damage').style.display = "none";
    }

    if (price != '') {
        document.querySelector('#quick-view-price').innerHTML = '€' + price;
    } else {
        document.querySelector('#quick-view-price').innerHTML = 'Dogovor';
    }

    if (oldprice != '') {
        document.querySelector('#quick-view-old-price').innerHTML = '€' + oldprice;
    } else {
        document.querySelector('#quick-view-old-price').innerHTML = '';
    }

    document.querySelector("#quick-view-user").innerHTML = name + ' ' + lastname;
    document.querySelector("#quick-view-city").innerHTML = city;
    document.querySelector("#quick-view-address").innerHTML = address;
    document.querySelector("#quick-view-phone").innerHTML = phone;
}

function closeQuickView() {
    document.querySelector('.quickviewcontainer').classList.remove('active');
    document.querySelector('.quickviewcontainer').classList.add('deactive');
    setTimeout(() => {
        document.querySelector('.darkbackground2').style.display = "none";
        document.querySelector('body').style.overflowY = "auto";
    }, 300);
}
function openFilters() {
    document.querySelector('body').style.overflowY = "hidden";
}
function closeFilters() {
    document.querySelector('body').style.overflowY = "auto";
}