<section class="footer">
            
                    <div class="grid_4_auto">
            
                        <div class="footer_section">
                            <img src="../resourses/img/logo_hestia/vector/default.svg" alt="">
                            <h3><?php echo \NOMBRE_APP; ?></h3>
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
                                <li><a href="./">Inicio</a></li>
                                <li><a href="about">Acerca de</a></li>
                                <li><a href="hosting">Hosting</a></li>
                                <li><a href="contact">Contacto</a></li>
                            </ul>
                        </div>
            
                        <div class="footer_section">
                            <h3>Legalidad</h3>
                            <ul>
                                <li><a href="politica">Privacidad</a></li>
                                <li><a href="terminos">Términos y condiciones</a></li>
                            </ul>
                        </div>
            
                        <div class="footer_section">
                            <h3>Contactos</h3>
                            <ul>
                                <li><a href="mailto:<?php echo $_ENV['SMTP_USERNAME']; ?>"><i class="fa-regular fa-envelope"></i> <?php echo $_ENV['SMTP_USERNAME']; ?></a></li>
                            </ul>
                        </div>
            
                    </div>
            </section>
        <!-- Bootstrap JavaScript Libraries -->
        <script src="./../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <!-- Uso de richtext -->
        <script>
            $(document).ready(function() {
                $('.textarea').richText();
            });
        </script>
        <script>
        window.onload = function() {
            if (window.location.hash) {
                const element = document.querySelector(window.location.hash);
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth' });
                }
            }
        };

        </script>
