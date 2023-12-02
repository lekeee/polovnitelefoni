function startLoadingAnimation(buttonID){
    var submitButton = document.querySelector(`#${buttonID}`);
    const originalValue = submitButton.value;
    const waitImage = new Image();
    waitImage.src = submitButton.getAttribute('data-wait');

    submitButton.value = '';

    submitButton.style.backgroundImage = `url('${waitImage.src}')`;
    submitButton.style.backgroundSize = '20%';
    submitButton.style.backgroundRepeat = 'no-repeat';
    submitButton.style.backgroundPosition = 'center';
    submitButton.disabled = true;
}

function stopLoadingAnimation(buttonID){
    var submitButton = document.querySelector(`#${buttonID}`);
    submitButton.value = submitButton.getAttribute('data-value');
    submitButton.style.backgroundImage = 'none';
    submitButton.disabled = false;
}