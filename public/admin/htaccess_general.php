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
    ".htaccess" => "/",
    ".htaccess" => "/public"
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
            $archivos = scandir(__DIR__ . DIRECTORY_SEPARATOR . "../../");
            ?>
            <h1>Modifica tus archivos de htaccess.</h1>
            <ul class="directorios grid_3_auto">
            <?php
            for ($i=0; $i < (is_countable($archivos) ? count($archivos) : 0); $i++) { 
                if ($archivos[$i] !="." && $archivos[$i] !=".." && $archivos[$i] ==".htaccess") {
                    if(!is_dir($archivos[$i])){
                        ?>
                        <a href='?archivo=<?php echo $archivos[$i]; ?>&type=htaccess&value=1'><li><i class="fa-solid fa-folder"></i> <?php echo $archivos[$i]; ?> JosSecurity</li></a>
                        <?php
                    }else{
                        echo $archivos[$i] . "<br>";
                    }
                    
                }
            }
            $archivos = scandir(__DIR__ . DIRECTORY_SEPARATOR . "../../public/");
            for ($i=0; $i < (is_countable($archivos) ? count($archivos) : 0); $i++) { 
                if ($archivos[$i] !="." && $archivos[$i] !=".." && $archivos[$i] ==".htaccess") {
                    if(!is_dir($archivos[$i])){
                        ?>
                        <a href='?archivo=<?php echo $archivos[$i]; ?>&type=htaccess&value=2'><li><i class="fa-solid fa-folder"></i> <?php echo $archivos[$i]; ?> Público</li></a>
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
                <p><?php echo $consulta['name']; ?> aquí verás si hay archivos que no existen y puedes personalizarlos (Beta) 😉</p>
            </div>
            <main class="tabla">

                <?php
                foreach($checking as $key => $value) {
                    $check -> condicion = !file_exists(__DIR__ . "/../.." . DIRECTORY_SEPARATOR . $value . DIRECTORY_SEPARATOR . $key);
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
            if($_GET['value'] == 1){
                $consulta = "";
                $modificacion = "del sistema";
            }else{
                $consulta = "public";
                $modificacion = "público";
            }
            echo edit_file("Estás editando: $archivo $modificacion", "./../.." . DIRECTORY_SEPARATOR . $consulta . DIRECTORY_SEPARATOR . $archivo);
            ?>
            <br>
            <center>
                <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
                <div class="mb-3">
                    <label for="generar" class="form-label">Restaurar archivo</label>
                    <select class="form-select form-select-sm" name="generar" id="generar">
                        <option selected>Selecciona una opción</option>
                        <option value="1">Archivo para sistema de pruebas</option>
                        <option value="2">Archivo para producción</option>
                    </select>
                </div>
                    <input type="hidden" name="archivo" value="<?php echo $titulo; ?>">
                    <input type="hidden" name="carpeta" value="<?php echo $_GET['value']; ?>">
                    <button name="eliminar" type="submit" class="btn btn-warning">Restaurar archivo</button>
                </form>
            </center>
            <a class="btn btn-primary" href="<?php echo basename(__FILE__); ?>" role="button">Regresar</a>
            <br>
            <?php
        }
        if(isset($_POST['eliminar'])){
            $conexion = conect_mysqli();
            $archivo = mysqli_real_escape_string($conexion, (string) $_POST['archivo']);
            $carpeta = mysqli_real_escape_string($conexion, (int) $_POST['carpeta']);
            $generar = mysqli_real_escape_string($conexion, (int) $_POST['generar']);
            if($generar == 1){
                $link_download = "https://raw.githubusercontent.com/josprox/JosSecurity/main/.htaccess";
            }elseif($generar == 2){
                $archive_generate = "<IfModule mod_rewrite.c>\nRewriteEngine On\nRewriteRule ^(.*)$ public/$1 [L]\nErrorDocument 404 /document_errors/404.html\nErrorDocument 403 /document_errors/404.html\nErrorDocument 410 /document_errors/410.html\nErrorDocument 500 /document_errors/500.html\n</IfModule>\n<Files .htaccess>\norder allow,deny\ndeny from all\n</Files>\n\n<Files .env>\norder allow,deny\ndeny from all\n</Files>";
            }
            if($carpeta == 1){
                $carpeta_name = "";
            }else{
                $carpeta_name = "public";
            }
            $conexion -> close();
            $local_info = (__DIR__ . "/../.." . DIRECTORY_SEPARATOR . $carpeta_name . DIRECTORY_SEPARATOR . $archivo);
            $check -> jossito = "";
            $check -> jossito_info = [];
            $check -> condicion = file_exists($local_info);
            if($check -> comparar() == TRUE){
                if($generar == 1){
                    unlink($local_info);
                    $file_contents = file_get_contents($link_download);
                    $local_file_path = ($local_info);
                    file_put_contents($local_file_path, $file_contents);
                }elseif($generar == 2){
                    unlink($local_info);
                    $htaccess_create = fopen($local_info, 'w');
                    fwrite($htaccess_create, "<IfModule mod_rewrite.c>\nRewriteEngine On\nRewriteRule ^(.*)$ public/$1 [L]\nErrorDocument 404 /document_errors/404.html\nErrorDocument 403 /document_errors/404.html\nErrorDocument 410 /document_errors/410.html\nErrorDocument 500 /document_errors/500.html\n</IfModule>\n<Files .htaccess>\norder allow,deny\ndeny from all\n</Files>\n\n<Files .env>\norder allow,deny\ndeny from all\n</Files>");
                    fclose($htaccess_create);
                }
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
                window.location.href = "./htaccess_general.php"
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