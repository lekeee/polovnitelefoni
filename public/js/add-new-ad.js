const title = document.querySelector("#Title");
const titleCounter = document.querySelector("#titleCounter");

title.addEventListener("input", function () {
    if (this.value.length > 60) {
        this.value = this.value.substring(0, 60);
    } else {
        titleCounter.innerHTML = this.value.length;
    }
});

function updateValue() {
    var slider = document.getElementById("myRange");
    var output = document.getElementById("selected-value");
    output.innerHTML = "Stanje uređaja: " + slider.value + " / 10";
}


//#region Dodatna Oprema
var selectedAccessories = [];
var allAccessories = [
    "Punjač",
    "Zaštitna maska",
    "Zaštitno staklo",
    "Slušalice",
    "Originalna kutija",
    "Zaštitna folija",
    "Zaštitna futrola",
    "Bežični punjač",
    "Dodatni objektivi",
    "Power bank",
    "SIM free"
];

if (typeof selectedAccessoriesTemp !== 'undefined') {
    selectedAccessoriesTemp.forEach(element => {
        selectedAccessories.push(element);
        const ind = allAccessories.indexOf(element);
        allAccessories.splice(ind, 1);
    })
}


function addToSelectedAccessories(x) {
    selectedAccessories.push(x);
    const indexToRemove = allAccessories.indexOf(x);
    if (indexToRemove !== -1) {
        allAccessories.splice(indexToRemove, 1);
    }
    displayAccessories();
    displaySelectedAccessoried();
}

function removeFromSelectedAccessories(x) {
    allAccessories.push(x);
    const indexToRemove = selectedAccessories.indexOf(x);
    if (indexToRemove !== -1) {
        selectedAccessories.splice(indexToRemove, 1);
    }
    displayAccessories();
    displaySelectedAccessoried();
}

function displayAccessories() {
    const accessoriesList = document.getElementById("accessoriesList");
    accessoriesList.innerHTML = '';
    for (var i = 0; i < allAccessories.length; i++) {
        const divItem1 = document.createElement("div");
        divItem1.classList.add("div-block-754");
        const divItem2 = document.createElement("div");
        divItem2.classList.add("text-block-67");
        divItem2.innerHTML = allAccessories[i];
        divItem1.setAttribute("value", allAccessories[i]);
        divItem1.appendChild(divItem2);
        divItem1.onclick = function () {
            addToSelectedAccessories(this.getAttribute("value"));
        };
        accessoriesList.appendChild(divItem1);
    }
}
displayAccessories();

function displaySelectedAccessoried() {
    const accessoriesList = document.getElementById("selectedAccessories");
    accessoriesList.innerHTML = '';
    if (selectedAccessories.length === 0) {
        accessoriesList.style.display = 'none';
    } else {
        accessoriesList.style.display = 'block';
    }
    for (var i = 0; i < selectedAccessories.length; i++) {
        const divItem1 = document.createElement("div");
        divItem1.classList.add("div-block-752");
        const divItem2 = document.createElement("div");
        divItem2.classList.add("text-block-66");
        divItem2.innerHTML = selectedAccessories[i];
        divItem1.appendChild(divItem2);
        divItem1.setAttribute("value", selectedAccessories[i]);
        divItem1.appendChild(divItem2);
        divItem1.onclick = function () {
            removeFromSelectedAccessories(this.getAttribute("value"));
        };
        accessoriesList.appendChild(divItem1);
    }
}
displaySelectedAccessoried();
//#endregion Dodatna Oprema

//#region Ostecenja
var selectedDamages = [];
var allDamages = [
    "Oštećen ekran",
    "Oštećeno kućište",
    "Problem s baterijom",
    "Zamrzavanje ili rušenje sistema",
    "WiFi/Bluetooth ne radi",
    "Kontakt s tečnostima",
    "Neispravna kamera",
    "Neispravan zvučnik/mikrofon",
    "Problem s osvetljenjem",
    "Problem s portom za punjenje"
];

if (typeof selectedDamages !== 'undefined') {
    selectedDamages.forEach(element => {
        selectedDamages.push(element);
        const ind = allDamages.indexOf(element);
        allDamages.splice(ind, 1);
    })
}

function addToSelectedDamage(x) {
    selectedDamages.push(x);
    const indexToRemove = allDamages.indexOf(x);
    if (indexToRemove !== -1) {
        allDamages.splice(indexToRemove, 1);
    }
    displayDamages();
    displaySelectedDamages();
}

function removeFromSelectedDamages(x) {
    allDamages.push(x);
    const indexToRemove = selectedDamages.indexOf(x);
    if (indexToRemove !== -1) {
        selectedDamages.splice(indexToRemove, 1);
    }
    displayDamages();
    displaySelectedDamages();
}

function displayDamages() {
    const damagesList = document.getElementById("damagesList");
    damagesList.innerHTML = '';
    for (var i = 0; i < allDamages.length; i++) {
        const divItem1 = document.createElement("div");
        divItem1.classList.add("div-block-754");
        const divItem2 = document.createElement("div");
        divItem2.classList.add("text-block-67");
        divItem2.innerHTML = allDamages[i];
        divItem1.setAttribute("value", allDamages[i]);
        divItem1.appendChild(divItem2);
        divItem1.onclick = function () {
            addToSelectedDamage(this.getAttribute("value"));
        };
        damagesList.appendChild(divItem1);
    }
}
displayDamages();

function displaySelectedDamages() {
    const damagesList = document.getElementById("selectedDamages");
    damagesList.innerHTML = '';
    if (selectedDamages.length === 0) {
        damagesList.style.display = 'none';
    } else {
        damagesList.style.display = 'block';
    }
    for (var i = 0; i < selectedDamages.length; i++) {
        const divItem1 = document.createElement("div");
        divItem1.classList.add("div-block-752");
        divItem1.classList.add("ostecenja");
        const divItem2 = document.createElement("div");
        divItem2.classList.add("text-block-66");
        divItem2.innerHTML = selectedDamages[i];
        divItem1.appendChild(divItem2);
        divItem1.setAttribute("value", selectedDamages[i]);
        divItem1.appendChild(divItem2);
        divItem1.onclick = function () {
            removeFromSelectedDamages(this.getAttribute("value"));
        };
        damagesList.appendChild(divItem1);
    }
}
displaySelectedDamages();
//#endregion Ostecenja

//#region proveraStanjaUredjaja
function checkUserState() {
    const deviceStateRadio = document.querySelector('input[name="deviceState"]:checked');
    if (deviceStateRadio) {
        const radioValue = deviceStateRadio.value;
        const newStateLabel = document.querySelector('#newState');
        const oldStateLabel = document.querySelector('#oldState');
        const deviceStateRate = document.querySelector('#deviceStateRate');
        const deviceState = document.querySelector("#deviceState");
        if (radioValue === "newState") {
            oldStateLabel.style.color = "black";
            oldStateLabel.style.backgroundColor = "white";
            newStateLabel.style.color = "white";
            newStateLabel.style.backgroundColor = "#ed6969";
            deviceStateRate.style.display = 'none';
            deviceState.style.borderBottom = "1px solid #ddd";
        } else {
            newStateLabel.style.color = "black";
            newStateLabel.style.backgroundColor = "white";
            oldStateLabel.style.color = "white";
            oldStateLabel.style.backgroundColor = "#ed6969";
            deviceStateRate.style.display = 'flex';
            deviceState.style.borderBottom = "none";
        }
    }
}
checkUserState();
//#endregion proveraStanjaUredjaja

//#region cena ili dogovor
function dealOrPrice() {
    const deal = document.querySelector('input[name="deal"]');
    const dealBackground = document.querySelector('#dealBackground');
    const priceContainer = document.querySelector('#price');

    if (deal.checked) {
        priceContainer.value = '';
        dealBackground.style.color = "white";
        dealBackground.style.backgroundColor = "#ed6969";
        priceContainer.disabled = true;
    } else {
        dealBackground.style.color = "black";
        dealBackground.style.backgroundColor = "white";
        priceContainer.disabled = false;
    }
}
dealOrPrice();
//#endregion cena ili dogovor

function showErrorNotification(status, value) {
    stopLoadingAnimation("saveData");
    const errorContainer = document.querySelector('#error');

    const errorInsideContainre = errorContainer.querySelector("div");
    if (status === 0)
        errorInsideContainre.style.borderColor = "red";
    else
        errorInsideContainre.style.borderColor = "lightgreen";
    const errorText = document.querySelector('#errorText');
    errorText.innerHTML = value;
    errorContainer.style.display = "flex";
    window.location.href = "#error";
}

function titleValidation(title) {
    console.log('tu sam');
    if (title.trim() === '') {
        showErrorNotification(0, "GRESKA: Naslov oglasa je obavezan!");
        return false;
    } else if (title.length <= 10) {
        showErrorNotification(0, "GRESKA: Naslov oglasa mora biti duži od 10 karaktera!");
        return false;
    } else if (title.length > 60) {
        showErrorNotification(0, "GRESKA: Naslov oglasa mora biti kraci od 60 karaktera!");
        return false;
    }
    return true;
}
function brandValidation(brand) {
    if (brand.trim() === '') {
        showErrorNotification(0, "Morate izabrati brend mobilnog telefona!");
        return false;
    }
    return true;
}
function modelValidation(model) {
    if (model.trim() === '') {
        showErrorNotification(0, "Morate izabrati model mobilnog telefona!");
        return false;
    }
    return true;
}
function imageValidations(images) {
    if (images.length < 2) {
        showErrorNotification(0, "Morate izabrati najmanje dve fotografije!");
        return false;
    } else if (images.length > 10) {
        showErrorNotification(0, "Morate izabrati najviše deset fotografije!");
        return false;
    }
    return true;
}
function descriptionValidation(description) {
    if (description.length <= 20) {
        showErrorNotification(0, "Opis mora biti duzi od 20 karaktera!");
        return false;
    } else if (description.length > 2000) {
        showErrorNotification(0, "Opis mora biti kraci od 2000 karaktera!");
        return false;
    }
    return true;
}

function priceValidation() {
    const dealInput = document.querySelector("#deal");
    const priceInput = document.querySelector("#price");

    if (!dealInput.checked) {
        if (priceInput.trim() !== '') {
            return true;
        } else {
            showErrorNotification(0, "Morate uneti cenu oglasa! (Ukoliko ne želite da navedete cenu telefona, možete selektovati KONTAKT)");
            return false;
        }
    }
}
const termss = document.querySelectorAll('input[name="term"]');
termss[0].addEventListener("click", function () {
    this.style.borderColor = "#041e42";
});
termss[1].addEventListener("click", function () {
    this.style.borderColor = "#041e42";
});

function damageListToString() {
    let result = '';
    selectedDamages.forEach(element => {
        result += (element + ', ');
    });
    return result;
}
function accessoriesListToString() {
    let result = '';
    selectedAccessories.forEach(element => {
        result += (element + ', ');
    });
    return result;
}

function sendDataToController(
    title,
    brand,
    model,
    deviceState,
    stateRange,
    images,
    description,
    deal,
    price,
    terms
) {
    const damagesString = damageListToString();
    const accessoriesString = accessoriesListToString();

    fetch('../app/controllers/adController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'newAd',
            title: title,
            brand: brand,
            model: model,
            deviceState: deviceState,
            stateRange: stateRange,
            images: images,
            description: description,
            deal: deal,
            price: price,
            terms: terms,
            accessories: accessoriesString,
            damages: damagesString
        })
    })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Doslo je do greske prilikom prihvatanja zahteva.');
            }
        })
        .then(data => {
            stopLoadingAnimation("saveData");
            if (data.status === 'error') {
                showErrorNotification(0, "Došlo je do greške. Molimo pokušajte kasnije!");
            } else {
                showErrorNotification(1, "Oglas je uspešno kreiran i poslat na proveru. Administratori će pogledati Vaš oglas i ukoliko on podržava sva ograničenja, biće odobren. Kada administratori odobre (ili ne) vaš oglas, bićete obavešteni putem email adrese.");
            }
        })
        .catch(error => {
            showErrorNotification(0, "Došlo je do greške. Molimo pokušajte kasnije!");
        });
}

//#region slanje podataka
const saveDataBtn = document.querySelector("#saveData");
saveDataBtn.addEventListener("click", function () {
    console.log("Kliknuto");
    const titleInput = document.querySelector("#Title").value;
    const brandInput = document.querySelector("#brandSelect").value;
    const modelInput = document.querySelector("#modelSelect").value;
    const deviceStateRadio = document.querySelector('input[name="deviceState"]:checked').value;
    const stateRangeValue = document.querySelector("#myRange").value;
    // const images = document.querySelectorAll(".uploadedImage img");
    const images = document.querySelectorAll(".listitemClass");
    const description = document.querySelector("#editor").innerHTML;
    const deal = document.querySelector('input[name="deal"]');
    const price = document.querySelector('#price').value;
    const terms = document.querySelectorAll('input[name="term"]');

    startLoadingAnimation("saveData");
    this.style.backgroundSize = '3%';

    if (!terms[0].checked) {
        document.querySelector('#term1').style.borderColor = "red";
        stopLoadingAnimation("saveData");
        return;
    } if (!terms[1].checked) {
        document.querySelector('#term2').style.borderColor = "red";
        stopLoadingAnimation("saveData");
        return;
    }
    var imagesSrc = [];
    images.forEach(element => {
        let backgroundImage = window.getComputedStyle(element).getPropertyValue('background-image');
        imagesSrc.push(backgroundImage);
    });
    if (titleValidation(titleInput) && brandValidation(brandInput) && modelValidation(modelInput)
        && imageValidations(images) && descriptionValidation(description)) {
        sendDataToController(titleInput, brandInput, modelInput, deviceStateRadio, stateRangeValue, imagesSrc, description, deal.checked, price, terms[0].checked && terms[1].checked);
    }

    const updateIdentificato = this.getAttribute('update');
    if (updateIdentificato != '') {
        deleteAdUpdate(updateIdentificato);
    }
});
//#endregion slanje podataka



document.getElementById('price').addEventListener('focus', function () {
    this.classList.add('focused');
});

document.getElementById('price').addEventListener('blur', function () {
    this.classList.remove('focused');
});


async function deleteAdUpdate(adID) {
    await fetch('../app/controllers/myAdsController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'deleteAd',
            ad_id: adID,
        })
    })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Doslo je do greske prilikom prihvatanja zahteva.');
            }
        })
        .then(data => {
            if (data.status === 'success') {

            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}
