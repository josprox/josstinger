<?php

include (__DIR__ . "/../jossecurity.php");

?>
<!DOCTYPE html>
<html lang="es-MX">
  <head>
    <title><?php echo $nombre_app; ?> - Contacto</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Contacta a <?php echo $nombre_app; ?> de una manera fácil y segura, te atenderemos lo más rápido posible.">
    <?php head(); ?>
  </head>
  <body>
    
	  <?php navbar(); ?>

    <section class="home-slider owl-carousel">
      <div class="slider-item bread-item" style="background-image: url(../resourses/images/bg_1.jpg);" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container-fluid">
          <div class="row slider-text align-items-center justify-content-center" data-scrollax-parent="true">

            <div class="col-md-8 mt-5 text-center col-sm-12 ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
              <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="./">Inicio</a></span> <span>Contacto</span></p>
	            <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Contacto</h1>
            </div>
          </div>
        </div>
      </div>
    </section>
  
    <section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row d-flex mb-5 contact-info">
          <div class="col-md-12 mb-4">
            <h2 class="h4">Formas de contacto</h2>
          </div>
          <div class="w-100"></div>
          <div class="col-md-3">
            <p><span>Celular:</span> <a href="tel://5540373610">+52 5540373610</a></p>
          </div>
          <div class="col-md-3">
            <p><span>Email:</span> <a href="mailto:<?php echo $_ENV['SMTP_USERNAME']; ?>"><?php echo $_ENV['SMTP_USERNAME']; ?></a></p>
          </div>
          <div class="col-md-3">
            <p><span>Sitio web</span> <a href="https://<?php echo $_ENV['DOMINIO']; ?>/contact">https://<?php echo $_ENV['DOMINIO']; ?>/contact</a></p>
          </div>
        </div>

        <?php
        if(isset($_POST['contacto'])){
          $conexion = conect_mysqli();
          $nombre = (string)mysqli_real_escape_string($conexion, $_POST['nombre']);
          $correo = (string)mysqli_real_escape_string($conexion, $_POST['correo']);
          $asunto = (string)mysqli_real_escape_string($conexion, $_POST['asunto']);
          $mensaje = (string)mysqli_real_escape_string($conexion, $_POST['mensaje']);
          mysqli_close($conexion);
          mail_smtp_v1_3_recibir($nombre,$asunto,$mensaje,$correo);
          echo "
          <script>
          Swal.fire(
          'Enviado',
          'El mensaje ha sido enviado con éxito',
          'success'
          )
      </script>
          ";
        }
        ?>

            <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
              <div class="col-auto">
                  <input name="nombre" type="text" class="form-control" placeholder="Pon tu nombre">
              </div>
              <div class="col-auto">
                <input name="correo" type="text" class="form-control" placeholder="Pon tu correo">
              </div>
              <div class="col-auto">
                <input name="asunto" type="text" class="form-control" placeholder="¿cuál es tu asunto?">
              </div>
              <div class="col-auto">
                <label>Pon tu mensaje</label>
                <textarea name="mensaje" class="textarea"></textarea>
                <br>
                <center>
                  <input name="contacto" type="submit" value="Enviar correo" class="btn btn-primary py-3 px-5">
                </center>
              </div>
            </form>

      </div>
    </section>

    <?php footer(); ?>
    
  </body>
</html>