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