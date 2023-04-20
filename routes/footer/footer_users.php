    <section class="app_josstinger">
        <div class="flex_center">
            <div class="contenedor">
                <div class="grid_2_auto">
                    <div class="app_josstinger_info">
                        <h2>Conoce <?php echo $_ENV['NAME_APP']; ?></h2>
                        <h3>El hosting que tú necesitas</h3>
                        <p align="justify">Aloja tu sitio web o aplicación web de manera segura, <?php echo $_ENV['NAME_APP']; ?> es el mejor proveedor de hosting de México, consulta nuestros precios.</p>
                        <div class="app_josstinger_appgallery">
                            <div class="img_appgallery">
                                <img src="../../resourses/img/Huawei_AppGallery.svg.png" alt="">
                            </div>
                            <div class="text_appgallery">
                                <p>Desde ahora puedes descargar nuestra aplicación nativa en AppGallery gratis.</p>
                            </div>
                        </div>
                    </div>
                    <div class="contenedor">
                        <div class="app_josstinger_youtube flex_center">
                            <iframe class="app_josstinger_youtube_video" src="https://www.youtube.com/embed/-Mu2YuQABLA" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <center>
                            <div class="grid_1">
                                <a class="btn btn_transparente" href="https://appgallery.huawei.com/app/C107358057" target="_blank" rel="noopener noreferrer">Ir a AppGallery</a>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </section>
        <section class="footer">
            
                    <div class="grid_4_auto">
            
                        <div class="footer_section">
                            <img src="../../resourses/img/logo_hestia/vector/default.svg" alt="">
                            <h3><?php echo nombre_app; ?></h3>
                            <p>El hosting que tú necesitas.</p>
                            <div class="grid_3">
                                <a href="https://twitter.com/josprox">
                                    <div class="links_circulos">
                                        <i class="fa-brands fa-twitter"></i>
                                    </div>
                                </a>
                                <a href="https://www.facebook.com/Josproxmx/">
                                    <div class="links_circulos">
                                        <i class="fa-brands fa-facebook"></i>
                                    </div>
                                </a>
                                <a href="https://www.instagram.com/josprox/">
                                    <div class="links_circulos">
                                        <i class="fa-brands fa-instagram"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
            
                        <div class="footer_section">
                            <h3>Links internos</h3>
                            <ul>
                                <li><a href="../">Inicio</a></li>
                                <li><a href="../about">Acerca de</a></li>
                                <li><a href="../hosting">Hosting</a></li>
                                <li><a href="../contact">Contacto</a></li>
                            </ul>
                        </div>
            
                        <div class="footer_section">
                            <h3>Legalidad</h3>
                            <ul>
                                <li><a href="../politica">Privacidad</a></li>
                                <li><a href="../terminos">Términos y condiciones</a></li>
                            </ul>
                        </div>
            
                        <div class="footer_section">
                            <h3>Contactos</h3>
                            <ul>
                                <li><a href="tel:+525540373610"><i class="fa-solid fa-phone"></i> +52 5540373610</a></li>
                                <li><a href="mailto:<?php echo $_ENV['SMTP_USERNAME']; ?>"><i class="fa-regular fa-envelope"></i> <?php echo $_ENV['SMTP_USERNAME']; ?></a></li>
                            </ul>
                        </div>
            
                    </div>
        </section>
<!-- Bootstrap JavaScript Libraries -->
    <script src="./../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>