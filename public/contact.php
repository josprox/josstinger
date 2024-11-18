<?php
include (__DIR__ . "/../jossecurity.php");
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nombre_app; ?> - Formas de contacto</title>
    <meta name="description" content="Contacta a <?php echo $nombre_app; ?> de una manera fácil y segura, te atenderemos lo más rápido posible.">
    <?php head(); ?>
</head>
<body>

    <?php navbar(); ?>

    <section class="secction">
        <img src="../resourses/img/backgroud/pexels-manuel-geissinger-325229.jpg" class="filtro" alt="">
        <div class="encima">
            <div class="contenedor">
                <div class="grid_1_auto">
                    <div class="contenido">
                        <p>Inicio <i class="fa-solid fa-arrow-right-long"></i> <a href="contact">Contacto</a></p>
                        <h1 class="text-shadow-black text-center">Contacto</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
        if(isset($_POST['contacto'])){
          $conexion = conect_mysqli();
          $nombre = mysqli_real_escape_string($conexion, (string) $_POST['nombre']);
          $correo = mysqli_real_escape_string($conexion, (string) $_POST['correo']);
          $asunto = mysqli_real_escape_string($conexion, (string) $_POST['asunto']);
          $mensaje = mysqli_real_escape_string($conexion, (string) $_POST['mensaje']);
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

    <section class="contenedor">
      <div class="contacto_form">
        <div class="contacto_form_text">
          <h2>Formas de contacto</h2>
          <?php
          $contacto = new VisibilityLogic();
          $contacto -> accion = "mostrar";
          $contacto -> iduser_tabla = "jpx_users";
          if($contacto -> rol_usuario() == 6 OR $contacto -> rol_usuario() == 1){
            ?>
          <ul>
            <li><a href="mailto:<?php echo (string)$_ENV['SMTP_USERNAME']; ?>"><i class="fa-regular fa-envelope"></i> <?php echo (string)$_ENV['SMTP_USERNAME']; ?></a></li>
            <li><a href="<?php echo check_http() . $_ENV['DOMINIO']; ?>/contact"> Sitio web: <?php echo check_http() . $_ENV['DOMINIO']; ?>/contact</a></li>
          </ul>
            <?php
          }else{
            ?>
            <p>Para poder saber los métodos de contacto, favor de crear una cuenta y mantener el inicio de sesión dentro de <?php echo $_ENV['NAME_APP']; ?>.</p>
            <?php
          }
          ?>
        </div>
        <div class="contacto_form_form">
          <?php
          $control = new VisibilityLogic();
          $control -> accion = "mostrar";
          $control -> iduser_tabla = "jpx_users";
          if($control -> rol_usuario() == 6 OR $control -> rol_usuario() == 1){
            ?>
            <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">

              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text"
                    class="form-control form-control-sm" name="nombre" id="nombre" aria-describedby="nombre" placeholder="Pon tu nombre">
                <small id="nombre" class="form-text text-muted">Pon tu nombre para identificarte</small>
              </div>

              <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email"
                    class="form-control form-control-sm" name="correo" id="correo" aria-describedby="correo" placeholder="Pon tu correo">
                <small id="correo" class="form-text text-muted">Necesitamos tu correo para poder contactarte</small>
              </div>

              <div class="mb-3">
                <label for="asunto" class="form-label">Asunto</label>
                <input type="text"
                    class="form-control form-control-sm" name="asunto" id="asunto" aria-describedby="asunto" placeholder="Pon el asunto">
                <small id="asunto" class="form-text text-muted">Ayudanos a saber qué necesitas</small>
              </div>

              <div class="mb-3">
                <label for="mensaje" class="form-label">Pon tu mensaje</label>
                <textarea class="textarea" name="mensaje" id="mensaje" rows="3"></textarea>
              </div>

              <br>
              <center>
                <input name="contacto" type="submit" value="Enviar correo" class="btn btn-primary py-3 px-5">
              </center>
              
            </form>
            <?php
          }else{
            ?>
            <div class="contacto_form_login">
              <h2>Antes de continuar</h2>
              <div class="grid_2_auto">
                <div>
                  <img src="./../resourses/img/logo_hestia/vector/default.svg" alt="<? echo $_ENV['NAME_APP']; ?>">
                </div>
                <div>
                  <p align="justify">Para poder continuar deberás crear una cuenta o acceder para enviar un correo, recuerda que, si haces spam serás baneado.</p>
                  <div class="flex_center">
                    <a class="btn btn-primary" href="panel" role="button">Acceder</a>
                  </div>
                </div>
              </div>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
    </section>

    <?php cookie(); footer(); ?>
    
</body>
</html>
