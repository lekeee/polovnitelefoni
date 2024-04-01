let brandsSelected = [];
let modelsSelected = [];
let sort = 0;
let minPrice = 0;
let maxPrice = 2500;
let oldState = false;
let newState = false;
let damagedState = false;
let deal = true;

//! PROMENITI U 16||32...
let numberOfLoads = 2;
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