<?php

use SysJosSecurity\SysNAND;

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
$sistema = new SysJosSecurity\SysNAND();

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
  if(isset($_POST['limpiar'])){
    $sistema -> condicion = ['png', "jpg", "webp", "svg"];
    $sistema -> directorio = "resourses/img/";
    if($sistema -> organizar() == TRUE){
      $sistema -> condicion = ["htm", "html"];
      $sistema -> directorio = "public/";
      if($sistema -> organizar() == TRUE){
        $sistema -> condicion = ["css", "scss"];
        $sistema -> directorio = "resourses/scss/";
        if($sistema -> organizar() == TRUE){
          $sistema -> condicion = ["js", "ts"];
          $sistema -> directorio = "resourses/js/";
          if($sistema -> organizar() == TRUE){
            $ruta_respaldo_all = __DIR__ . DIRECTORY_SEPARATOR . "../../plugins/all in one/respaldo_all";
            $ruta_respaldo = __DIR__ . DIRECTORY_SEPARATOR . "../../plugins/all in one/respaldos";
            if(is_dir($ruta_respaldo_all)){
              borrar_directorio($ruta_respaldo_all);
            }
            if(is_dir($ruta_respaldo)){
              borrar_directorio($ruta_respaldo);
            }
            ?>
            <script>
                Swal.fire(
                'Ya está',
                'Se ha organizado todo de manera correcta.',
                'success'
                )
            </script>
            <?php
          }
        }
      }
    }
  }
  if(isset($_POST['optimizar'])){
    $sistema -> directorio = "resourses/img/";
    if($sistema -> comprimir_img() == TRUE){
      ?>
      <script>
          Swal.fire(
          'Ya está',
          'Se han optimizado las imágenes de manera correcta, para verlas ve a la carpta de JosSecurity y accede a resourses, ahí encontrarás una carpeta llamada "img_optimizacion".',
          'success'
          )
      </script>
      <?php
    }
  }
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
  $fecha_cliente = new fecha_cliente();
  if($fecha_cliente -> hora_24() >= "18:01" && $fecha_cliente -> hora_24() <= "24:00"){
    $fondo = "fondo_oscuro";
  }else{
    $fondo = "fondo_blanco";
  }
  ?>

  <h1 align="center">Bienvenido a <?php echo $nombre_app; ?></h1>

  <section class="dashboard_index">
        <div class="bienvenida <?php echo $fondo; ?>">
            <p><?php
  if($fecha_cliente -> hora_24() >= "00:00" && $fecha_cliente -> hora_24() <= "12:00"){
    echo "Buenos días";
  }elseif($fecha_cliente -> hora_24() >= "12:01" && $fecha_cliente -> hora_24() <= "18:00"){
    echo "Buenas tardes";
  }elseif($fecha_cliente -> hora_24() >= "18:01" && $fecha_cliente -> hora_24() <= "24:00"){
    echo "Buenas noches";
  }
  ?> <?php echo $consulta['name']; ?>, un gusto volver a verte. 👌</p>
        </div>
        <main class="tabla">
            <div class="tarjeta <?php echo $fondo; ?>">
                <i class="fa-solid fa-trash"></i>
                <p>Organiza los archivos con un clic.</p>
                <form action="" method="post">
                    <button name="limpiar" type="submit" class="btn btn-primary">Limpiar</button>
                </form>
            </div>
            <div class="tarjeta <?php echo $fondo; ?>">
                <i class="fa-solid fa-image"></i>
                <p>Optimizar imágenes.</p>
                <form action="" method="post">
                    <button name="optimizar" type="submit" class="btn btn-secondary">Optimizar</button>
                </form>
            </div>
            <div class="tarjeta <?php echo $fondo; ?>">
                <?php 
                if(check_http() == "https://"){
                  $ssl = "Conectado con seguridad";
                  ?>
                  <i class="fa-solid fa-lock"></i>
                  <?php
                }elseif(check_http() == "http://" || check_http() == ""){
                  ?>
                  <i class="fa-solid fa-unlock"></i>
                  <?php
                  $ssl = "Conectado sin seguridad, probablemente en un entorno de pruebas (localhost).";
                }
                ?>
                <p><?php echo $ssl; ?></p>
            </div>
        </main>
    </section>

  <br>
  <p align="center">Este sistema fue creado por JOSPROX MX | Internacional, visita nuestra <a href="https://jossecurity.josprox.com/" role="button">documentación</a> para saber cómo usar el sistema de JosSecurity. Versión: <?php echo $version_app; ?></p>


  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
</body>

</html>
