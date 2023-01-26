<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ./../panel");
}

$iduser = $_SESSION['id_usuario'];
secure_auth_admin($iduser,"../");

//$row = consulta_mysqli_where("name","users","id",$iduser);
$row = new GranMySQL();
$row -> seleccion = "name";
$row -> tabla = "users";
$row -> comparar = "id";
$row -> comparable = $iduser;
$consulta = $row -> where();

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
    <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
      <button name="eliminar" class="btn btn-success" type="submit">Eliminar ahora</button>
    </form>
  </center>
  
  <?php
  }
  ?>

  <h1 align="center">Bienvenido a <?php echo $nombre_app; ?></h1>
  <p align="center"><?php
  $fecha_cliente = new fecha_cliente();
  if($fecha_cliente -> hora_24() >= "00:00" && $fecha_cliente -> hora_24() <= "12:00"){
    echo "Buenos días";
  }elseif($fecha_cliente -> hora_24() >= "12:01" && $fecha_cliente -> hora_24() <= "18:00"){
    echo "Buenas tardes";
  }elseif($fecha_cliente -> hora_24() >= "18:01" && $fecha_cliente -> hora_24() <= "24:00"){
    echo "buenas noches";
  }
  ?> <?php echo $consulta['name']; ?></p>
  <p align="center">Versión: <?php echo $version_app; ?></p>
  
  <?php 
  // Le hablamos a Visibility Logic
  $control = new VisibilityLogic();
  // Le pedimos que muestre el contenido.
  $control -> accion = "mostrar";
  // Ahora condicionamos que solo muestre a esta dirección IP.
  $control -> ip = "::1";
  if($control -> ip() == TRUE){
    echo reproductor_video("../../resourses/video/Josstinger.mp4");
  }
  //En el caso que el usuario no usa esta IP, mostrará lo siguiente.
  elseif($control -> ip() == FALSE){
    ?>
    <div class="card">
      <img class="card-img-top" src="./../../resourses/img/logo azul/cover.png" alt="Title">
    </div>
    <?php
  }
  // Cerramos la clase.
  $control -> cerrar();
  ?>
  <br>
  <p align="center">Este sistema fue creado por JOSPROX MX | Internacional, visita nuestra <a href="https://jossecurity.josprox.com/" role="button">documentación</a> para saber cómo usar el sistema de JosSecurity.</p>


  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
</body>

</html>
