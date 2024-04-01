function savedAdsOnLoad() {
    getSavedAds(0);
}

async function getSavedAds(page) {
    await fetch('../app/controllers/myAdsController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'getMyAds',
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
                // console.log(data.message);
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

const deleteBackgroundContainer = document.querySelectorAll(".delete-backgound-container")[0];
const deleteMainContainer = document.querySelectorAll('.delete-main-container')[0];

deleteBackgroundContainer.addEventListener("click", function (e) {
    hideDeleteConfirm();
});

deleteMainContainer.addEventListener("click", function (e) {
    e.stopPropagation();
});

function showDeleteConfirm(adID, title) {
    const deleteBtn = document.querySelector("#delete-btn");
    const deleteTitle = document.querySelector('#delete-title');
    deleteBtn.setAttribute('adID', adID);

    deleteTitle.innerHTML = title;

    deleteBackgroundContainer.style.display = "flex";
    deleteMainContainer.classList.remove('close');
    deleteMainContainer.classList.add('active');
}

function hideDeleteConfirm() {
    deleteMainContainer.classList.remove('active');
    deleteMainContainer.classList.add('close');
    setTimeout(() => {
        deleteBackgroundContainer.style.display = "none";
    }, 300);
}

async function deleteAd() {
    const deleteBtn = document.querySelector("#delete-btn");
    const adID = deleteBtn.getAttribute('adID');

    await fetch('../app/controllers/myAdsController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'deleteAd',
            ad_id: adID,
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
                const adscont = document.querySelector('#saved-body');

                const row = document.querySelector(`#row_${adID}`);
                row.style.display = 'none';
                adscont.removeChild(row);

                if (adscont.children.length == 0) {
                    showNoAds();
                }
            } else {
                alert(data.message);
            }
            hideDeleteConfirm();
        })
        .catch(error => {
            console.log('Greska:', error);
        });
}