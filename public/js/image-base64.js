function getBase64(imageUrl, x) {
    fetch(imageUrl)
        .then(response => response.blob())
        .then(blob => {
            const reader = new FileReader();
            reader.onloadend = function () {
                const base64data = reader.result.split(',')[1];
                const base64ImageUrl = `data:image/png;base64,${base64data}`;
                document.querySelector(`#${x}`).src = base64ImageUrl;
                return base64ImageUrl;
            };
            reader.readAsDataURL(blob);
        })
        .catch(error => {
            console.error('Greška pri preuzimanju slike:', error);
            return null;
        });
}