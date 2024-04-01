<link rel="stylesheet" href="../public/css/mobile-search.css?v=<?php echo time() ?>">
<link rel="stylesheet" href="../public/css/style.css?v=<?php echo time() ?>">

<div class="mobile-search-main-container">
    <div class="mobile-search">
        <div class="div-block-2" style="display: flex">
            <input type="text" placeholder="Pretraži..." class="mobileSearch">
            <button class="searchbutton">
                <img src="../public/src/search-icon.svg" loading="lazy" width="22" alt="Search Icon" />
            </button>
        </div>
        <div class="search-identificator">
            <div class="mobile-search-identificator">
                <img src="../public/src/search-identificator.svg" alt="Search Identificator">
                <p class="mobile-search-p">Pretražujte oglase na osnovu njihovog naslova ili unosom ključnih reči</p>
            </div>
            <div class="mobile-search-result"></div>
            <div class="mobile-search-identificator not-found">
                <img src="../public/src/not-found.svg" alt="Search Identificator">
                <p class="mobile-search-p">Nije pronađen nijedan rezultat</p>
            </div>
        </div>
    </div>
</div>
<script src="../public/js/search.js?v=<?php echo time(); ?>"></script>