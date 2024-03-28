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
}
function addModel(brand, model) {
    modelsSelected.push({
        brand: brand,
        model: model,
    });
}