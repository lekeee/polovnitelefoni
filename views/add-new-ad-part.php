<link href="../public/css/add-new-ad.css?v=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<link href="../public/css/slider.css?v=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<link href="../public/css/imageupload.css?v=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<link href="../public/css/text-editor.css?v=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
    integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<div class="div-block-742">
    <div class="form-block-6 w-form">
        <form id="email-form" name="email-form" data-name="Email Form" method="get" class="form-6"
            data-wf-page-id="655506e07faa7f82a5f25613" data-wf-element-id="66f219ec-b42b-2054-bf3c-dd81f39f2bfb"
            action="return false" style="padding-top: 40px;">
            <div class="div-block-743" id="error" style="display: none;">
                <div class="div-block-744">
                    <div id="errorText">Došlo je do greške prilikom postavljanja oglasa. Molimo pokušajte kasnije</div>
                </div>
            </div>
            <div class="div-block-745">
                <div class="div-block-746">
                    <h5 class="heading-14">Naslov oglasa</h5>
                    <div class="text-block-65">Naslov oglasa treba da opisuje samo jedan uređaj</div>
                </div>
                <div class="div-block-747">
                    <input type="text" class="text-field-5 w-input" maxlength="256" name="Title" data-name="Title"
                        placeholder="npr. Prodajem..." id="Title" maxlength="60" />
                    <div class="div-block-748">
                        <div id="titleCounter">0</div>
                        <div>/</div>
                        <div>60</div>
                    </div>
                </div>
            </div>
            <div class="div-block-745">
                <div class="div-block-746">
                    <h5 class="heading-14">Brend i Model</h5>
                    <div class="text-block-65">Izaberite Brend i Model uređaja koji prodajete</div>
                </div>
                <div class="div-block-747 twoinrow">
                    <select id="brandSelect" name="Brand select" data-name="Brand" class="select-field w-select">
                        <option value="">Izaberite brend</option>
                        <?php
                        include_once ("../inc/brendovi.php");
                        ?>
                    </select>
                    <select id="modelSelect" name="Model select" data-name="Model" class="select-field w-select">
                        <option value="">Izaberite model</option>
                    </select>
                </div>
            </div>
            <div class="div-block-745 nobottomborder" id="deviceState" style="padding-bottom: 15px">
                <div class="div-block-746">
                    <h5 class="heading-14">Stanje uređaja</h5>
                    <div class="text-block-65">U kom stanju je uređaj koji prodajete?</div>
                </div>
                <div class="div-block-747 twoinrow">
                    <label id="newState" data-w-id="bc18a5ea-5841-bf10-8f85-d037b0bf372d"
                        class="radio-button-field w-radio">
                        <input type="radio" id="newState" name="deviceState" value="newState" data-name="newState"
                            class="w-form-formradioinput radio-button w-radio-input" onclick="checkUserState()"
                            checked />
                        <span class="radio-button-label w-form-label" for="newState-2">Nov
                            uređaj</span>
                    </label>
                    <label id="oldState" data-w-id="3725dcd0-e3f5-4a0f-e904-a5b904091c7d"
                        class="radio-button-field w-radio">
                        <input type="radio" id="oldState" name="deviceState" value="oldState" data-name="oldState"
                            class="w-form-formradioinput radio-button w-radio-input" onclick="checkUserState()" />
                        <span class="radio-button-label w-form-label" for="oldState-2">Polovan
                            uređaj</span>
                    </label>
                </div>
            </div>
            <div class="div-block-745" id="deviceStateRate">
                <div class="div-block-746">
                    <h5 class="heading-14">Ocenite stanje vašeg uređaja</h5>
                    <div class="text-block-65">Ocenom sa 0 do 10 ocenite trenutno stanje uređaja koji prodajete
                    </div>
                </div>
                <div class="div-block-747 slider-container">
                    <input type="range" min="0" max="10" step="0.1" value="0" id="myRange" oninput="updateValue()">
                    <div
                        style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; width: 100%">
                        <p style="display: inline-block;">0</p>
                        <p style="display: inline-block;">10</p>

                    </div>

                    <div id="selected-value" style="font-weight: bold">Stanje uređaja: 0 / 10</div>
                </div>
            </div>
            <div class="div-block-745 imagesinputecontainer">
                <div class="div-block-746 imageinputheader" style="margin-bottom: 15px">
                    <h5 class="heading-14">Slike</h5>
                    <div class="text-block-65">Izaberite najmanje 2 slika koje najbolje reprezentuju uređaj koji
                        prodajete</div>
                </div>
                <div class="image-upload-container">
                    <input type="file" id="fileInput" multiple hidden>
                    <label for="fileInput" id="dropArea" class="inputtext">
                        <div class="upload-icon">
                            <img src="../public/src/upload-icon.png" alt="Upload Icon">
                            <div>
                                <p>Prevucite i pustite da bi ste otpremili slike</p>
                                <p>Ili pretražite <span style="color: #ed6969; font-weight: bold">Pretraži</span></p>
                            </div>
                        </div>
                    </label>
                    <div class="sortable" id="imagePreviewContainer">

                    </div>
                </div>
            </div>
            <div class="div-block-745">
                <div class="div-block-746">
                    <h5 class="heading-14">Dodatna oprema</h5>
                    <div class="text-block-65">Navedite dodatnu opremu koja dolazi uz ređaj</div>
                </div>
                <div class="div-block-747">
                    <div class="div-block-751" id="selectedAccessories">
                    </div>
                    <div class="div-block-753" id="accessoriesList">
                    </div>
                </div>
            </div>
            <div class="div-block-745">
                <div class="div-block-746">
                    <h5 class="heading-14">Oštećenja</h5>
                    <div class="text-block-65">Navedite oštećenja ukoliko ih korisnik ima</div>
                </div>
                <div class="div-block-747">
                    <div class="div-block-751" id="selectedDamages">
                    </div>
                    <div class="div-block-753" id="damagesList">
                    </div>
                </div>
            </div>
            <div class="div-block-745">
                <div class="div-block-746">
                    <h5 class="heading-14">Opis oglasa</h5>
                    <div class="text-block-65">Kratko i jasno predstavite karakteristike uređaja kako biste
                        privukli pažnju na vašem oglasu.</div>
                </div>
                <div class="div-block-747">
                    <div id="editor-container">
                        <button type="button" class="command-btn" onclick="toggleCommand('bold')"><i
                                class="fas fa-bold"></i></button>
                        <button type="button" class="command-btn" onclick="toggleCommand('italic')"><i
                                class="fas fa-italic"></i></button>
                        <button type="button" class="command-btn" onclick="toggleCommand('underline')"><i
                                class="fas fa-underline"></i></button>
                        <span class="separator"></span>
                        <button type="button" class="command-btn" id="align-btn"
                            onclick="toggleCommand('justifyleft')"><i class="fas fa-align-left"></i></button>
                        <button type="button" class="command-btn" id="align-btn"
                            onclick="toggleCommand('justifycenter')"><i class="fas fa-align-center"></i></button>
                        <button type="button" class="command-btn" id="align-btn"
                            onclick="toggleCommand('justifyright')"><i class="fas fa-align-right"></i></button>
                        <span class="separator"></span>
                        <button type="button" class="command-btn" onclick="toggleList('insertorderedlist')"><i
                                class="fas fa-list-ol"></i></button>
                        <button type="button" class="command-btn" onclick="toggleList('insertunorderedlist')"><i
                                class="fas fa-list-ul"></i></button>
                        <span class="separator"></span>
                        <button type="button" class="command-btn" id="backspace-btn"><i
                                class="fas fa-backspace"></i></button>
                    </div>

                    <div class="main-div">
                        <div id="editor" contenteditable="true" oninput="updateCharacterCount(0)"
                            onkeydown="onKeyDown(event)" maxlength="2000"></div>
                        <div id="character-count">
                            <p style="margin: 0;">0 / 2000</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="div-block-745">
                <div class="div-block-746">
                    <h5 class="heading-14">Cena</h5>
                    <div class="text-block-65">postavite cenu oglasa</div>
                </div>
                <div class="div-block-747 twoinrow">
                    <div class="div-block-755">
                        <input type="number" class="text-field-6 w-input" maxlength="256" name="price" data-name="price"
                            placeholder="" id="price" />
                        <div class="div-block-756">
                            <div class="text-block-76"><strong>€</strong></div>
                        </div>
                    </div><label class="w-checkbox checkbox-field-3" id="dealBackground" style="cursor: pointer">
                        <input type="checkbox" id="deal" name="deal" data-name="deal"
                            class="w-checkbox-input checkbox-2" onclick="dealOrPrice()" />
                        <span class="checkbox-label-4 w-form-label" for="deal">Dogovor / Kontakt</span></label>
                </div>
            </div>
            <div class="div-block-757"><label class="w-checkbox terms">
                    <input type="checkbox" id="term1" name="term" data-name="term1" class="termscheck"
                        style="appearance: none; -webkit-appearance: none; -moz-appearance: none;" />
                    <span class="checkbox-label-3 w-form-label" for="term1">Garantujem za tačnost unetih
                        podataka
                    </span>
                </label>
                <label class="w-checkbox terms">
                    <input type="checkbox" id="term2" name="term" data-name="term2" class="termscheck" />
                    <span class="checkbox-label-2 w-form-label" for="term2">Prihvatam plavila i uslove za
                        postavljanje oglasa
                    </span>
                </label>
            </div>
            <div class="div-block-758" style="margin-bottom: 20px;">
                <input type="button" value="Postavi oglas" data-value="Postavi oglas"
                    data-wait="../public/src/loading.gif" class="submit-button-6 w-button" id="saveData" />
            </div>
        </form>
    </div>
</div>
</div>
<script src="../public/js/add-new-ad.js?v=<?php echo time() ?>" type="text/javascript"></script>

<script src="../public/js-public/jquery.js?v=<?php echo time() ?>"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="../public/js/add-images.js?v=<?php echo time() ?>" type="text/javascript"></script>
<script src="../public/js/text-editor.js?v=<?php echo time() ?>" type="text/javascript"></script>
<script src="../public/js/animations.js?v=<?php echo time() ?>" type="text/javascript"></script>
<script src="../public/js/select-model.js?v=<?php echo time() ?>" type="text/javascript"></script>