window.onload = function () {
    cacheFilterData();
    document.querySelector('#resetFilters').disabled = true;
    checkURL();
};

const brandsCheckboxes = document.querySelectorAll('.custom-brand-checkbox');
const sortSelect = document.querySelector('#sorting');
const limitChange = document.querySelector('#showCount');


function checkURL() {
    const urlParams = new URLSearchParams(window.location.search);
    let brand = urlParams.get('brand');
    let model = urlParams.get('model');

    if (brand !== null) {
        brand = brand.toLowerCase();
        const checkb = document.querySelector(`#${brand}Checkbox`);
        checkb.checked = true;
        if (model !== null) {
            model = model.toLowerCase();
            let idVal = model;
            idVal = idVal.replace(/\s+/g, '');
            idVal += 'Checkbox';
            const checkm = document.querySelector('#' + idVal);
            checkm.checked = true;
        } else {
            checkb.dispatchEvent(new Event('change'));
        }
        showFilters();
    }

    // model = model.toLowerCase();
}

setTimeout(() => {
    getAds(0, true);
}, 300);

function checkBransSelecter(element) {
    if (element.checked) {
        const parentElement = element.parentNode;
        const labela = parentElement.querySelector('label');
        if (!brandsSelected.includes(labela.innerHTML)) {
            brandsSelected.push(labela.innerHTML);
            brandsSelected.sort(function (a, b) {
                if (a.toUpperCase() > b.toUpperCase()) {
                    return 1;
                }
                if (a.toUpperCase() < b.toUpperCase()) {
                    return -1;
                }
                return 0;
            });
        }

        const allModelsElements = element.parentNode.parentNode.parentNode.querySelectorAll('.custom-dropdown-item');
        allModelsElements.forEach(x => {
            const checkbox = x.querySelector(`input[type="checkbox"]`);
            const exist = modelsSelected.find((element) => element.model.toLowerCase() == x.querySelector('label').innerHTML.toLowerCase());
            if (checkbox.checked) {
                // console.log(exist);
                if (exist == undefined) {
                    modelsSelected.push({
                        brand: labela.innerHTML,
                        model: x.querySelector('label').innerHTML
                    });

                    modelsSelected.sort(function (a, b) {
                        if (a.model.toUpperCase() > b.model.toUpperCase()) {
                            return 1;
                        }
                        if (a.model.toUpperCase() < b.model.toUpperCase()) {
                            return -1;
                        }
                        return 0;
                    });
                }
            } else {
                if (exist != undefined) {
                    modelsSelected = modelsSelected.filter((element) => {
                        return element.model.toLowerCase() != x.querySelector('label').innerHTML.toLowerCase();
                    });
                }
            }
        });
    } else {
        const parentElement = element.parentNode;
        const labela = parentElement.querySelector('label');
        brandsSelected = brandsSelected.filter(function (element) {
            return element !== labela.innerHTML;
        });

        const allModelsElements = element.parentNode.parentNode.parentNode.querySelectorAll('.custom-dropdown-item');
        allModelsElements.forEach(x => {
            checkModelSelected2(x)
        });
    }
}

function createBrandCheckerHandler(element) {
    return function () {
        checkBransSelecter(element)
    }
}

brandsCheckboxes.forEach(element => {
    element.addEventListener('change', createBrandCheckerHandler(element));
});

const modelsCheckboxes = document.querySelectorAll('.custom-dropdown-item');

function checkModelSelected(element) {
    const parentBrandCheckbox = element.parentNode.parentNode.querySelector('.custom-brand-checkbox');
    checkBransSelecter(parentBrandCheckbox);
}

function checkModelSelected2(element) {
    const labela = element.querySelector('label');
    modelsSelected = modelsSelected.filter(function (element) {
        return element.model !== labela.innerHTML;
    });
}

function createModelCheckerhandler(element) {
    return function () {
        checkModelSelected(element);
    }
}

modelsCheckboxes.forEach(element => {
    element.addEventListener('change', createModelCheckerhandler(element));
});

function getPrice() {
    const rangeMin = document.querySelectorAll('.input-min')[0];
    const rangeMax = document.querySelectorAll('.input-max')[0];

    if (rangeMin.value >= 0 && rangeMin.value <= 2500) {
        minPrice = rangeMin.value;
    }
    if (rangeMax.value >= 0 && rangeMax.value <= 2500) {
        maxPrice = rangeMax.value;
    }
}

function getDeal() {
    deal = document.querySelector('#deal').checked;
}

function getState() {
    oldState = document.querySelector("#oldState").checked;
    newState = document.querySelector("#newState").checked;
    damagedState = document.querySelector("#damagedState").checked;
}

function showFilters() {
    const savedFilterDataJson = localStorage.getItem('filterData');
    const filtersLabel = document.querySelectorAll('.filterstlabela')[0];
    filtersLabel.style.display = 'block';
    filtersLabel.innerHTML = '';

    if (savedFilterDataJson) {
        const savedInitialData = JSON.parse(savedFilterDataJson);

        const brandsSelected2 = savedInitialData.brandsSelected;
        const modelsSelected2 = savedInitialData.modelsSelected;
        const minPrice2 = savedInitialData.minPrice;
        const maxPrice2 = savedInitialData.maxPrice;
        const oldState2 = savedInitialData.oldState;
        const newState2 = savedInitialData.newState;
        const damagedState2 = savedInitialData.damagedState;
        const deal2 = savedInitialData.deal;

        const deleteFilters = document.createElement('a');
        deleteFilters.setAttribute('href', '#');
        deleteFilters.innerHTML = "X Obriši filtere";
        deleteFilters.addEventListener('click', resetFilters);
        deleteFilters.classList.add("removeFiltersLabel");
        filtersLabel.appendChild(deleteFilters);

        if (brandsSelected2 !== null) {
            for (let i = 0; i < brandsSelected2.length; i++) {
                const brand = document.createElement('a');
                brand.setAttribute('href', '#');
                brand.innerHTML = "X " + brandsSelected2[i];
                filtersLabel.appendChild(brand);
            }
        }
        if (modelsSelected2 !== null) {
            for (let i = 0; i < modelsSelected2.length; i++) {
                const models = document.createElement('a');
                models.setAttribute('href', '#');
                models.innerHTML = "X " + modelsSelected2[i].model;
                filtersLabel.appendChild(models);
            }
        }
        if (minPrice2 !== null && maxPrice2 !== null) {
            const price = document.createElement('a');
            price.setAttribute('href', '#');
            price.innerHTML = "X " + '€' + minPrice2 + ' - ' + '€' + maxPrice2;
            filtersLabel.appendChild(price);
        }
        if (oldState2) {
            const state = document.createElement('a');
            state.setAttribute('href', '#');
            state.innerHTML = "X Novo";
            filtersLabel.appendChild(state);
        }
        if (newState2) {
            const state = document.createElement('a');
            state.setAttribute('href', '#');
            state.innerHTML = "X Polovno";
            filtersLabel.appendChild(state);
        }
        if (damagedState2) {
            const state = document.createElement('a');
            state.setAttribute('href', '#');
            state.innerHTML = "X Oštećenje";
            filtersLabel.appendChild(state);
        }
        if (!deal2) {
            document.querySelector('#deal').checked = false;
        }
    }
}

document.querySelector("#sumbitFilters").addEventListener("click", function (e) {
    e.preventDefault();

    const urlParams = new URLSearchParams(window.location.search);
    for (const key of urlParams.keys()) {
        urlParams.delete(key);
    }
    window.history.replaceState({}, document.title, window.location.pathname);

    localStorage.removeItem('filterData');

    loadedAdsCounter = 0;
    allAdsCounter = 0;
    getState();
    getPrice();
    getDeal();

    cacheFilterData();
    document.querySelectorAll('.loadmorebutton')[0].setAttribute('current-page', 0);
    getAds(0, true);
    var sirinaProzora = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    if (sirinaProzora <= 991) {
        closeFilters();
        closeFiltersContainer();
    }
    showFilters();
});

function cacheFilterData() {
    initialDataToSave = {
        brandsSelected: brandsSelected,
        modelsSelected: modelsSelected,
        minPrice: minPrice,
        maxPrice: maxPrice,
        oldState: oldState,
        newState: newState,
        damagedState: damagedState,
        deal: deal
    };
    const initialDataJson = JSON.stringify(initialDataToSave);
    localStorage.setItem('filterData', initialDataJson);
    console.log('Azurirano');
}

function getLimit() {
    return numberOfLoads;
}

function getAds(currentPage, restart) {
    const savedFilterDataJson = localStorage.getItem('filterData');
    let brandsSelected2 = [];
    let modelsSelected2 = [];
    let minPrice2 = 0;
    let maxPrice2 = 2500;
    let oldState2 = false;
    let newState2 = false;
    let damagedState2 = false;
    let deal2 = true;

    if (savedFilterDataJson) {
        const savedInitialData = JSON.parse(savedFilterDataJson);
        brandsSelected2 = savedInitialData.brandsSelected;
        modelsSelected2 = savedInitialData.modelsSelected;
        minPrice2 = savedInitialData.minPrice;
        maxPrice2 = savedInitialData.maxPrice;
        oldState2 = savedInitialData.oldState;
        newState2 = savedInitialData.newState;
        damagedState2 = savedInitialData.damagedState;
        deal2 = savedInitialData.deal;
    }

    sort = sortSelect.value;



    let jsonmodels = JSON.stringify(modelsSelected2);
    let encodedModels = encodeURIComponent(jsonmodels);
    const limit = getLimit();
    const params = new URLSearchParams({
        action: 'getAds',
        sort: sort,
        brandsSelected: brandsSelected2.join(','),
        modelsSelected: encodedModels,
        minPrice: minPrice2,
        maxPrice: maxPrice2,
        oldState: oldState2,
        newState: newState2,
        damagedState: damagedState2,
        page: currentPage,
        limit: limit,
        deal: deal2,
    });

    FilterData(params, restart);
}

sortSelect.addEventListener("change", function () {
    loadedAdsCounter = 0;
    firstTry = false;
    document.querySelectorAll('.loadmorebutton')[0].setAttribute('current-page', 0);
    getAds(0, true);
});

function cahceLimitData(value) {
    numberOfLoads = parseInt(value);
}

limitChange.addEventListener("change", function () {
    loadedAdsCounter = 0;
    firstTry = false;
    document.querySelectorAll('.loadmorebutton')[0].setAttribute('current-page', 0);
    cahceLimitData(this.value);
    getAds(0, true);
});

let firstTry = true;
function cacheAdsCounter(value) {
    if (firstTry) {
        loadedAdsCounter = numberOfLoads;
        firstTry = false;
    } else {
        loadedAdsCounter += parseInt(value);
    }
}

function resetFilters() {
    const urlParams = new URLSearchParams(window.location.search);
    for (const key of urlParams.keys()) {
        urlParams.delete(key);
    }
    window.history.replaceState({}, document.title, window.location.pathname);
    loadedAdsCounter = 0;
    allAdsCounter = 0;
    localStorage.removeItem('filterData');
    firstTry = false;

    const brandsCheckboxes = document.querySelectorAll('.custom-brand-checkbox');
    brandsCheckboxes.forEach(element => {
        element.checked = false;
    });

    const modelsCheckboxesContainer = document.querySelectorAll('.custom-dropdown-item');
    modelsCheckboxesContainer.forEach(container => {
        const modelsCheckboxes = container.querySelectorAll('input');
        modelsCheckboxes.forEach(element => {
            element.checked = false;
        });
    });

    document.querySelectorAll('.input-min')[0].value = 0;
    document.querySelectorAll('.input-max')[0].value = 2500;
    document.querySelectorAll('.range-min')[0].value = 0;
    document.querySelectorAll('.range-max')[0].value = 2500;
    document.querySelectorAll('.progress')[0].style.left = "0px";
    document.querySelectorAll('.progress')[0].style.right = "0px";

    document.querySelector('#oldState').checked = false;
    document.querySelector('#newState').checked = false;
    document.querySelector('#damagedState').checked = false;

    document.querySelectorAll('.filterstlabela')[0].style.display = 'none';

    getAds(0, true);
}

document.querySelector('#resetFilters').addEventListener('click', resetFilters);

const mobileMenuTriggerOpen = document.querySelector('#mobile-menu-open');
const mobileMenuTriggerClose = document.querySelector('#mobile-menu-close');
mobileMenuTriggerOpen.addEventListener('click', function () {
    document.querySelector('body').style.overflowY = "hidden";
});
mobileMenuTriggerClose.addEventListener('click', function () {
    setTimeout(() => {
        document.querySelector('body').style.overflowY = "auto";
    }, 300);
});

function cacheAllAdsCounter(value) {
    allAdsCounter = parseInt(value);
}