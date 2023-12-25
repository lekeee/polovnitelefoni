function getBrandList() {
    var requestOptions = {
        method: 'GET',
        redirect: 'follow'
    };

    fetch("https://script.google.com/macros/s/AKfycbxNu27V2Y2LuKUIQMK8lX1y0joB6YmG6hUwB1fNeVbgzEh22TcDGrOak03Fk3uBHmz-/exec?route=brand-list", requestOptions)
        .then(response => response.json())  // Promenjeno da parsira JSON
        .then(result => {
            // Sortiraj brendove po imenu
            var sortedBrands = result.data.sort((a, b) => a.brand_name.localeCompare(b.brand_name));
            brandDropdown(sortedBrands);
        })
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
        console.log(result);
        showSpecs(result);
    })
    .catch(error => console.log('error', error));
}

function deviceListByBrand(brandId, brandName, page) {
    fetchData(brandId, brandName, page);
}

function clearDropdown() {
    var dropdown = document.getElementById("deviceDropdown");
    dropdown.innerHTML = "";

    var opt = document.createElement('option');
    opt.value = "";
    opt.innerHTML = "Izaberite model";
    dropdown.appendChild(opt);
    opt.selected = true;
}

function fetchData(brandId, brandName, page) {
    var raw = JSON.stringify({
        "route": "device-list-by-brand",
        "brand_id": brandId,
        "brand_name": brandName,
        "page": page
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
            // Ako je ovo prva stranica, dohvati totalPage i zatim pozovi deviceDropdown
            if (page === 1) {
                var totalPage = result.data.total_page;
                deviceDropdown(result);
                
                // Pozovi deviceListByBrand za sve stranice
                for (let nextPage = 2; nextPage <= totalPage; nextPage++) {
                    deviceListByBrand(brandId, brandName, nextPage);
                }
            } else {
                // Ako nije prva stranica, samo pozovi deviceDropdown
                deviceDropdown(result);
            }
        })
        .catch(error => console.log('error', error));
}

function brandDropdown(data) {
    var dropdown = document.querySelector("#brandDropdown");

    dropdown.addEventListener("change", function () {
        var selectedIndex = dropdown.selectedIndex;
        var selectedText = dropdown.options[selectedIndex].text;
        var selectedBrandId = dropdown.options[selectedIndex].value;
        //console.log(selectedBrandId + "_" + selectedText);
        clearDropdown();
        deviceListByBrand(parseInt(selectedBrandId, 10), selectedText, 1);
    });

    data.forEach(function (brand) {
        var option = document.createElement("option");
        option.value = brand.brand_id;
        option.text = brand.brand_name;
        dropdown.add(option);
    });
}
const devDropdown = document.querySelector("#deviceDropdown");   
function deviceDropdown(responseData) {
    var deviceList = responseData.data.device_list;
    deviceList.forEach(function (device) {
        var option = document.createElement("option");
        option.value = device.key;
        option.text = device.device_name;
        devDropdown.add(option);
    });
}

devDropdown.addEventListener("change", function () {
    var selectedIndex = devDropdown.selectedIndex;
    var selectedKey = devDropdown.options[selectedIndex].value;
    deviceDetail(selectedKey);
});

const specsDiv = document.querySelector("#specsdiv")
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

function cyrillicToLatin(cyrillicText) {
    var conversionMap = {
      'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'ђ': 'đ',
      'е': 'e', 'ж': 'ž', 'з': 'z', 'и': 'i', 'ј': 'j', 'к': 'k',
      'л': 'l', 'љ': 'lj', 'м': 'm', 'н': 'n', 'њ': 'nj', 'о': 'o',
      'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'ћ': 'ć', 'у': 'u',
      'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'č', 'џ': 'dž', 'ш': 'š',
      'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Ђ': 'Đ',
      'Е': 'E', 'Ж': 'Ž', 'З': 'Z', 'И': 'I', 'Ј': 'J', 'К': 'K',
      'Л': 'L', 'Љ': 'Lj', 'М': 'M', 'Н': 'N', 'Њ': 'Nj', 'О': 'O',
      'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'Ћ': 'Ć', 'У': 'U',
      'Ф': 'F', 'Х': 'H', 'Ц': 'C', 'Ч': 'Č', 'Џ': 'Dž', 'Ш': 'Š'
    };
  
    var latinText = cyrillicText.replace(/[а-шА-Ш]/g, function(match) {
      return conversionMap[match];
    });
  
    return latinText;
  }
  
  async function translate(sourceText){
    //nekad ce da platimo API za translate ili ja nadjem free :D
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

window.onload = getBrandList;

