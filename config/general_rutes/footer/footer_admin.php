<!-- Cookies aviso -->
<script src="./../../resourses/js/aviso-cookies.js"></script>
<!-- Bootstrap JavaScript Libraries -->
<script src="./../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
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