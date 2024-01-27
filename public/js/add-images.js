const MAX_IMAGES = 10;

document.getElementById('fileInput').addEventListener('change', handleFileSelect);

function handleFileSelect(event) {
    const numberOfUploadedImages = document.getElementsByClassName("uploadedImage").length;
    const files = event.target?.files || event;

    if (!files) {
        console.error('Nisu pronađene datoteke.');
        return;
    }

    if (numberOfUploadedImages + files.length > MAX_IMAGES) {
        alert("Maksimalan broj slika koje možete otpremiti po oglasu je 10");
        return;
    }

    const previewContainer = document.getElementById('imagePreviewContainer');
    for (const file of files) {
        const reader = new FileReader();

        reader.onloadend = function () {
            const image = document.createElement('li');
            image.classList.add('image-preview');
            image.classList.add('uploadedImage');

            const imgElement = document.createElement('img');
            imgElement.src = reader.result;


            const deleteIcon = document.createElement('div');
            deleteIcon.classList.add('delete-icon');
            deleteIcon.innerHTML = 'X';

            deleteIcon.addEventListener('click', function () {
                previewContainer.removeChild(image);
            });

            image.appendChild(imgElement);
            image.appendChild(deleteIcon);

            previewContainer.appendChild(image);
        };

        reader.readAsDataURL(file);
    }
}
$(function () {
    $("#imagePreviewContainer").sortable({
        revert: false,
        containment: 'parent',
        tolerance: 'pointer',
        cursor: 'grabbing',
        helper: 'clone'
    }).disableSelection();

    const dropArea = document.getElementById('dropArea');

    dropArea.addEventListener('dragover', function (event) {
        event.preventDefault();
        dropArea.classList.add('dragover');
        this.style.borderRadius = "5px";
        this.style.backgroundColor = "#ddd";
    });

    dropArea.addEventListener('dragleave', function (event) {
        event.preventDefault();
        dropArea.classList.remove('dragover');
        this.style.backgroundColor = "white";
    });

    dropArea.addEventListener('drop', function (event) {
        event.preventDefault();
        dropArea.classList.remove('dragover');
        this.style.backgroundColor = "white";

        const files = event.dataTransfer.files;
        handleFileSelect(files);
    });
});