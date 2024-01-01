const specsDiv = document.querySelectorAll('.specsdiv')[0];
const loaderContainer = document.querySelector('#loader-container');

function getKeyByBrandAndModel(data, brandName, modelName) {
    for (const brand of data) {
        if (brand.brand_name && brand.brand_name.toLowerCase() === brandName.toLowerCase()) {
            for (const device of brand.device_list) {
                if (device.device_name.toLowerCase() === modelName.toLowerCase()) {
                    return device.key;
                }
            }
        }
    }
    return null;
}

function getSpecifications(brandName, modelName){
    loaderContainer.style.display = "flex";
    const jsonDataPath = '../public/JSON/sortedData.json';

    fetch(jsonDataPath)
    .then(response => response.json())
    .then(jsonData => {
        const key = getKeyByBrandAndModel(jsonData, brandName, modelName);
        if (key !== null) {
            getSpecificationsData(key);
        } else {
            console.log("Nije pronađen odgovarajući key.");
        }
    })
    .catch(error => console.error('Greška prilikom učitavanja JSON fajla:', error));

}


function getSpecificationsData(key){
    var cachedData = localStorage.getItem(key);

    if (cachedData) {
        loaderContainer.style.display = "none";
        var parsedData = JSON.parse(cachedData);
        showSpecs(parsedData);
        //console.log(parsedData);

    } else {
        var raw = JSON.stringify({
            "route": "device-detail",
            "key": key
        });

        var requestOptions = {
            method: 'POST',
            body: raw,
            redirect: 'follow'
        };

        fetch("https://script.google.com/macros/s/AKfycbxNu27V2Y2LuKUIQMK8lX1y0joB6YmG6hUwB1fNeVbgzEh22TcDGrOak03Fk3uBHmz-/exec", requestOptions)
            .then(response => response.json())
            .then(result => {
                loaderContainer.style.display = "none";
                localStorage.setItem(key, JSON.stringify(result));
                showSpecs(result);
                //console.log(result);
            })
            .catch(error => console.log('error', error));
    }
}

function appendSpecsRow( firstColumnContent, secondColumnContent) {

    var specsRow = document.createElement("div");
    specsRow.className = "specrow";

    var firstColumn = document.createElement("div");
    firstColumn.classList.add("firstcolumn");
    firstColumn.classList.add("div-block-732");
    firstColumn.textContent = firstColumnContent;

    var secondColumn = document.createElement("div");
    secondColumn.classList.add("seconcolumn");
    secondColumn.classList.add("div-block-733");
    secondColumn.textContent = secondColumnContent;

    specsRow.appendChild(firstColumn);
    specsRow.appendChild(secondColumn);

    specsDiv.appendChild(specsRow);
}

function showSpecs(jsonObj){
    appendSpecsRow("Baterija", jsonObj.data.battery);
    appendSpecsRow("Tip baterije", jsonObj.data.batteryType);
    appendSpecsRow("Telo telefona", jsonObj.data.body);
    appendSpecsRow("Kamera", jsonObj.data.camera);
    appendSpecsRow("Čipset", jsonObj.data.chipset);
    appendSpecsRow("Verzije", jsonObj.data.comment);
    appendSpecsRow("Rezolucija ekrana", jsonObj.data.display_res);
    appendSpecsRow("Veličina ekrana", jsonObj.data.display_size);
    
    jsonObj.data.more_specification.forEach(function (section) {
        var sectionTitle = document.createElement("h2");
        sectionTitle.style.fontSize = "28px";
        sectionTitle.style.paddingLeft = "20px";
        sectionTitle.textContent = translateToSerbian(section.title);
        specsDiv.appendChild(sectionTitle);
    
        section.data.forEach(function (item) {
            appendSpecsRow(translateToSerbian(item.title), item.data[0]);
        });
    });
    
    appendSpecsRow("Operativni sistem", jsonObj.data.os_type);
    appendSpecsRow("RAM", jsonObj.data.ram);
    appendSpecsRow("Datum objavljivanja", jsonObj.data.release_date);
    appendSpecsRow("Memorijski prostor", jsonObj.data.storage);
    appendSpecsRow("Video", jsonObj.data.video);
}

function translateToSerbian(englishText) {
    const translationMap = {
        "Network": "Mreža",
        "Technology": "Tehnologija",
        "2G bands": "2G opsezi",
        "3G bands": "3G opsezi",
        "4G bands": "4G opsezi",
        "5G bands": "5G opsezi",
        "Speed": "Brzina",
        "Launch": "Lansiranje",
        "Announced": "Najavljeno",
        "Status": "Status",
        "Body": "Kućište",
        "Dimensions": "Dimenzije",
        "Weight": "Težina",
        "Build": "Izrada",
        "SIM": "SIM kartica",
        "Display": "Ekran",
        "Type": "Tip",
        "Size": "Veličina",
        "Resolution": "Rezolucija",
        "Protection": "Zaštita",
        "Platform": "Platforma",
        "OS": "Operativni sistem",
        "Chipset": "Čipset",
        "CPU": "Procesor",
        "GPU": "Grafički procesor",
        "Memory": "Memorija",
        "Card slot": "Slot za karticu",
        "Internal": "Interni prostor",
        "Main Camera": "Glavna kamera",
        "Single": "Jedna",
        "Features": "Funkcije",
        "Video": "Video",
        "Selfie camera": "Selfi kamera",
        "Dual": "Dvostruka",
        "Sound": "Zvuk",
        "Loudspeaker": "Zvučnik",
        "3.5mm jack": "3.5mm priključak",
        "Comms": "Komunikacija",
        "WLAN": "Wi-Fi",
        "Bluetooth": "Bluetooth",
        "Positioning": "Pozicioniranje",
        "NFC": "NFC",
        "Radio": "Radio",
        "USB": "USB",
        "Features": "Funkcije",
        "Sensors": "Senzori",
        "Battery": "Baterija",
        "Type": "Tip",
        "Charging": "Punjenje",
        "Talk time": "Vreme razgovora",
        "Music play": "Vreme reprodukcije muzike",
        "Misc": "Razno",
        "Colors": "Boje",
        "Models": "Modeli",
        "SAR": "SAR",
        "SAR EU": "SAR EU",
        "Price": "Cena",
        "Tests": "Testovi",
        "Performance": "Performanse",
        "Display": "Ekran",
        "Camera": "Kamera",
        "Loudspeaker": "Zvučnik",
        "Audio quality": "Kvalitet zvuka",
        "Battery (old)": "Baterija (stara)",
        "Battery (new)": "Baterija (nova)",
        "Endurance rating": "Ocena izdržljivosti"
    };

    return translationMap[englishText] || englishText;
}