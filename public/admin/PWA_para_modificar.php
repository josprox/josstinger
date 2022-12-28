<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../panel");
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

  <div class="container">

    <?php 
    if(isset($_POST['newfile'])){
        if(copiar_archivo("public/PWA/manifest.php","public/PWA/manifest_custom.php") == TRUE){
          ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Felicidades</strong> Acabas de crear el archivo donde podrás editar tu manifest sin problemas.
          </div>
          
          <script>
            var alertList = document.querySelectorAll('.alert');
            alertList.forEach(function (alert) {
              new bootstrap.Alert(alert)
            })
          </script>
          
          <?php
        }
      }
      if(isset($_POST['deletefile'])){
        unlink(__DIR__ . DIRECTORY_SEPARATOR . "../PWA/manifest_custom.php");
      }
    if(!file_exists(__DIR__ . DIRECTORY_SEPARATOR . "../PWA/manifest_custom.php")){
        ?>
        <div class="alert alert-primary" role="alert">
          <strong>Novedad:</strong> Desde la versión 8.1.3 ahora puedes crear un sistema de manifiesto propio, con esto evitas que, al actualizar tu sistema a nuevas versiones, el archivo se desconfigure, si deseas crear un archivo modificado para asegurar el sistema da clic en el botón de abajo.
        </div>
        <center>
          <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
            <button name="newfile" type="submit" class="btn btn-primary">Crear archivo</button>
          </form>
        </center>
        <?php
        edit_file("Archivo PWA predefinido","../PWA/manifest.php");
    }elseif(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "../PWA/manifest_custom.php")){
        edit_file("Archivo PWA Custom","../PWA/manifest_custom.php");
        ?>
        <center>
          <h3 class="center">¿Deseas borrar este archivo?</h3>
          <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
            <button name="deletefile" type="submit" class="btn btn-warning">Eliminar archivo</button>
          </form>
        </center>
        <hr>
        <?php
    }
    ?>
    <?php edit_file("Archivo Service Worker","../PWA/service.js"); edit_file("Configuración Service Worker","../sw.js"); ?>
    <br>

  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
</body>

</html>