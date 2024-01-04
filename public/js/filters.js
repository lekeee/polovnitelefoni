window.onload = function () {
    localStorage.removeItem('filterData');
    document.querySelector('#resetFilters').disabled = true;
};

const brandsCheckboxes = document.querySelectorAll('.custom-brand-checkbox');
const sortSelect = document.querySelector('#sorting');


let brandsSelected = [];
let modelsSelected = [];
let sort = 0;
let minPrice = 0;
let maxPrice = 2500;
let oldState = false;
let newState = false;
let damagedState = false;

getAds(0, true);
function checkBransSelecter(element) {
    if (element.checked) {
        const parentElement = element.parentNode;
        const labela = parentElement.querySelector('label');
        if (!brandsSelected.includes(labela.innerHTML)) {
            brandsSelected.push(labela.innerHTML);
        }
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
    const checkbox = element.querySelector(`input[type="checkbox"]`);
    if (checkbox.checked) {
        const parentBrandCheckbox = element.parentNode.parentNode.querySelector('.custom-brand-checkbox');
        checkBransSelecter(parentBrandCheckbox);

        const brandvalue = element.getAttribute('brand-selector');
        const labela = element.querySelector('label');
        modelsSelected.push({
            brand: brandvalue,
            model: labela.innerHTML
        }
        );
    } else {
        const parentBrandCheckbox = element.parentNode.parentNode.querySelector('.custom-brand-checkbox');
        checkBransSelecter(parentBrandCheckbox);

        const labela = element.querySelector('label');
        modelsSelected = modelsSelected.filter(function (element) {
            return element.model !== labela.innerHTML;
        });
    }
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

function getState() {
    if (document.querySelector("#oldState").checked) {
        oldState = true;
    }
    if (document.querySelector("#newState").checked) {
        newState = true;
    }
    if (document.querySelector("#damagedState").checked) {
        damagedState = true;
    }
}

function showFilters(){
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

        console.log(brandsSelected2 + " " + modelsSelected2 + " " + minPrice2 + " " + maxPrice2 + " " + oldState2 + " " + newState2 + " " + damagedState2);
        const deleteFilters = document.createElement('a');
        deleteFilters.setAttribute('href', '#');
        deleteFilters.innerHTML = "X Obriši filtere";
        deleteFilters.addEventListener('click', resetFilters);
        deleteFilters.classList.add("removeFiltersLabel");
        filtersLabel.appendChild(deleteFilters);

        if(brandsSelected2 !== null){
            for(let i = 0; i < brandsSelected2.length; i++){
                const brand = document.createElement('a');
                brand.setAttribute('href', '#');
                brand.innerHTML = "X " + brandsSelected2[i];
                filtersLabel.appendChild(brand);
            }
        }
        if (modelsSelected2 !== null){
            for(let i = 0; i < modelsSelected2.length; i++){
                const models = document.createElement('a');
                models.setAttribute('href', '#');
                models.innerHTML = "X " + modelsSelected2[i].model;
                filtersLabel.appendChild(models);
            }
        }
        if(minPrice2 !== null && maxPrice2 !== null){
            const price = document.createElement('a');
            price.setAttribute('href', '#');
            price.innerHTML = "X " + '€' + minPrice2 + ' - ' + '€' + maxPrice2;
            filtersLabel.appendChild(price);
        }
        if(oldState2){
            const state = document.createElement('a');
            state.setAttribute('href', '#');
            state.innerHTML = "X Novo";
            filtersLabel.appendChild(state);
        }
        if(newState2){
            const state = document.createElement('a');
            state.setAttribute('href', '#');
            state.innerHTML = "X Polovno";
            filtersLabel.appendChild(state);
        }
        if(damagedState2){
            const state = document.createElement('a');
            state.setAttribute('href', '#');
            state.innerHTML = "X Oštećenje";
            filtersLabel.appendChild(state);
        }
    }
}

document.querySelector("#sumbitFilters").addEventListener("click", function (e) {
    e.preventDefault();
    getState();
    cacheFilterData(minPrice, maxPrice, oldState, newState, damagedState);
    document.querySelectorAll('.loadmorebutton')[0].setAttribute('current-page', 0);
    getAds(0, true);
    var sirinaProzora = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    if(sirinaProzora <= 991){
        closeFilters();
        closeFiltersContainer();
    }
    showFilters();
});

function cacheFilterData(minPrice, maxPrice, oldState, newState, damagedState) {
    const initialDataToSave = {
        brandsSelected: brandsSelected,
        modelsSelected: modelsSelected,
        minPrice: minPrice,
        maxPrice: maxPrice,
        oldState: oldState,
        newState: newState,
        damagedState: damagedState
    };

    const initialDataJson = JSON.stringify(initialDataToSave);
    localStorage.setItem('filterData', initialDataJson);
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

    if (savedFilterDataJson) {
        const savedInitialData = JSON.parse(savedFilterDataJson);
        brandsSelected2 = savedInitialData.brandsSelected;
        modelsSelected2 = savedInitialData.modelsSelected;
        minPrice2 = savedInitialData.minPrice;
        maxPrice2 = savedInitialData.maxPrice;
        oldState2 = savedInitialData.oldState;
        newState2 = savedInitialData.newState;
        damagedState2 = savedInitialData.damagedState;
    }

    sort = sortSelect.value;

    let jsonmodels = JSON.stringify(modelsSelected2);
    let encodedModels = encodeURIComponent(jsonmodels);

    const params = new URLSearchParams({
        sort: sort,
        brandsSelected: brandsSelected2.join(','),
        modelsSelected: encodedModels,
        minPrice: minPrice2,
        maxPrice: maxPrice2,
        oldState: oldState2,
        newState: newState2,
        damagedState: damagedState2,
        page: currentPage,
    });

    // console.log(sort);
    FilterData(params, restart);
}

sortSelect.addEventListener("change", function () {
    document.querySelectorAll('.loadmorebutton')[0].setAttribute('current-page', 0);
    getAds(0, true);
});


function resetFilters(){
    localStorage.removeItem('filterData');
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
mobileMenuTriggerOpen.addEventListener('click', function(){
    document.querySelector('body').style.overflowY = "hidden";
});
mobileMenuTriggerClose.addEventListener('click', function(){
    setTimeout(() => {
        document.querySelector('body').style.overflowY = "auto";
    }, 300);
});