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

error_reporting(0);

$archivo = strip_tags((string) $_GET['archivo']);

if($archivo==""){
    $archivos = scandir(__DIR__ ."/");
    ?>
        <h1>Lista de directorios.</h1>
        <ul class="directorios grid_3_auto">
        <?php
        for ($i=0; $i < (is_countable($archivos) ? count($archivos) : 0); $i++) { 
            if ($archivos[$i] !="." && $archivos[$i] !="..") {
                if(!is_dir($archivos[$i])){
                    ?>
                    <a href='?archivo=<?php echo $archivos[$i]; ?>'><li><i class="fa-solid fa-folder"></i> <?php echo $archivos[$i]; ?></li></a>
                    <?php
                }else{
                    echo $archivos[$i] . "<br>";
                }
                
            }
        }
        ?>
        </ul>
        <?php
    }else{

        $titulo = $_GET['archivo'];
        echo edit_file("Estás editando: $archivo",$archivo);
        ?>
        <a class="btn btn-primary" href="<?php echo basename(__FILE__); ?>" role="button">Regresar</a>
        <?php
    }

    ?>
  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
</body>

</html>