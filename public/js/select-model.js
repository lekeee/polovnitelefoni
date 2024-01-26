const brandSelect = document.querySelector('#brandSelect');
const modelSelect = document.querySelector('#modelSelect');

const modelSelect2 = document.querySelector('.modelSelect');
window.addEventListener('load', function () {
    getModel(brandSelect.value);
});


brandSelect.addEventListener("change", function () {
    getModel(this.value);
});

function getModel(value) {
    fetch('../inc/models.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            brandName: value
        })
    })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Doslo je do greske prilikom prihvatanja zahteva.');
            }
        })
        .then(data => {
            if (data.status === 'success') {
                modelSelect.innerHTML += data.message;
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}