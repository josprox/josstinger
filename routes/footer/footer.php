<footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2"><?php echo $_ENV['NAME_APP']; ?></h2>
              <p>El hosting que tú necesitas.</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="https://twitter.com/josprox"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="https://www.facebook.com/Josproxmx/"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="https://www.instagram.com/josprox/"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Links internos</h2>
              <ul class="list-unstyled">
                <li><a href="./" class="py-2 d-block">Inicio</a></li>
                <li><a href="about" class="py-2 d-block">Acerca de</a></li>
                <li><a href="hosting" class="py-2 d-block">Hosting</a></li>
                <li><a href="contact" class="py-2 d-block">Contacto</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Legalidad</h2>
              <ul class="list-unstyled">
                <li><a href="https://josprox.com/privacidad/" class="py-2 d-block">Privacidad</a></li>
                <li><a href="https://josprox.com/terminos-y-condiciones/" class="py-2 d-block">Términos y condiciones</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Contactos</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><a href="tel://5540373610"><span class="icon icon-phone"></span><span class="text">+52 5540373610</span></a></li>
	                <li><a href="mailto:<?php echo $_ENV['SMTP_USERNAME']; ?>"><span class="icon icon-envelope"></span><span class="text"><?php echo $_ENV['SMTP_USERNAME']; ?></span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> Todos los derechos reservados de <a href="https://josprox.com/" target="_blank">JOSPROX MX | Internacional</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
      </div>
    </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="../resourses/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="../resourses/js/popper.min.js"></script>
  <script src="../resourses/js/bootstrap.min.js"></script>
  <script src="../resourses/js/jquery.easing.1.3.js"></script>
  <script src="../resourses/js/jquery.waypoints.min.js"></script>
  <script src="../resourses/js/jquery.stellar.min.js"></script>
  <script src="../resourses/js/owl.carousel.min.js"></script>
  <script src="../resourses/js/jquery.magnific-popup.min.js"></script>
  <script src="../resourses/js/aos.js"></script>
  <script src="../resourses/js/jquery.animateNumber.min.js"></script>
  <script src="../resourses/js/bootstrap-datepicker.js"></script>
  <script src="../resourses/js/jquery.timepicker.min.js"></script>
  <script src="../resourses/js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="../resourses/js/google-map.js"></script>
  <script src="../resourses/js/main.js"></script>
  <!-- Uso de richtext -->
  <script>
        $(document).ready(function() {
            $('.textarea').richText();
        });
    </script>
<?php
correr_not_pay();
?>