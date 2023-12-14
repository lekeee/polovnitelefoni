<?php
    require_once "../app/auth/userAuthentification.php";
?>
<section class="header">
        <div class="w-layout-blockcontainer container firstnavbar w-container">
            <div class="w-layout-blockcontainer container-2 w-container"><a href="#" class="link-block w-inline-block">
                    <div class="firstnavbartext">O nama</div>
                </a><a href="#" class="link-block w-inline-block">
                    <div class="text-block firstnavbartext">Mon nalog</div>
                </a><a href="#" class="link-block w-inline-block">
                    <div class="text-block-2 firstnavbartext">Izdvojeni proizvodi</div>
                </a><a href="#" class="link-block w-inline-block">
                    <div class="text-block-3 firstnavbartext">Lista želja</div>
                </a></div>
            <div class="w-layout-blockcontainer container-3 w-container"><a href="#" class="link-block w-inline-block">
                    <div class="text-block-4">Prati pošiljku</div>
                </a>
                <div data-hover="false" data-delay="0" class="dropdown w-dropdown">
                    <div class="dropdown-toggle seconddropdown w-dropdown-toggle">
                        <div class="text-block-5">Srpski</div><img
                            src="../public/src/arrow_down.png"
                            loading="lazy" width="14" height="14" alt="Arrow Down Icon" />
                    </div>
                    <nav class="dropdown-list w-dropdown-list"><a href="#"
                            class="dropdown-link w-dropdown-link">English</a></nav>
                </div>
                <div data-hover="false" data-delay="0" class="dropdown seconddropdown w-dropdown">
                    <div class="dropdown-toggle seconddropdown w-dropdown-toggle">
                        <div class="text-block-5">EUR</div><img
                            src="../public/src/arrow_down.png"
                            loading="lazy" width="14" height="14" alt="Arrow Down Icon" />
                    </div>
                    <nav class="dropdown-list w-dropdown-list"><a href="#" class="dropdown-link w-dropdown-link">RSD</a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="div-block"><a data-w-id="dececed3-f170-003e-2db2-631e28dd94b9" href="#" class="w-inline-block"><img
                    src="../public/src/hamburger_menu.png"
                    loading="lazy" width="30" height="30" alt="Hamburger Menu" class="image-6" /></a>
            <div class="div-block-57" style="cursor: pointer;" onclick="window.location.href='index.php'"><img
                    src="../public/src/polovnitelefoni.svg"
                    loading="lazy" height="60" alt="Logo" class="image" /></div>
            <div class="div-block-2">
                <div class="div-block-3">
                    <div data-hover="false" data-delay="0" data-w-id="665941f7-2c5c-e618-c253-3b3a958220df"
                        class="dropdown-4 w-dropdown">
                        <div class="dropdown-toggle-2 w-dropdown-toggle">
                            <div class="text-block-6">Sve</div>
                            <div class="div-block-74">
                                <div class="div-block-73"><img
                                        src="../public/src/arrow_down.png"
                                        loading="lazy" width="14" alt="Arrow Down Icon" /><img
                                        src="../public/src/arrow_up.png"
                                        loading="lazy" width="14" alt="Arrow Above" /></div>
                            </div>
                        </div>
                        <nav class="dropdown-list-3 w-dropdown-list"><a href="#"
                                class="dropdown-link-2 w-dropdown-link">Mobilni Telefoni</a><a href="#"
                                class="dropdown-link-3 w-dropdown-link">Tableti</a><a href="#"
                                class="dropdown-link-4 w-dropdown-link">Pametni Satovi</a></nav>
                    </div>
                </div>
                <div class="div-block-4"><img
                        src="../public/src/search_icon.png"
                        loading="lazy" width="33" height="33" alt="Search Icon" /></div>
                <div class="form-block w-form">
                    <form id="email-form" name="email-form" data-name="Email Form" method="get" class="form"
                        data-wf-page-id="655506e07faa7f82a5f25613"
                        data-wf-element-id="322ffea6-4ecb-344c-4a1e-c7b285d7978c"><input type="text"
                            class="text-field w-input" maxlength="256" name="field" data-name="Field"
                            placeholder="Pretraži svoj omiljeni telefon" id="field" /><input type="submit"
                            value="Pretrazi" data-wait="Please wait..." class="submit-button w-button" /></form>
                    <div class="w-form-done"></div>
                    <div class="w-form-fail"></div>
                </div>
            </div>
            <div class="div-block-5">
                <div class="div-block-6 div-block-7">
                    <div class="div-block-8" onclick="window.location.href='<?php echo $user->isLogged() ? 'dashboard.php' : 'login.php' ?>'"><img
                            src="../public/src/user_icon.png"
                            loading="lazy" height="35" alt="User Icon" width="35" class="image-27" />
                        <div>
                            <div class="text-block-7" style="color: grey"><?php echo $user !== NULL && $user->isLogged() ? "Dobrodošli" : "Prijavi se na"?></div>
                            <div class="text-block-8">
                                <?php 
                                //echo $user !== NULL && $user->isLogged() ? json_decode($user->returnUser(), true)['username']  : "Profil"
                                if($user !== NULL && $user->isLogged()){
                                    if(!empty(json_decode($user->returnUser(), true)['username'])){
                                        echo json_decode($user->returnUser(), true)['username'];
                                    }else{
                                        echo json_decode($user->returnUser(), true)['name'] . ' ' . json_decode($user->returnUser(), true)['lastname'];
                                    }
                                }else{
                                    echo "Profil";
                                }
                                ?> 
                            </div>

                        </div>
                    </div>
                    <div class="div-block-9"><a href="#" class="link-block-3 w-inline-block"><img
                                src="../public/src/add_new_ad_icon.png"
                                loading="lazy" width="20" alt="Add New Ad" class="image-2" />
                            <div class="text-block-9">Dodaj Oglas</div>
                        </a></div>
                    <div class="div-block-10"><img
                            src="../public/src/favourite_icon.png"
                            loading="lazy" width="35" alt="Favourite Ads Icon" class="image-3" />
                        <div class="div-block-11">
                            <div class="text-block-10">9</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="div-block-12">
            <div class="div-block-14">
                <div data-hover="false" data-delay="0" data-w-id="d9013978-067d-ce1a-92bf-79873730cf28"
                    class="dropdown-5 w-dropdown">
                    <div class="dropdown-toggle-5 w-dropdown-toggle"><img width="30" height="30" alt="Hamburger Menu"
                            src="../public/src/hamburger_menu.png"
                            loading="lazy" />
                        <div class="text-block-12">Sve kategorije</div>
                        <div class="div-block-74">
                            <div class="div-block-73"><img width="14" loading="lazy" alt="Arrow Down Icon"
                                    src="../public/src/arrow_down.png" /><img
                                    width="14" loading="lazy" alt="Arrow Above"
                                    src="../public/src/arrow_up.png" />
                            </div>
                        </div>
                    </div>
                    <nav class="dropdown-list-4 w-dropdown-list">
                        <div data-w-id="3e13d5a3-83c2-7fd2-f814-8edff769ea30" class="div-block-69">
                            <div class="div-block-70"><img width="30" loading="lazy" alt="Mobile Phone Icon"
                                    src="../public/src/mobile_phone_icon.png" />
                                <div class="text-block-39">Mobilni Telefoni</div>
                            </div>
                            <div class="div-block-76">
                                <div class="div-block-75"><img width="16" loading="lazy" alt="Arrow Above"
                                        src="../public/src/arrow_right.png"
                                        class="image-24" /><img width="14" loading="lazy" alt="Arrow Back"
                                        src="../public/src/arrow_left.png"
                                        class="image-26" /></div>
                            </div>
                            <div class="div-block-71">
                                <div class="div-block-72">
                                    <div class="text-block-40">Mobilni Telefoni</div><a href="#"
                                        class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">Apple</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">Samsung</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">Xiaomi</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">Huawei</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">Motorola</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">Nokia</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">Google</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">OnePlus</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">Honor</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">Alcatel</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">Poco</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">Realme</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">Tesla</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">LG</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">Microsoft</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">ZTE</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">Oppo</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">Vivo</div>
                                    </a><a href="#" class="link-block-12 w-inline-block">
                                        <div class="mobilephonebrand">Blackberry</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="div-block-69">
                            <div class="div-block-70"><img width="30" loading="lazy" alt="Headphones Icon"
                                    src="../public/src/headphones_icon.png" />
                                <div class="text-block-39">Slušalice</div>
                            </div><img width="16" loading="lazy" alt="Arrow Forward"
                                src="../public/src/arrow_right.png"
                                class="image-25" />
                        </div>
                        <div class="div-block-69">
                            <div class="div-block-70"><img width="30" loading="lazy" alt="Share Icon"
                                    src="../public/src/other_icon.png" />
                                <div class="text-block-39">Oprema i Delovi</div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="div-block-15"><a href="#" class="link-block-4 w-inline-block">
                    <div class="text-block-13">Početna</div>
                </a><a href="#" class="link-block-4 w-inline-block">
                    <div class="text-block-13">Šop</div>
                </a><a href="#" class="link-block-4 w-inline-block"><img
                        src="../public/src/mobile_phone_icon.png"
                        loading="lazy" width="25" alt="Mobile Phone Icon" />
                    <div class="text-block-13">Mobilni Telefoni</div>
                </a><a href="#" class="link-block-4 w-inline-block"><img
                        src="../public/src/headphones_icon.png"
                        loading="lazy" width="22" height="22" alt="Headphones Icon" class="image-4" />
                    <div class="text-block-13">Mobilni Telefoni</div>
                </a><a href="#" class="link-block-4 w-inline-block">
                    <div class="text-block-13">Blog</div>
                </a><a href="#" class="link-block-4 w-inline-block">
                    <div class="text-block-13">Podrška</div>
                </a></div>
            <div class="div-block-16">
                <div data-hover="false" data-delay="0" class="dropdown-3 w-dropdown">
                    <div class="dropdown-toggle-4 w-dropdown-toggle"><img
                            src="../public/src/onsale_icon.jpg"
                            loading="lazy" width="33" alt="On Sale Icon" class="image-5" />
                        <div class="div-block-17">
                            <div class="text-block-14">Samo ovog vikenda</div>
                            <div class="text-block-15">Super sniženja</div>
                        </div><img width="14" loading="lazy" alt="Arrow Down Icon"
                            src="../public/src/arrow_down.png" />
                    </div>
                    <nav class="w-dropdown-list"><a href="#" class="w-dropdown-link">Link 1</a><a href="#"
                            class="w-dropdown-link">Link 2</a><a href="#" class="w-dropdown-link">Link 3</a></nav>
                </div>
            </div>
        </div>
    </section>
    <div class="div-block-13 lineseparator"></div>
    <div data-w-id="2312cd45-42d1-6acc-59ef-08dd05adea72" class="div-block-55"></div>