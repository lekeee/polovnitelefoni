const title = document.querySelector("#Title");
const titleCounter = document.querySelector("#titleCounter");

title.addEventListener("input", function(){
    if(this.value.length > 60){
        this.value = this.value.substring(0, 60);
    }else{
        titleCounter.innerHTML = this.value.length;
    }
});

function updateValue() {
    var slider = document.getElementById("myRange");
    var output = document.getElementById("selected-value");
    output.innerHTML = "Stanje uređaja: " + slider.value + " / 10";
}


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

function addToSelectedAccessories(x){
    selectedAccessories.push(x);
    const indexToRemove = allAccessories.indexOf(x);
    if (indexToRemove !== -1) {
        allAccessories.splice(indexToRemove, 1);
    }
    displayAccessories();
    displaySelectedAccessoried();
}

function removeFromSelectedAccessories(x){
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
        divItem1.onclick = function() {
            addToSelectedAccessories(this.getAttribute("value"));
        };
        accessoriesList.appendChild(divItem1);
    }
}
displayAccessories();

function displaySelectedAccessoried(){
    const accessoriesList = document.getElementById("selectedAccessories");
    accessoriesList.innerHTML = '';
    if(selectedAccessories.length === 0){
        accessoriesList.style.display = 'none';
    }else{
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
        divItem1.onclick = function() {
            removeFromSelectedAccessories(this.getAttribute("value"));
        };
        accessoriesList.appendChild(divItem1);
    }
}
displaySelectedAccessoried();


