const MAX_IMAGES = 10;
let images = [];
let counter = 0;

$(function () {
    $(".sortable").sortable({
        update: function (event, ui) {
            getIdsOfImages();
        },
        tolerance: "pointer",
        cursor: "move",
    });
});

document.querySelector('#fileInput').addEventListener('change', handleFileSelect);

function handleFileSelect(event) {
    let numberOfUploadedImages = document.querySelectorAll(".listitemClass").length;
    const files = event.target?.files || event;

    if (!files) {
        console.error('Nisu pronađene datoteke.');
        return;
    }

    if (numberOfUploadedImages + files.length > MAX_IMAGES) {
        alert("Maksimalan broj slika koje možete otpremiti po oglasu je 10");
        return;
    }
    let counter = 0;
    let counter2 = numberOfUploadedImages;
    const previewContainer = document.querySelector('#imagePreviewContainer');
    for (const file of files) {
        const reader = new FileReader();

        reader.onloadend = function () {
            const imageDiv = document.createElement('div');
            imageDiv.id = `imageNo${counter++}`;
            imageDiv.setAttribute('index', ++counter2);
            // imageDiv.classList.add('image-preview');
            // imageDiv.classList.add('uploadedImage');
            imageDiv.classList.add('listitemClass');
            imageDiv.style.backgroundImage = `url('${reader.result}')`;

            $(imageDiv).click(function () {
                if (psuedoClick(this).after) {
                    this.style.display = 'none';
                    previewContainer.removeChild(this);
                    getIdsOfImages()
                }
            })


            // imageDiv.appendChild(insideDiv);
            previewContainer.appendChild(imageDiv);
        };

        reader.readAsDataURL(file);
    }
}
function psuedoClick(parentElem) {

    var beforeClicked,
        afterClicked;

    var parentLeft = parseInt(parentElem.getBoundingClientRect().left, 10),
        parentTop = parseInt(parentElem.getBoundingClientRect().top, 10);

    var parentWidth = parseInt(window.getComputedStyle(parentElem).width, 10),
        parentHeight = parseInt(window.getComputedStyle(parentElem).height, 10);

    var before = window.getComputedStyle(parentElem, ':before');

    var beforeStart = parentLeft + (parseInt(before.getPropertyValue("left"), 10)),
        beforeEnd = beforeStart + parseInt(before.width, 10);

    var beforeYStart = parentTop + (parseInt(before.getPropertyValue("top"), 10)),
        beforeYEnd = beforeYStart + parseInt(before.height, 10);

    var after = window.getComputedStyle(parentElem, ':after');

    var afterStart = parentLeft + (parseInt(after.getPropertyValue("left"), 10)),
        afterEnd = afterStart + parseInt(after.width, 10);

    var afterYStart = parentTop + (parseInt(after.getPropertyValue("top"), 10)),
        afterYEnd = afterYStart + parseInt(after.height, 10);

    var mouseX = event.clientX,
        mouseY = event.clientY;

    beforeClicked = (mouseX >= beforeStart && mouseX <= beforeEnd && mouseY >= beforeYStart && mouseY <= beforeYEnd ? true : false);

    afterClicked = (mouseX >= afterStart && mouseX <= afterEnd && mouseY >= afterYStart && mouseY <= afterYEnd ? true : false);

    return {
        "before": beforeClicked,
        "after": afterClicked

    };

}

function getIdsOfImages() {
    let counter = 0;
    document.querySelectorAll('.listitemClass').forEach(element => {

        console.log(counter);
        element.setAttribute('index', ++counter);
    })
    // var values = [];
    // $('.listitemClass').each(function (index) {
    //     values.push($(this).attr("id").replace("imageNo", ""));
    // });
    // $('#outputvalues').val(values);
}