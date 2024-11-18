<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("jpx_users");

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


  <div class="container">
    <center>
        <h1>Generar catálogo</h1>
    </center>
    <p>En Josstinger le damos al usuario un catálogo para que el motor de facebook consuma un xml. Solo deberá darle clic al botón de abajo para poder obtener la url generado de manera correcta.</p>

    <center>
        <a class="btn btn-success" href="../catalogo/catalogo" target="_blank" rel="noopener noreferrer">Acceder al catálogo</a>
    </center>

  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
</body>

</html>