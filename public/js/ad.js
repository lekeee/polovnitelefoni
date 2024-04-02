function openMessages(x) {
    const ownerId = x.getAttribute('ownerid');
    const myId = x.getAttribute('myid');
    if (ownerId != myId) {
        window.location.href = "../views/messages.php?id=" + ownerId;
    }
}
const accessIdent = document.querySelector("#access-ident");
const damagedIdent = document.querySelector('#damaged-ident');

const accessContainer = document.querySelector('.access-container');
const damagedContainer = document.querySelector('.damaged-container');

function showAccess(x) {
    if (!x.classList.contains('active')) {
        damagedIdent.classList.remove('active');
        x.classList.add('active');
        damagedContainer.style.display = 'none';
        accessContainer.style.display = 'block';
    }
}


function showDamaged(x) {
    if (!x.classList.contains('active')) {
        accessIdent.classList.remove('active');
        x.classList.add('active');
        accessContainer.style.display = 'none';
        damagedContainer.style.display = 'block';
    }
}

function getIdfromUrl(){
    let url = window.location.href;
    let queryString = url.split('?')[1];
    let queryParams = new URLSearchParams(queryString);

    return queryParams.get('ad_id');
}

document.addEventListener("DOMContentLoaded", async () => {    
    let visitedArray = JSON.parse(localStorage.getItem("visitedAds"));
    const ad_id = getIdfromUrl();

    if(ad_id != null){
        if(visitedArray === null || !visitedArray.includes(ad_id)){
            if(visitedArray === null)
                visitedArray = [];
            visitedArray.push(ad_id);
            localStorage.setItem("visitedAds", JSON.stringify(visitedArray));

            await fetch("../app/controllers/adController.php",{
                method: "POST",
                body: JSON.stringify({
                    action: "addView",
                    adId : ad_id
                }),
                headers: {
                    "Content-Type" : "application/json"
                }
            }).then(response => response.json());
        }
    }  
});
