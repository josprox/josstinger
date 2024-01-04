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

$url_general = "routes/";
$url_interno = (\JS_ROUTE . $url_general);
$directorios = [
    "head.php" => ($url_interno . "head/head.php"),
    "head_users.php" => ($url_interno . "head/head_users.php"),
    "head_admin.php" => ($url_interno . "head/head_admin.php"),
    "navbar.php" => ($url_interno . "navbar/navbar.php"),
    "navbar_admin.php" => ($url_interno . "navbar/navbar_admin.php"),
    "navbar_users.php" => ($url_interno . "navbar/navbar_users.php"),
    "footer.php" => ($url_interno . "footer/footer.php"),
    "footer_admin.php" => ($url_interno . "footer/footer_admin.php"),
    "footer_users.php" => ($url_interno . "footer/footer_users.php")
];

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
    <h1>Modifica tus archivos head, navbar y footer.</h1>
      <?php
    error_reporting(0);

    $archivo = strip_tags((string) $_GET['archivo']);

    if(isset($_POST['crear'])){
        $conexion = conect_mysqli();
        $archivo = mysqli_real_escape_string($conexion, (string)$_POST['archivo']);
        $conexion-> close();
        $link = $directorios[$archivo];
        $create = fopen($link, 'w');
        fwrite($create, "<?php //Aquí podrás editar el archivo ?>");
        fclose($create);
        ?>
        <script>
                Swal.fire({
                    title: "Archivo creado",
                    text: "El archivo fue creado correctamente, será redireccionado en 2 segundos",
                    icon: "success"
                });
                // Espera medio segundo (500 milisegundos) antes de recargar la página
                setTimeout(function() {
                    // Obtén la URL actual
                    var currentUrl = window.location.href;
                    // Elimina los parámetros GET de la URL
                    var urlWithoutParams = currentUrl.split('?')[0];
                    // Recarga la página con la nueva URL
                    window.location.href = urlWithoutParams;
                }, 2000);
            </script>
        <?php
    }elseif(isset($_POST['eliminar'])){
        $conexion = conect_mysqli();
        $archivo = mysqli_real_escape_string($conexion, (string)$_POST['archivo']);
        $conexion-> close();
        $link = $directorios[$archivo];
        if(!file_exists($link)){
            ?>
            <script>
                Swal.fire({
                    title: "Archivo Borrado",
                    text: "El archivo fue borrado correctamente.",
                    icon: "question"
                });
                // Espera medio segundo (500 milisegundos) antes de recargar la página
                setTimeout(function() {
                    // Obtén la URL actual
                    var currentUrl = window.location.href;
                    // Elimina los parámetros GET de la URL
                    var urlWithoutParams = currentUrl.split('?')[0];
                    // Recarga la página con la nueva URL
                    window.location.href = urlWithoutParams;
                }, 500);
            </script>
            <?php
        }else{
            unlink($link);
            ?>
            <script>
                Swal.fire({
                    title: "Listo",
                    text: "El archivo se ha eliminado correctamente",
                    icon: "success"
                });
                setTimeout(function() {
                    // Obtén la URL actual
                    var currentUrl = window.location.href;
                    // Elimina los parámetros GET de la URL
                    var urlWithoutParams = currentUrl.split('?')[0];
                    // Recarga la página con la nueva URL
                    window.location.href = urlWithoutParams;
                }, 2000);

            </script>
            <?php
            
        }
    }

    if($archivo==""){
        (int)$count = 0;
        foreach ($directorios as $archivo => $directorio){
            if(!file_exists($directorio)){
                $count ++;
            }
        }
        if($count != 0){
        ?>
        <div class="dashboard_index">
            <div class="bienvenida fondo_blanco">
                <p>Bienvenido(a) <?php echo $consulta['name']; ?> al gestionador de archivos, ahora podrás modificar tus archivos como tu desees, ya no es necesario modificar el archivo principal, de esta manera, nunca perderás tus modificaciones al actualizar tu JosSecurity, actualmente puedes modificar <?php if($count > 1){ echo $count . " archivos"; }else{ echo $count . "archivo"; } ?>.</p>
            </div>
            <main class="tabla">
                <?php
                foreach($directorios as $nombre => $ruta){
                    $check->condicion = !file_exists($ruta);
                    if($check -> comparar() == TRUE){
                        ?>
                        <div class="tarjeta fondo_blanco">
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
            <h3>Archivos head que puedes modificar.</h3>
            <ul class="directorios grid_3_auto">
                <?php
                $json = escanear_directorio($url_general . "head/");
                if (json_validate($json) == 1) {
                    $direct = json_decode($json, true); // Decodificar como array asociativo

                    foreach ($direct as $item) {
                        ?>
                        <a href='?archivo=<?php echo $item['url']; ?>'>
                            <li><i class="fa-solid fa-folder"></i> <?php echo $item['nombre']; ?></li>
                        </a>
                        <?php
                    }
                }
                ?>
            </ul>

            <h3>Archivos navbar que puedes modificar.</h3>
            <ul class="directorios grid_3_auto">
                <?php
                $json = escanear_directorio($url_general . "navbar/");
                if (json_validate($json) == 1) {
                    $direct = json_decode($json, true); // Decodificar como array asociativo

                    foreach ($direct as $item) {
                        ?>
                        <a href='?archivo=<?php echo $item['url']; ?>'>
                            <li><i class="fa-solid fa-folder"></i> <?php echo $item['nombre']; ?></li>
                        </a>
                        <?php
                    }
                }
                ?>
            </ul>

            <h3>Archivos footer que puedes modificar.</h3>
            <ul class="directorios grid_3_auto">
                <?php
                $json = escanear_directorio($url_general . "footer/");
                if (json_validate($json) == 1) {
                    $direct = json_decode($json, true); // Decodificar como array asociativo

                    foreach ($direct as $item) {
                        ?>
                        <a href='?archivo=<?php echo $item['url']; ?>'>
                            <li><i class="fa-solid fa-folder"></i> <?php echo $item['nombre']; ?></li>
                        </a>
                        <?php
                    }
                }
                ?>
            </ul>


            <?php
    }elseif(isset($_GET['archivo'])){

        $titulo = $_GET['archivo'];
        $directorio = $directorios[$titulo];
        if(!file_exists($directorio)){
            ?>
            <script>
                Swal.fire({
                    title: "Archivo no encontrado",
                    text: "El archivo que estás buscando no se encuentra, no tiene acceso a él o es una carpeta, intentalo de nuevo.",
                    icon: "question"
                });
                setTimeout(function() {
                    // Obtén la URL actual
                    var currentUrl = window.location.href;
                    // Elimina los parámetros GET de la URL
                    var urlWithoutParams = currentUrl.split('?')[0];
                    // Recarga la página con la nueva URL
                    window.location.href = urlWithoutParams;
                }, 2000);
            </script>
            <?php
        }else{
            echo edit_file("Estás editando: $archivo",$directorio);
            if($archivo != "index.php"){
                ?>
                <br>
            <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
                <input type="hidden" name="archivo" value="<?php echo $titulo; ?>">
                <center>
                    <button type="submit" name="eliminar" class="btn btn-danger" >Eliminar</button>
                </center>
            </form>
                <?php
            }
        }
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