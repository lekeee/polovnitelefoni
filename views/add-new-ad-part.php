    <link href="../public/css/add-new-ad.css?v=<?php echo time()?>" rel="stylesheet" type="text/css" />
    <link href="../public/css/slider.css?v=<?php echo time()?>" rel="stylesheet" type="text/css" />
    <div class="div-block-742">
        <div class="form-block-6 w-form">
            <form id="email-form" name="email-form" data-name="Email Form" method="get" class="form-6"
                data-wf-page-id="655506e07faa7f82a5f25613" data-wf-element-id="66f219ec-b42b-2054-bf3c-dd81f39f2bfb">
                <div class="div-block-743">
                    <div class="div-block-744">
                        <div>Došlo je do greške prilikom postavljanja oglasa. Molimo pokušajte kasnije</div>
                    </div>
                </div>
                <div class="div-block-745">
                    <div class="div-block-746">
                        <h5 class="heading-14">Naslov oglasa</h5>
                        <div class="text-block-65">Naslov oglasa treba da opisuje samo jedan uređaj</div>
                    </div>
                    <div class="div-block-747"><input type="text" class="text-field-5 w-input" maxlength="256"
                            name="Title" data-name="Title" placeholder="npr. Prodajem..." id="Title" maxlength="60"
                            required />
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
                    <div class="div-block-747 twoinrow"><select id="Brand" name="Brand" data-name="Brand" required=""
                            class="select-field w-select">
                            <option value="">Select one...</option>
                            <option value="First">First choice</option>
                            <option value="Second">Second choice</option>
                            <option value="Third">Third choice</option>
                        </select><select id="Model" name="Model" data-name="Model" required=""
                            class="select-field w-select">
                            <option value="">Select one...</option>
                            <option value="First">First choice</option>
                            <option value="Second">Second choice</option>
                            <option value="Third">Third choice</option>
                        </select></div>
                </div>
                <div class="div-block-745 nobottomborder">
                    <div class="div-block-746">
                        <h5 class="heading-14">Stanje uređaja</h5>
                        <div class="text-block-65">U kom stanju je uređaj koji prodajete?</div>
                    </div>
                    <div class="div-block-747 twoinrow"><label id="newState"
                            data-w-id="bc18a5ea-5841-bf10-8f85-d037b0bf372d" class="radio-button-field w-radio"><input
                                type="radio" id="newState-2" name="newState" value="newState" data-name="newState"
                                class="w-form-formradioinput radio-button w-radio-input" /><span
                                class="radio-button-label w-form-label" for="newState-2">Nov
                                uređaj</span></label><label id="oldState"
                            data-w-id="3725dcd0-e3f5-4a0f-e904-a5b904091c7d" class="radio-button-field w-radio"><input
                                type="radio" id="oldState-2" name="oldState" value="oldState" data-name="oldState"
                                class="w-form-formradioinput radio-button w-radio-input" /><span
                                class="radio-button-label w-form-label" for="oldState-2">Polovan
                                uređaj</span></label></div>
                </div>
                <div class="div-block-745">
                    <div class="div-block-746">
                        <h5 class="heading-14">Ocenite stanje vašeg uređaja</h5>
                        <div class="text-block-65">Ocenom sa 0 do 10 ocenite trenutno stanje uređaja koji prodajete
                        </div>
                    </div>
                    <div class="div-block-747 slider-container">
                        <input type="range" min="0" max="10" step="0.1" value="0" id="myRange" oninput="updateValue()">
                        <div style="display: flex; flex-direction: row; align-item: center; justify-content: space-between; width: 100%">
                            <p style="display: inline-block;">0</p>
                            <p style="display: inline-block;">10</p>
                            
                        </div>

                        <div id="selected-value" style="font-weight: bold">Stanje uređaja: 0 / 10</div>
                    </div>
                </div>
                <div class="div-block-745 imagesinputecontainer">
                    <div class="div-block-746 imageinputheader">
                        <h5 class="heading-14">Slike</h5>
                        <div class="text-block-65">Izaberite najmanje 2 slika koje najbolje reprezentuju uređaj koji
                            prodajete</div>
                    </div>
                    <div class="div-block-747 imageinputmain">
                        <div class="div-block-749">
                            <div data-w-id="28e8d1af-9f31-55b7-d4d1-0558c37a7d3e" class="div-block-750"></div>
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
                        <div class="div-block-751">
                            <div class="div-block-752 ostecenja">
                                <div class="text-block-66">Oštećen ekran</div>
                            </div>
                            <div class="div-block-752 ostecenja">
                                <div class="text-block-66">Oštećeno kućište</div>
                            </div>
                        </div>
                        <div class="div-block-753">
                            <div class="div-block-754">
                                <div class="text-block-67">Problem s baterijom</div>
                            </div>
                            <div class="div-block-754">
                                <div class="text-block-68">Zamrzavanje ili rušenje sistema</div>
                            </div>
                            <div class="div-block-754">
                                <div class="text-block-69">Wifi/Bluetooth ne rai</div>
                            </div>
                            <div class="div-block-754">
                                <div class="text-block-70">Kontakt s tečnostima</div>
                            </div>
                            <div class="div-block-754">
                                <div class="text-block-71">Neispravna kamera</div>
                            </div>
                            <div class="div-block-754">
                                <div class="text-block-72">Neispravan zvučnik/mikrofon</div>
                            </div>
                            <div class="div-block-754">
                                <div class="text-block-73">Problem s osvetljenjem</div>
                            </div>
                            <div class="div-block-754">
                                <div class="text-block-74">Problem sa portom za punjenje</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="div-block-745">
                    <div class="div-block-746">
                        <h5 class="heading-14">Opis oglasa</h5>
                        <div class="text-block-65">Kratko i jasno predstavite karakteristike uređaja kako biste
                            privukli pažnju na vašem oglasu.</div>
                    </div>
                    <div class="div-block-747"><textarea required="" placeholder="Opis" maxlength="5000"
                            id="Description" name="Description" data-name="Description"
                            class="textarea w-input"></textarea>
                        <div class="div-block-748">
                            <div>0</div>
                            <div>/</div>
                            <div>2000</div>
                        </div>
                    </div>
                </div>
                <div class="div-block-745">
                    <div class="div-block-746">
                        <h5 class="heading-14">Cena</h5>
                        <div class="text-block-65">postavite cenu oglasa</div>
                    </div>
                    <div class="div-block-747 twoinrow">
                        <div class="div-block-755"><input type="text" class="text-field-6 w-input" maxlength="256"
                                name="price" data-name="price" placeholder="" id="price" required="" />
                            <div class="div-block-756">
                                <div class="text-block-76"><strong>€</strong></div>
                            </div>
                        </div><label class="w-checkbox checkbox-field-3"><input type="checkbox" id="deal" name="deal"
                                data-name="deal" class="w-checkbox-input checkbox-2" /><span
                                class="checkbox-label-4 w-form-label" for="deal">Dogovor / Kontakt</span></label>
                    </div>
                </div>
                <div class="div-block-757"><label class="w-checkbox terms"><input type="checkbox" id="term1"
                            name="term1" data-name="term1" required="" class="w-checkbox-input termscheck" /><span
                            class="checkbox-label-3 w-form-label" for="term1">Garantujem za tačnost unetih
                            podataka</span></label><label class="w-checkbox terms"><input type="checkbox" id="term2"
                            name="term2" data-name="term2" required="" class="w-checkbox-input" /><span
                            class="checkbox-label-2 w-form-label" for="term2">Prihvatam plavila i uslove za
                            postavljanje oglasa</span></label></div>
                <div class="div-block-758"><input type="submit" value="Postavi oglas" data-wait="Please wait..."
                        class="submit-button-6 w-button" /></div>
            </form>
            <div class="w-form-done"></div>
            <div class="w-form-fail"></div>
        </div>
    </div>
    </div>
    <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=655506e07faa7f82a5f25610"
        type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script src="../public/js/add-new-ad-script.js" type="text/javascript"></script>
    <script src="../public/js/add-new-ad.js" type="text/javascript"></script>