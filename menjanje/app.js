let divs = [];
let numOfDivs = 10;

const beautifulColors = [
    "#FF69B4", // Hot pink
    "#00CED1", // Dark turquoise
    "#FFD700", // Gold
    "#9370DB", // Medium purple
    "#32CD32", // Lime green
    "#87CEEB", // Sky blue
    "#FFA500", // Orange
    "#6A5ACD", // Slate blue
    "#FF4500", // Orange red
    "#20B2AA"  // Light sea green
];

// for (let i = 0; i < numOfDivs; i++) {
//     let div = document.createElement("div");
//     div.innerHTML = i + 1;
//     div.classList.add("divs");
//     div.setAttribute('id', i+1); 
//     div.style.backgroundImage = `url(image${i + 1}.jpg)`; 
    
//     document.body.appendChild(div);
//     divs.push({ "element": div, "order": i }); 

//     div.draggable = true;
//     div.addEventListener('dragstart', dragStart);
//     div.addEventListener('dragover', dragOver);
//     div.addEventListener('drop', drop);
// }

const imageDivs = document.querySelectorAll(".divs");
imageDivs.forEach((div, index) => {
    divs.push({ "element": div, "order": index }); 

    div.draggable = true;
    div.addEventListener('dragstart', dragStart);
    div.addEventListener('dragover', dragOver);
    div.addEventListener('drop', drop);
})

function dragStart(e) {
    e.dataTransfer.setData('text/plain', e.target.id);
}

function dragOver(e) {
    e.preventDefault();
    e.target.classList.add("drop-target");
    e.target.addEventListener("dragleave", () => {
        e.target.classList.remove("drop-target"); 
    });

}

function drop(e) {
    e.preventDefault();
    const id = e.dataTransfer.getData('text/plain');
    const sourceDiv = document.getElementById(id);
    const targetDiv = e.target;
    const sourceIndex = divs.findIndex(item => item.element === sourceDiv);
    const targetIndex = divs.findIndex(item => item.element === targetDiv);
    const tempOrder = divs[sourceIndex].order;

    if (sourceIndex < targetIndex) {
        for (let i = sourceIndex; i < targetIndex; i++) {
            divs[i].element.style.order--;
            divs[i].order--;
        }
    } else if (sourceIndex > targetIndex) {
        for (let i = sourceIndex; i > targetIndex; i--) {
            divs[i].element.style.order++;
            divs[i].order++;
        }
    }

    divs[sourceIndex].order = divs[targetIndex].order;
    divs[targetIndex].order = tempOrder;
    divs.sort((a, b) => a.order - b.order);
    divs.forEach((item, index) => {
        item.element.style.order = index;
    });

    updateIndex();
    e.target.classList.remove("drop-target"); 
}

// function drop(e) {
//     e.preventDefault();
//     const id = e.dataTransfer.getData('text/plain');
//     const sourceDiv = document.getElementById(id);
//     const targetDiv = e.target;
    
//     if (targetDiv.classList.contains("divs")) {
//         const parent = targetDiv.parentElement;
//         const temp = document.createElement('div');
//         parent.insertBefore(temp, targetDiv);
//         parent.insertBefore(targetDiv, sourceDiv);
//         parent.insertBefore(sourceDiv, temp);
//         parent.removeChild(temp);

//         updateIndex();
//     }

//     e.target.classList.remove("drop-target"); 
// }


// function updateIndex() {
//     const imageDivs = document.querySelectorAll(".divs");
//     imageDivs.forEach((item, index) => {
//         item.innerHTML = index + 1;
//     });
// }

function updateIndex() {
    divs.forEach((item, index) => {
        item.element.innerHTML = index + 1;
    });
}