<div class="widgetcontainer gold loading-animation" style="pointer-events: none; display: none;">
    <div class="mainwidgetcontainer">
        <div class="imageAnimate widgetimagescontainer"
            style="display: flex; flex-direction: row; justify-content: space-between;">

        </div>
        <div class="widget-description-container">
            <div class="animateDiv1"></div>
            <div class="animateDiv2"></div>
            <div style="display: flex; justify-content: space-between">
                <div class="animateDiv3"></div>
                <div class="animateDiv4"></div>
            </div>
            <div class="animateDiv5"></div>
        </div>
    </div>
</div>

<script>
    let nums = parseInt(localStorage.getItem('loadedAdsCounter')) - 1 + 4;
    if (nums < 5) nums = 5;
    for (let i = 0; i < nums; i++) {
        let originalWidget = document.querySelector('.widgetcontainer');
        let clonedWidget = originalWidget.cloneNode(true);

        // Dodavanje kloniranog elementa na stranicu
        document.querySelector('.productsmaincontainer').appendChild(clonedWidget);
    }
</script>