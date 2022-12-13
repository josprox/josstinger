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
      if(crear_archivo("routes/footer/footer_admin.php","<?php //Aquí podrás editar tu footer del administrador ?>") == TRUE){
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          <strong>Felicidades</strong> Acabas de crear el archivo donde podrás editar tu footer sin problemas.
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
      unlink(__DIR__ . "/../../routes/footer/footer_admin.php");
    }
    if(!file_exists(__DIR__ . "/../../routes/footer/footer_admin.php")){
      ?>
      <div class="alert alert-primary" role="alert">
        <strong>Novedad:</strong> Esta alerta es para informarte que, desde la actualización 1.7.3 ya no es obligatorio tener el archivo por defecto, ahora tu decides si crearlo o no, de esta manera previenes que en alguna futura acualizacion tus datos se pierdan o se actualicen sin tu requerimiento.
      </div>
      <center>
        <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
          <button name="newfile" type="submit" class="btn btn-primary">Crear archivo</button>
        </form>
      </center>
      <?php
    }else{
      edit_file("Archivo footer del administrador","./../../routes/footer/footer_admin.php");
      ?>
        <center>
          <h3 class="center">¿Deseas borrar este archivo?</h3>
          <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
            <button name="deletefile" type="submit" class="btn btn-warning">Eliminar archivo</button>
          </form>
        </center>
      <?php
    }
  ?>


  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
</body>

</html>
