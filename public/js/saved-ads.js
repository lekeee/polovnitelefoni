function savedAdsOnLoad() {
    getSavedAds(0);
}

async function getSavedAds(page) {
    await fetch('../app/controllers/savedAdsController.php', {
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
                hideNoAds();
                document.querySelector("#saved-body").innerHTML = data.message;
            } else {
                showNoAds();
            }
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}

function hideNoAds() {
    document.querySelectorAll('.no-saved-ads')[0].style.display = "none";
    document.querySelectorAll('.saved-ads')[0].style.display = "block";
}

function showNoAds() {
    document.querySelectorAll('.saved-ads')[0].style.display = "none";
    document.querySelectorAll('.no-saved-ads')[0].style.display = "block";
}

async function removeFromMySave(userID, adID) {
    await removeFromFavourite(null, userID, adID);
    const el = document.getElementById(`row_${adID}`);
    el.style.display = 'none';
    const adscont = document.querySelector('#saved-body');
    adscont.removeChild(el);
    if (adscont.children.length == 0) {
        showNoAds();
    }
}