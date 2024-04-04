import dataJSON from './brands_models.json' assert { type: 'json' };
const BrandDropdown = document.querySelector("#brandDropdown");
const DeviceDropdown = document.querySelector("#deviceDropdown"); 
const specsDiv = document.querySelector("#specsdiv");

function getBrandList() {
    var requestOptions = {
        method: 'GET',
        redirect: 'follow'
    };

    fetch("https://script.google.com/macros/s/AKfycbxNu27V2Y2LuKUIQMK8lX1y0joB6YmG6hUwB1fNeVbgzEh22TcDGrOak03Fk3uBHmz-/exec?route=brand-list", requestOptions)
        .then(response => response.json())  // Promenjeno da parsira JSON
        .then(result => console.log(result))
        .catch(error => console.log('error', error));
}

function getDeviceList(){
    var requestOptions = {
        method: 'GET',
        redirect: 'follow'
      };
      
      fetch("https://script.google.com/macros/s/AKfycbxNu27V2Y2LuKUIQMK8lX1y0joB6YmG6hUwB1fNeVbgzEh22TcDGrOak03Fk3uBHmz-/exec?route=device-list", requestOptions)
        .then(response => response.json())
        .then(result => console.log(result))
        .catch(error => console.log('error', error));
}

function deviceDetail(key){
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
        //console.log(result);
        showSpecs(result);
    })
    .catch(error => console.log('error', error));
}

function brandDropdown(data) {
    data.sort((a, b) => a.brand_name.localeCompare(b.brand_name));

    BrandDropdown.addEventListener("change", function () {
        var selectedIndex = BrandDropdown.selectedIndex;
        var selectedBrand = BrandDropdown.options[selectedIndex].text;
        var selectedBrandId = BrandDropdown.options[selectedIndex].value;

        deviceDropdown(data, selectedBrand, selectedBrandId);
    });

    data.forEach(function (brand) {
        var option = document.createElement("option");
        option.value = brand.brand_id;
        option.text = brand.brand_name;
        BrandDropdown.add(option);
    });
}
  
function deviceDropdown(responseData, brand, brand_id) {
    clearDropdown(DeviceDropdown);

    let Brands = responseData.filter(function(brands){
        return brands.brand_id == brand_id && brands.brand_name == brand;
    });
    //console.log(Brands);

    let deviceList = Brands[0].device_list.sort((a, b) => b.device_id - a.device_id);

    deviceList.forEach(function (device) {
        var option = document.createElement("option");
        option.value = device.key;
        option.text = device.device_name;
        DeviceDropdown.add(option);
    });
}

DeviceDropdown.addEventListener("change", function () {
    var selectedIndex = DeviceDropdown.selectedIndex;
    var selectedKey = DeviceDropdown.options[selectedIndex].value;
    deviceDetail(selectedKey);
});

function clearDropdown(dropdown) {
    dropdown.innerHTML = "";
    var opt = document.createElement('option');
    opt.value = "";
    opt.innerHTML = "Izaberite model";
    dropdown.appendChild(opt);
    opt.selected = true;
}

brandDropdown(dataJSON);


function appendSpecsRow( firstColumnContent, secondColumnContent) {

    var specsRow = document.createElement("div");
    specsRow.className = "specsrow";

    var firstColumn = document.createElement("div");
    firstColumn.className = "firstcolumn";
    firstColumn.textContent = firstColumnContent;

    var secondColumn = document.createElement("div");
    secondColumn.className = "secondcolumn";
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
    appendSpecsRow("Cipset", jsonObj.data.chipset);
    appendSpecsRow("Verzije", jsonObj.data.comment);
    appendSpecsRow("Rezolucija ekrana", jsonObj.data.display_res);
    appendSpecsRow("Velicina ekrana", jsonObj.data.display_size);
    
    jsonObj.data.more_specification.forEach(function (section) {
        var sectionTitle = document.createElement("h2");
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
