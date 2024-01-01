const brandSelect = document.querySelector('#brandSelect');
const modelSelect = document.querySelector('#modelSelect');
brandSelect.addEventListener("change", function(){
    console.log(this.value);
    fetch('../inc/models.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            brandName: this.value
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
        console.log(data);
        if(data.status === 'success'){
            modelSelect.innerHTML = data.message;
        }
    })
    .catch(error => {
        console.log('Greska:', error);
    });
});