function savedAdsOnLoad() {
    getSavedAds(0);
}

function getSavedAds(page) {
    fetch('../app/controllers/savedAdsController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'getSavedAds',
            page: page,
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
                document.querySelectorAll('.no-saved-ads')[0].style.display = "none";
                document.querySelectorAll('.saved-ads')[0].style.display = "block";
                document.querySelector("#saved-body").innerHTML = data.message;
                console.log(data.message);
            } else if (data.status === 'empty') {

            } else {

            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}