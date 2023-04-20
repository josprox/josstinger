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

$fecha_cliente = new fecha_cliente();
if($fecha_cliente -> hora_24() >= "18:01" && $fecha_cliente -> hora_24() <= "24:00"){
$fondo = "fondo_oscuro";
}else{
$fondo = "fondo_blanco";
}
$check = new SysJosSecurity\SysNAND;
$checking = [
    "head.php" => "head",
    "head_users.php" => "head",
    "head_admin.php" => "head",
    "navbar.php" => "navbar",
    "navbar_admin.php" => "navbar",
    "navbar_users.php" => "navbar",
    "footer.php" => "footer",
    "footer_admin.php" => "footer",
    "footer_users.php" => "footer"
];

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
      if(isset($_POST['crear'])){
        $conexion = conect_mysqli();
        $archivo = mysqli_real_escape_string($conexion, (string) $_POST['archivo']);
        $carpeta = mysqli_real_escape_string($conexion, (string) $_POST['carpeta']);
        $conexion -> close();
        $directorio = (DIRECTORY_SEPARATOR . $carpeta . DIRECTORY_SEPARATOR . $archivo);
        $check -> jossito = "crear_archivo";
        $check -> jossito_info = [
            "routes". $directorio,
            "<?php //Aquí podrás editar el archivo ?>"
        ];
        $check -> condicion = !file_exists(__DIR__ . "/../../routes" . $directorio);
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
            window.location.href = "./hnf"
            </script>
            <?php
        }
      }
      if(isset($_GET['archivo'])){
          $archivo = strip_tags((string) $_GET['archivo']);
      }else{
        error_reporting(0);
      }
        if($archivo==""){
            $archivos = scandir(__DIR__ . DIRECTORY_SEPARATOR . "../../routes/head/");
            ?>
            <h1>Modifica tus archivos de Head, Navbar y Footer.</h1>
            <ul class="directorios grid_3_auto">
            <?php
            for ($i=0; $i < (is_countable($archivos) ? count($archivos) : 0); $i++) { 
                if ($archivos[$i] !="." && $archivos[$i] !=".." && $archivos[$i] !="head.txt") {
                    if(!is_dir($archivos[$i])){
                        ?>
                        <a href='?archivo=<?php echo $archivos[$i]; ?>&type=head'><li><i class="fa-solid fa-folder"></i> <?php echo $archivos[$i]; ?></li></a>
                        <?php
                    }else{
                        echo $archivos[$i] . "<br>";
                    }
                    
                }
            }
            $archivos = scandir(__DIR__ . DIRECTORY_SEPARATOR . "../../routes/navbar/");
            for ($i=0; $i < (is_countable($archivos) ? count($archivos) : 0); $i++) { 
                if ($archivos[$i] !="." && $archivos[$i] !=".." && $archivos[$i] !="navbar.txt") {
                    if(!is_dir($archivos[$i])){
                        ?>
                        <a href='?archivo=<?php echo $archivos[$i]; ?>&type=navbar'><li><i class="fa-solid fa-folder"></i> <?php echo $archivos[$i]; ?></li></a>
                        <?php
                    }else{
                        echo $archivos[$i] . "<br>";
                    }
                    
                }
            }
            $archivos = scandir(__DIR__ . DIRECTORY_SEPARATOR . "../../routes/footer/");
            for ($i=0; $i < (is_countable($archivos) ? count($archivos) : 0); $i++) { 
                if ($archivos[$i] !="." && $archivos[$i] !=".." && $archivos[$i] !="footer.txt") {
                    if(!is_dir($archivos[$i])){
                        ?>
                        <a href='?archivo=<?php echo $archivos[$i]; ?>&type=footer'><li><i class="fa-solid fa-folder"></i> <?php echo $archivos[$i]; ?></li></a>
                        <?php
                    }else{
                        echo $archivos[$i] . "<br>";
                    }
                    
                }
            }

            ?>
            </ul>
            <div class="dashboard_index">
                <div class="bienvenida <?php echo $fondo; ?>">
                <p><?php echo $consulta['name']; ?> aquí verás si hay archivos que no existen y puedes personalizarlos 😉</p>
            </div>
            <main class="tabla">

                <?php
                foreach($checking as $key => $value) {
                    $check -> condicion = !file_exists(__DIR__ . "/../../routes" . DIRECTORY_SEPARATOR . $value . DIRECTORY_SEPARATOR . $key);
                    if($check -> comparar() == TRUE){
                    ?>
                    <div class="tarjeta <?php echo $fondo; ?>">
                        <p>Actualmente el archivo <b><?php echo $key; ?></b> no ha sido configurado para poder tener atributos personalizados, favor de crearlo para modificarlo de manera correcta.</p>
                        <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
                            <input type="hidden" name="archivo" value="<?php echo $key; ?>">
                            <input type="hidden" name="carpeta" value="<?php echo $value; ?>">
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
        }else{

            $titulo = $_GET['archivo'];
            $tipo = $_GET['type'];
            echo edit_file("Estás editando: $archivo", "./../../routes" . DIRECTORY_SEPARATOR . $tipo . DIRECTORY_SEPARATOR . $archivo);
            ?>
            <br>
            <center>
                <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
                    <input type="hidden" name="archivo" value="<?php echo $titulo; ?>">
                    <input type="hidden" name="carpeta" value="<?php echo $tipo; ?>">
                    <button name="eliminar" type="submit" class="btn btn-danger">Eliminar archivo</button>
                </form>
            </center>
            <a class="btn btn-primary" href="<?php echo basename(__FILE__); ?>" role="button">Regresar</a>
            <br>
            <?php
        }
        if(isset($_POST['eliminar'])){
            $conexion = conect_mysqli();
            $archivo = mysqli_real_escape_string($conexion, (string) $_POST['archivo']);
            $carpeta = mysqli_real_escape_string($conexion, (string) $_POST['carpeta']);
            $conexion -> close();
            $directorio = (DIRECTORY_SEPARATOR . $carpeta . DIRECTORY_SEPARATOR . $archivo);
            $check -> jossito = "";
            $check -> jossito_info = [];
            $check -> condicion = file_exists(__DIR__ . "/../../routes" . $directorio);
            if($check -> comparar() == TRUE){
                unlink(__DIR__ . "/../../routes" . $directorio);
                ?>
                <script>
                    Swal.fire(
                    'Ya está',
                    'Se ha eliminado el archivo de manera correcta',
                    'success'
                    )
                </script>
                <script>
                timer: 8000,
                window.location.href = "./hnf"
                </script>
            <?php
            }
        }
    ?>
  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
</body>

</html>