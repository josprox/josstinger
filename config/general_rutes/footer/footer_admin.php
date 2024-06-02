<!-- Cookies aviso -->
<script src="./../../resourses/js/aviso-cookies.js"></script>
<!-- Bootstrap JavaScript Libraries -->
<script src="./../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- Video.js base JS -->
  <script src="./../../resourses/js/video.min.js"></script>
  <!--Funciones del video, desactivar si no se usa-->
  <script>
      var reproductor = videojs('form-video', {
        fluid: true
      });
    </script>
  <!-- Uso de richtext -->
  <script>
        $(document).ready(function() {
            $('.textarea').richText();
        });
    </script>

<?php
if(file_exists(__DIR__ . "/../../../routes/footer/footer_admin.php")){
    include (__DIR__ . "/../../../routes/footer/footer_admin.php");
}
?>