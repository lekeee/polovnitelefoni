window.onload = function() {
    localStorage.removeItem('filterData');
};
getAds();

const brandsCheckboxes = document.querySelectorAll('.custom-brand-checkbox');
const sortSelect = document.querySelector('#sorting');

let brandsSelected = [];
let modelsSelected = [];
let sort = 0;
let minPrice = 625;
let maxPrice = 1875;
let oldState = false;
let newState = false;
let damagedState = false;

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

document.querySelector("#sumbitFilters").addEventListener("click", function (e) {
    e.preventDefault();

    getPrice();
    getState();

    sort = sortSelect.value;
    let encodedModels;
    if (modelsSelected.length === 0) {
        encodedModels = null;
    } else {
        let jsonmodels = JSON.stringify(modelsSelected);
        encodedModels = encodeURIComponent(jsonmodels);
    }

    const params = new URLSearchParams({
        sort: sort,
        brandsSelected: brandsSelected.join(','),
        modelsSelected: encodedModels,
        minPrice: minPrice,
        maxPrice: maxPrice,
        oldState: oldState,
        newState: newState,
        damagedState: damagedState
    });

    cacheFilterData(minPrice, maxPrice, oldState, newState, damagedState);
    FilterData(params);
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

sortSelect.addEventListener("change", function () {
    // getPrice();
    // getState();

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
        damagedState: damagedState2
    });

    // console.log(sort);

    FilterData(params);
});
