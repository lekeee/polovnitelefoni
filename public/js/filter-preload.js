let brandsSelected = [];
let modelsSelected = [];
let sort = 0;
let minPrice = 0;
let maxPrice = 2500;
let oldState = false;
let newState = false;
let damagedState = false;
let deal = true;
let city = '0'; // Nije izabran
let title = null;

//! PROMENITI U 16 || 32...

let numberOfLoads = 2; let initialNumberOfLoads = 2;
let allAdsCounter = 0;
let loadedAdsCounter = 0;

function addBrand(value) {
    brandsSelected.push(value);
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
function addModel(brand, model) {
    modelsSelected.push({
        brand: brand,
        model: model,
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

function removeBrand(value) {
    const index = brandsSelected.findIndex((element) => element == value);
    if (index !== -1) brandsSelected.splice(index, 1);
}

function removeModel(brand, model) {
    const index = modelsSelected.findIndex((element) => element.brand == brand && element.model == model);
    if (index !== -1) modelsSelected.splice(index, 1);
}
function removeModelOnlyBrand(brand) {
    let index = 1;
    while (index !== -1) {
        index = modelsSelected.findIndex((element) => element.brand == brand);
        // console.log(modelsSelected[index]);
        if (index !== -1)
            modelsSelected.splice(index, 1);
    }
}
