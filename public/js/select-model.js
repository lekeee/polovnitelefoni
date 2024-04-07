const brandSelect = document.querySelector('#brandSelect');
const modelSelect = document.querySelector('#modelSelect');

const modelSelect2 = document.querySelector('.modelSelect');
window.addEventListener('load', async function () {
    await getModel(brandSelect.value);
    const model = modelSelect.getAttribute('model-to-select');
    console.log(model);
    modelSelect.value = model;
});


brandSelect.addEventListener("change", function () {
    getModel(this.value);
});

async function getModel(value) {
    await fetch('../inc/models.php', {
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
                modelSelect.innerHTML = '';
                modelSelect.innerHTML += data.message;
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}