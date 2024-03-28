import { telefoni } from "../js-public/popular-phones.js";

const mainElement = document.querySelector('#quick-phone-models');

telefoni.forEach(telefon => {
    var divElement = document.createElement('div');
    divElement.className = 'div-block-46';

    var linkElement = document.createElement('a');
    linkElement.href = '#';
    linkElement.className = 'link-block-8 w-inline-block quick-phone';

    var textDivElement = document.createElement('div');
    textDivElement.className = 'text-block-33';
    textDivElement.textContent = `${telefon.brand} ${telefon.model}`;
    textDivElement.setAttribute('brand', telefon.brand);
    textDivElement.setAttribute('model', telefon.model);

    textDivElement.onclick = () => { clickBrandModel(textDivElement) };

    linkElement.appendChild(textDivElement);

    var dividerElement = document.createElement('div');
    dividerElement.className = 'text-block-32';
    dividerElement.textContent = ' | ';

    divElement.appendChild(linkElement);
    divElement.appendChild(dividerElement);

    mainElement.appendChild(divElement);
});

function clickBrandModel(x) {
    window.location.href = `../views/index.php?brand=${x.getAttribute('brand')}&model=${x.getAttribute('model')}#productscontainer`;
}