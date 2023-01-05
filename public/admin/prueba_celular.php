<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
  header("Location: ./../panel");
}

if(!isset($_ENV['TWILIO']) OR $_ENV['TWILIO'] !=1){
  header("Location: ./");
}

$iduser = $_SESSION['id_usuario'];
secure_auth_admin($iduser,"../");

?>

<!doctype html>
<html lang="es-MX">

<head>
  <title><?php echo $nombre_app," versión: ", $version_app; ?></title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php head_admin(); ?>

</head>

<body>

    <?php
    if(isset($_POST['enviar'])){
        $conexion = conect_mysqli();
        $phone = mysqli_real_escape_string($conexion, (string) $_POST['phone']);
        $menssage = mysqli_real_escape_string($conexion, (string) $_POST['menssage']);
        $conexion -> close();

        $enviar = new Nuevo_Mensaje();
        $enviar -> numero = $phone;
        $enviar -> mensaje = $menssage;
        $enviar -> enviar();
        if($enviar == TRUE){
          $enviar -> cerrar();
            ?>
            <script>
                Swal.fire(
                'Corrcto',
                'El mensaje fue enviado de manera correcta.',
                'success'
                )
            </script>
            <?php
        }elseif($enviar == FALSE){
          $enviar -> cerrar();
            ?>
            <script>
                Swal.fire(
                'Falló',
                'El mensaje no fue enviado de manera correcta.',
                'error'
                )
            </script>
            <?php
        }
    }
    ?>

  <?php navbar_admin(); ?>

  <div class="container">
    <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
        <div class="grid_2_auto">
            <div class="mb-3 contenedor">
              <label for="phone" class="form-label">Número de celular</label>
              <input type="tel"
                class="form-control" name="phone" id="phone" aria-describedby="phone" placeholder="+5255XXXXXXXX">
              <small id="phone" class="form-text text-muted">Pon aquí el número donde mandaremos el mensaje a través de Twilio.</small>
            </div>
            <div class="mb-3 contenedor">
              <label for="menssage" class="form-label">Pon el texto que enviarás</label>
              <textarea class="form-control" name="menssage" id="menssage" rows="3">Este es un mensaje de prueba dentro de <?php echo nombre_app; ?>, puedes modificarlo a tu gusto o mandar tal cual este mensaje.</textarea>
            </div>
        </div>
        <center>
            <button type="submit" name="enviar" class="btn btn-success">Enviar mensaje</button>
        </center>
    </form>
  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
</body>

</html>
