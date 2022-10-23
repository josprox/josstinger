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

    <h1 align="Center">Sistema de pago</h1>
    <p align="justify">Agregue opacidad a la etiqueta del cuerpo y disminúyala todos los días hasta que su sitio desaparezca por completo. Establezca una fecha de vencimiento y personalice la cantidad de días que les ofrece hasta que el sitio web desaparezca por completo.</p>

      <?php
      not_pay();
      ?>


  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
</body>

</html>