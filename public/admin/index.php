<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ./../panel");
}

$iduser = $_SESSION['id_usuario'];
secure_auth_admin($iduser,"../");

$row = consulta_mysqli_where("name","users","id",$iduser);

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
  if(isset($_POST['eliminar'])){
    unlink('./../../installer.php');
  }
  if (file_exists("./../../installer.php")){?>
  <div class="alert alert-warning" role="alert">
    <strong>Advertencia</strong> Se recomienda que elimines el fichero installer.
  </div>

  <center>
    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
      <button name="eliminar" class="btn btn-success" type="submit">Eliminar ahora</button>
    </form>
  </center>
  
  <?php
  }
  ?>

  <h1 align="center">Bienvenido a <?php echo $nombre_app; ?></h1>
  <p align="center">Un gusto volver a verte <?php echo $row['name']; ?></p>
  <p align="center">Versión: <?php echo $version_app; ?></p>
  
  <?php echo reproductor_video("../../resourses/video/Josstinger.mp4"); ?>
  <!--<div class="card">
    <img class="card-img-top" src="./../../resourses/img/logo azul/cover.png" alt="Title">
  </div>-->

  <br>


  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
</body>

</html>