<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../panel");
}

$iduser = $_SESSION['id_usuario'];
secure_auth_admin($iduser,"../");

if($_ENV['PLUGINS'] != 1){
  header("location: ./");
}

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

    <h1 align="Center">Sistema de respaldo</h1>
    <p align="justify">Tener un respaldo garantiza que los datos estén seguros y que la información crítica no se pierda. Esto aplica para proteger su configuración, prevenir robo de datos o cualquier otro tipo de emergencia. Este sistema respalda lo que tú necesitas, cada respaldo guarda el archivo SQL de la base de datos.</p>

    <?php
    if(isset($_POST['allinone'])){
      $tipo = (int)$_POST['tipo'];
      all_in_one($tipo);
    }
    if(isset($_POST['eliminar'])){
      borrar_directorio($_POST['directorio']);
    }
    ?>

    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
    <center>
      <div class="col-10">
        <div class="mb-3">
          <label for="tipo" class="form-label">¿Qué carpeta desea respaldar?</label>
          <select class="form-select form-select-lg" name="tipo" id="tipo">
            <option selected>Selecciona una opción</option>
            <option value="1">Todo</option>
            <option value="2">Plugins</option>
            <option value="3">Config</option>
            <option value="4">Public</option>
            <option value="5">Resourses</option>
            <option value="6">Routes</option>
          </select>
        </div>
      </div>
      <button name="allinone" type="submit" class="btn btn-warning">Respaldar</button>
    </center>
    </form>

  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
</body>

</html>