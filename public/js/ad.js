function openMessages(x) {
    const ownerId = x.getAttribute('ownerid');
    const myId = x.getAttribute('myid');
    if (ownerId != myId) {
        window.location.href = "../views/messages.php?id=" + ownerId;
    }
}