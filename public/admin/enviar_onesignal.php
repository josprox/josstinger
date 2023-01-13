<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ./../panel");
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

  <?php navbar_admin(); ?>

  <br>

  <?php
  if(isset($_POST['push'])){
    $conexion = conect_mysqli();
    (string)$titulo = mysqli_real_escape_string($conexion, (string) $_POST['titulo']);
    (string)$titulo_ing = mysqli_real_escape_string($conexion, (string) $_POST['titulo_ing']);
    (string)$msg_ing = mysqli_real_escape_string($conexion, (string) $_POST['mensaje_ing']);
    (string)$msg_esp = mysqli_real_escape_string($conexion, (string) $_POST['mensaje_esp']);
    (string)$url = mysqli_real_escape_string($conexion, (string) $_POST['url']);
    $conexion -> close();
    $push = new Nuevo_Push();
    $push -> titulo_esp = $titulo;
    $push -> titulo_ing = $titulo_ing;
    $push -> mensaje_esp = $msg_esp;
    $push -> mensaje_ing = $msg_esp;
    $push -> url_personalizado = $url;
    if( $push -> enviar() == true){
        $push -> cerrar();
        ?>
        <script>
            Swal.fire(
            'Éxito',
            'La notificación push se ha enviado correctamente',
            'success'
            )
        </script>
        <?php
    }else{
        $push -> cerrar();
        ?>
        <script>
            Swal.fire(
            'Falló',
            'La notificación push no se envió correctamente',
            'error'
            )
        </script>
        <?php
    }
  }
  ?>

  <div class="container">
    <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">

        <div class="grid_2_auto">
            <div class="mb-3 contenedor">
                <label for="titulo" class="form-label">Titulo del mensaje</label>
                <input type="text"
                class="form-control" name="titulo" id="titulo" aria-describedby="titulo" placeholder="Pon el título del mensaje">
                <small id="titulo" class="form-text text-muted">Aquí va el título del mensaje</small>
            </div>
            <div class="mb-3 contenedor">
              <label for="titulo_ing" class="form-label">Titulo en inglés</label>
              <input type="text"
                class="form-control" name="titulo_ing" id="titulo_ing" aria-describedby="titulo_ing" placeholder="Pon el título del mensaje">
              <small id="titulo_ing" class="form-text text-muted">Aquí va el título en ingles del mensaje.</small>
            </div>
            <div class="mb-3 contenedor">
              <label for="mensaje_esp" class="form-label">Pon el mensaje en Español</label>
              <textarea class="form-control" name="mensaje_esp" id="mensaje_esp" rows="3"></textarea>
            </div>
            <div class="mb-3 contenedor">
              <label for="mensaje_ing" class="form-label">Por el mensaje en inglés</label>
              <textarea class="form-control" name="mensaje_ing" id="mensaje_ing" rows="3"></textarea>
            </div>
        </div>
        <div class="grid_1_auto">
            <div class="mb-3 contenedor">
              <label for="url" class="form-label">Link personalizado</label>
              <input type="text"
                class="form-control" name="url" id="url" aria-describedby="url" placeholder="Escribe la ruta del link personalizado.">
              <small id="url" class="form-text text-muted">Aquí va la dirección personalizada.</small>
            </div>
        </div>
        <div class="flex_center">
            <button type="submit" name="push" class="btn btn-primary">Enviar push</button>
        </div>
    </form>
  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
</body>

</html>
