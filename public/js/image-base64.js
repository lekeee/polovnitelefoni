function getBase64(imageUrl) {
    fetch(imageUrl)
        .then(response => response.blob())
        .then(blob => {
            const reader = new FileReader();
            reader.onloadend = function () {
                const base64data = reader.result.split(',')[1];
                const base64ImageUrl = `data:image/png;base64,${base64data}`;

                const previewContainer = document.querySelector('#imagePreviewContainer');
                const li1 = document.createElement('li');
                li1.classList.add('image-preview', 'uploadedImage');

                const img1 = document.createElement('img');
                img1.src = base64ImageUrl;

                const div1 = document.createElement('div');
                div1.classList.add('delete-icon');
                div1.innerHTML = 'X';
                div1.addEventListener('click', function () {
                    previewContainer.removeChild(li1);
                });

                li1.appendChild(img1);
                li1.appendChild(div1);

                previewContainer.appendChild(li1);

            };
            reader.readAsDataURL(blob);
        })
        .catch(error => {
            console.error('Greška pri preuzimanju slike:', error);
            return null;
        });
}