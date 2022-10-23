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
    <p align="justify">Tener un respaldo garantiza que los datos estén seguros y que la información crítica no se pierda. Esto aplica para proteger configuración, robo de datos o cualquier otro tipo de emergencia.</p>

    <?php
    if(isset($_POST['allinone'])){
      echo all_in_one();
    }
    ?>

    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
    <center>
      <button name="allinone" type="submit" class="btn btn-warning">Respaldar</button>
    </center>
    </form>

  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
</body>

</html>