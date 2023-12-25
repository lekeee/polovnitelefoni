document.addEventListener('DOMContentLoaded', function () {
    let dropDownOpened = [];

    const brandCheckboxes = document.getElementsByClassName('custom-brand-checkbox');
    const brandDropdowns = document.getElementsByClassName('custom-dropdown');
    const dropDownTogglers = document.getElementsByClassName('openDropDown');

    for(let i = 0; i < brandDropdowns.length; i++){
        const dropDownCheckboxes = brandDropdowns[i].querySelectorAll('input[type="checkbox"]');
        for(let j = 0; j < dropDownCheckboxes.length; j++){
            dropDownCheckboxes[j].addEventListener('change', checkIsAllModelsChecked);
        }
    }

    for (let i = 0; i < dropDownTogglers.length; i++) {
        const dropDownToggler = dropDownTogglers[i];
        dropDownToggler.addEventListener('click', createToggleHandler(i));
    }

    for (let i = 0; i < brandCheckboxes.length; i++) {
        const brandCheckbox = brandCheckboxes[i];
        brandCheckbox.addEventListener('change', createCheckerHandler(i));
    }



    function checkIsAllModelsChecked(){
        for(let i = 0; i < brandCheckboxes.length; i++){
            const dropdownElements = brandDropdowns[i].querySelectorAll('input[type="checkbox"]');
            
            let counter = 0;
            for(let j = 0; j < dropdownElements.length; j++){
                if(dropdownElements[j].checked) counter++;
            }
            brandCheckboxes[i].checked = counter > 0;
        }
    }

    function createCheckerHandler(index) {
        return function () {
            checkAllChildren(index)
        }
    }

    function checkAllChildren(index) {
        const brandDropdown = brandDropdowns[index];
        const elements = brandDropdown.querySelectorAll('input[type="checkbox"]');

        if (brandCheckboxes[index].checked) {
            for (let i = 0; i < elements.length; i++) {
                elements[i].checked = true;
            }
        }else{
            for (let i = 0; i < elements.length; i++) {
                elements[i].checked = false;
            }
        }
    }

    function createToggleHandler(index) {
        return function () {
            checkForExpand(index);
        };
    }

    function checkForExpand(i) {
        if (dropDownOpened[i] !== 1) {
            expandDropdown(brandDropdowns[i]);
            dropDownOpened[i] = 1;
            dropDownTogglers[i].innerHTML = "-";
        } else {
            collapseDropdown(brandDropdowns[i]);
            dropDownOpened[i] = 0;
            dropDownTogglers[i].innerHTML = "+";
        }
    }

    function expandDropdown(element) {
        const height = element.scrollHeight;
        element.style.maxHeight = height + "px";
        element.classList.add('visible');
    }

    function collapseDropdown(element) {
        element.style.maxHeight = 0;
        element.classList.remove('visible');
    }



    document.querySelectorAll('.filtericoncontainer')[0].addEventListener('click', function(){
        document.querySelectorAll('.darkbackground')[0].style.display = 'block';
        document.querySelectorAll('.filterleftmaincontainer')[0].classList.remove('deactive');
        document.querySelectorAll('.filterleftmaincontainer')[0].classList.add('active');
    });
    document.querySelectorAll('.closeicon')[0].addEventListener('click', function(){
        document.querySelectorAll('.filterleftmaincontainer')[0].classList.remove('active');
        document.querySelectorAll('.filterleftmaincontainer')[0].classList.add('deactive');
        setTimeout(() => {
            document.querySelectorAll('.darkbackground')[0].style.display = 'none';
        }, 300);
    });
});
