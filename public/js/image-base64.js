let counterr = 0;
function getBase64(imageUrl) {
    fetch(imageUrl)
        .then(response => response.blob())
        .then(blob => {
            const reader = new FileReader();
            reader.onloadend = function () {
                const previewContainer = document.querySelector('#imagePreviewContainer');

                const imageDiv = document.createElement('div');
                imageDiv.id = `imageNo${++counterr}`;
                imageDiv.setAttribute('index', ++counterr);
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
            reader.readAsDataURL(blob);
        })
        .catch(error => {
            console.error('Greška pri preuzimanju slike:', error);
            return null;
        });
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

        // console.log(counter);
        element.setAttribute('index', ++counter);
    })
    // var values = [];
    // $('.listitemClass').each(function (index) {
    //     values.push($(this).attr("id").replace("imageNo", ""));
    // });
    // $('#outputvalues').val(values);
}