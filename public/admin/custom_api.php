<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../panel");
}
$iduser = $_SESSION['id_usuario'];
secure_auth_admin($iduser,"../");

$directorio = (__DIR__ . DIRECTORY_SEPARATOR . "../../API/custom.php");
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

  <div class="alert alert-success" role="alert"><strong>Recuerda: </strong><a href="https://jossecurity.josprox.com/conexion-por-medio-de-api/" class="alert-link">Puedes consultar cómo usar esta API dando clic aquí</a>.</div>

  <?php
    if(!isset($_ENV['API']) || $_ENV['API'] != 1){
      ?>
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>Atención</strong> Usted no puede usar este sistema de API´s porque no se encuentra activado o no existe en tus variables del sistema, favor de checar su archivo ".env".
      </div>
      
      <script>
        var alertList = document.querySelectorAll('.alert');
        alertList.forEach(function (alert) {
          new bootstrap.Alert(alert)
        })
      </script>
      
      <?php
    }
    if(isset($_POST['newfile'])){
      if(crear_archivo("API/custom.php","<?php //Aquí podrás crear tus propios Jossitos, recuerda que debes meterlos como un case ?>") == TRUE){
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          <strong>Felicidades</strong> Acabas de crear el archivo donde podrás crear tus jossitos sin problemas.
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
      unlink($directorio);
    }
    if(!file_exists($directorio)){
      ?>
      <div class="alert alert-primary" role="alert">
        <strong>Novedad:</strong> Esta alerta es para informarte que, desde la actualización 2.3.4 ya no es obligatorio tener el archivo por defecto, ahora tu decides si crearlo o no, de esta manera previenes que en alguna futura acualizacion tus datos se pierdan o se actualicen sin tu requerimiento.
      </div>
      <center>
        <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
          <button name="newfile" type="submit" class="btn btn-primary">Crear archivo</button>
        </form>
      </center>
      <?php
    }else{
      edit_file("Agrega funciones a la API",$directorio);
      ?>
        <center>
          <h3 class="center">¿Deseas borrar este archivo?</h3>
          <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
            <button name="deletefile" type="submit" class="btn btn-warning">Eliminar archivo</button>
          </form>
        </center>
      <?php
    }
    edit_file("API principal",__DIR__ . DIRECTORY_SEPARATOR . "../../API/index.php");
  ?>

  </div>
  <br>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
</body>

</html>
