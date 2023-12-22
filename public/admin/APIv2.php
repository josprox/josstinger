<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../panel");
}
$iduser = $_SESSION['id_usuario'];
secure_auth_admin($iduser,"../");

$row = new GranMySQL();
$row -> seleccion = "name";
$row -> tabla = "users";
$row -> comparar = "id";
$row -> comparable = $iduser;
$consulta = $row -> where();

$directorios = [
    "custom_admin.php" => (__DIR__ . DIRECTORY_SEPARATOR . "../../API/custom_admin.php"),
    "custom_public.php" => (__DIR__ . DIRECTORY_SEPARATOR . "../../API/custom_public.php")
  ];

$fecha_cliente = new fecha_cliente();
if($fecha_cliente -> hora_24() >= "18:01" && $fecha_cliente -> hora_24() <= "24:00"){
$fondo = "fondo_oscuro";
}else{
$fondo = "fondo_blanco";
}

$check = new SysJosSecurity\SysNAND;

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
    <h3>configura tus archivos API.</h3>
      <?php
    error_reporting(0);

    $archivo = strip_tags((string) $_GET['archivo']);

    if(isset($_POST['crear'])){
        $conexion = conect_mysqli();
        $archivo = mysqli_real_escape_string($conexion, (string) $_POST['archivo']);
        $ruta = mysqli_real_escape_string($conexion, (string) $_POST['carpeta']);
        $conexion -> close();
        $directorio = (DIRECTORY_SEPARATOR . $carpeta . DIRECTORY_SEPARATOR . $archivo);
        $check -> jossito = "crear_archivo";
        $check -> jossito_info = [
            "API". $directorio,
            "<?php //Aquí podrás editar el archivo ?>"
        ];
        $check -> condicion = !file_exists(__DIR__ . "/../../API" . $directorio);
        if($check -> comparar() == TRUE){
            ?>
            <script>
                Swal.fire(
                'Ya está',
                'Se ha creado el archivo de manera correcta',
                'success'
                )
            </script>
            <script>
            timer: 8000,
            window.location.href = "./APIv2"
            </script>
            <?php
        }
    }

    if($archivo==""){
        $archivos = scandir(__DIR__ . DIRECTORY_SEPARATOR ."../../API/");
        if(!file_exists($directorios['custom_admin.php']) || !file_exists($directorios['custom_public.php'])){
        ?>
        <div class="dashboard_index">
            <div class="bienvenida <?php echo $fondo; ?>">
                <p>Bienvenido(a) <?php echo $consulta['name']; ?> al gestionador de API's, ahora podrás modificar tus API's como tu desees, ya no es necesario modificar el archivo principal, de esta manera, nunca perderás tus modificaciones al actualizar a JosSecurity.</p>
            </div>
            <main class="tabla">
                <?php
                foreach($directorios as $nombre => $ruta){
                    $check->condicion = !file_exists($ruta);
                    if($check -> comparar() == TRUE){
                        ?>
                        <div class="tarjeta <?php echo $fondo; ?>">
                            <p>Actualmente el archivo <b><?php echo $nombre; ?></b> no ha sido configurado para poder tener atributos personalizados, favor de crearlo para modificarlo de manera correcta.</p>
                            <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
                                <input type="hidden" name="archivo" value="<?php echo $nombre; ?>">
                                <input type="hidden" name="carpeta" value="<?php echo $ruta; ?>">
                                <button name="crear" type="submit" class="btn btn-primary">Crear archivo</button>
                            </form>
                        </div>
                        <?php
                    }
                }
                ?>
            </main>
        </div>
        <?php
        }
        ?>
            <h3>Archivos API que puedes modificar.</h3>
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
        echo edit_file("Estás editando: $archivo",__DIR__ . DIRECTORY_SEPARATOR ."../../API/" . $archivo);
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