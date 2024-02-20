<?php
    $HOME_URL = !strpos($_SERVER['HTTP_HOST'], 'localhost') ? 'http://'.$_SERVER['HTTP_HOST'].'/wordpress' : 'https://'.$_SERVER['HTTP_HOST'];
?>
<html>
    <head>
		<meta charset="UTF-8">
		<meta name="description" content="">
		<meta name="keywords" content="HTML,CSS,XML,JavaScript">
		<meta name="author" content="Enmanuel Lassis">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">        
    </head>
    <body>
    <style>
        <?php include 'customCss.css'; ?>
    </style>
    <nav>
            <div class="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="logo">
                <a href="<?php echo $HOME_URL;?>/mis-gallos">Gallero Soy</a>
            </div>
            <div class="links">
                        <ul>
                            <li>
                                <a href="<?php echo $HOME_URL;?>/mis-gallos">Mis gallos</a>
                            </li>
                            <li>
                                <a href="<?php echo $HOME_URL;?>/coliseos">Coliseos</a>
                            </li>
                            <li>
                                <a href="<?php echo $HOME_URL;?>/paises">Paises</a>
                            </li>
                            <li>
                                <a href="<?php echo $HOME_URL;?>/trabas">Trabas</a>
                            </li>
                            <li>
                                <a href="<?php echo $HOME_URL;?>/crestas">Crestas</a>
                            </li>
                            <li style="position:relative;">
                                <div id="dropdown_btn">
                                    <p href="#">Cuenta</p>
                                    <p class="dropdown_symbol">></p>
                                </div>
                                <div class="cuenta_dropdown">
                                    <a href="<?php echo $HOME_URL;?>/login/">Iniciar sesión</a>
                                    <a href="<?php echo $HOME_URL;?>/password-reset/">Reestablecer contraseña</a>
                                    <a href="<?php echo $HOME_URL;?>/register/">Registrarse</a>
                                    <a href="<?php echo $HOME_URL;?>/logout/">Cerrar sesión</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="mobile-menu">
                    <div class="mobile-logo">
                        <p class="mobile-logo-section">Gallero Soy</p>
                        <p class="btn-cerrar">X</p>
                    </div>
                    <div class="mobile-links">
                        <ul>
                            <li>
                                <a href="<?php echo $HOME_URL;?>/mis-gallos">Mis gallos</a>
                            </li>
                            <li>
                                <a href="<?php echo $HOME_URL;?>/coliseos">Coliseos</a>
                            </li>
                            <li>
                                <a href="<?php echo $HOME_URL;?>/paises">Paises</a>
                            </li>
                            <li>
                                <a href="<?php echo $HOME_URL;?>/trabas">Trabas</a>
                            </li>
                            <li>
                                <a href="<?php echo $HOME_URL;?>/crestas">Crestas</a>
                            </li>
                            <li class="cuenta-button">
                                <a href="#">Cuenta ></a>
                            </li>
                        </ul>
                    </div>
                    <div class="cuenta-links">
                        <ul>
                            <li class="back-link">
                                <a href="#"><</a>
                            </li>
                            <li>
                                <a href="<?php echo $HOME_URL;?>/login/">Iniciar sesión</a>
                            </li>
                            <li>
                                <a href="<?php echo $HOME_URL;?>/password-reset/">Reestablecer contraseña</a>
                            </li>
                            <li>
                                <a href="<?php echo $HOME_URL;?>/register/">Registrarse</a>
                            </li>
                            <li>
                                <a href="<?php echo $HOME_URL;?>/logout/">Cerrar sesión</a>
                            </li>
                        </ul>
                    </div>
                </div>
        <script>
            let cuentaMenu = document.querySelector(".cuenta-links");
            let mobileMenu = document.querySelector(".mobile-menu");
            let mobileLinks = document.querySelector(".mobile-links");
            let desktopDropdown = document.querySelector(".cuenta_dropdown");
            let botonCerrar = document.querySelector(".btn-cerrar");
            let botonMenu = document.querySelector(".hamburger");
            let botonCuenta = document.querySelector(".cuenta-button");
            let botonRegresar = document.querySelector(".back-link");
            let botonDesktopDropdown = document.querySelector("#dropdown_btn");

                            
            botonMenu.addEventListener("click", moveMenu);
            botonCerrar.addEventListener("click", moveMenu);
            botonRegresar.addEventListener("click", displayCuentaLinks);
            botonCuenta.addEventListener("click", displayCuentaLinks);


            botonDesktopDropdown.addEventListener("mouseover", function() {
                displayDropdown();   
            });
            botonDesktopDropdown.addEventListener("mouseout", function() {
                displayDropdown(false);   
            });
            desktopDropdown.addEventListener("mouseover", function() {
                displayDropdown();   
            });
            desktopDropdown.addEventListener("mouseout", function() {
                displayDropdown(false);   
            });

            
            function displayCuentaLinks(){
                if(cuentaMenu.style.display === 'none'){
                    cuentaMenu.style.display = 'flex';
                    mobileLinks.style.display = 'none';
                }else{
                    cuentaMenu.style.display = 'none';
                    mobileLinks.style.display = 'flex';
                }
            }

            function displayDropdown(display = true){
                if(display){
                    desktopDropdown.style.display = 'flex';
                }else{
                    desktopDropdown.style.display = 'none';
                }
            }

            function moveMenu(){                
                if(mobileMenu.style.left == '-250px'){
                    mobileMenu.style.left="0px";
                } else {
                    mobileMenu.style.left = "-250px";
                }
            }
        </script>
    </body>
</html>