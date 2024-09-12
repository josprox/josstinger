<?php

// JosSecurity, la mejor seguridad al alcance de tus manos.

if(!file_exists(__DIR__ . DIRECTORY_SEPARATOR . ".env")){
    header("Location: ../installer.php");
}

// NO ELIMINES las lineas 6 a 9 por seguridad, si tu borras estas linea dejará de funcionar JosSecurity.
if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php')){
    require_once (__DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php');
}else{
    echo "El sistema no puede detectar el autoload de vendor.";
}
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
use PragmaRX\Google2FAQRCode\Google2FA;
use PragmaRX\Google2FA\Google2FA as GoogleAuthenticator;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QROutputInterface;
session_start();
date_default_timezone_set($_ENV['ZONA_HORARIA']);

// Definiciones dentro de JosSecurity
define("NOMBRE_APP",(string)$_ENV['NAME_APP']);
define("VERSION",(float)$_ENV['VERSION']);
define("JS_ROUTE", __DIR__ . DIRECTORY_SEPARATOR);
define("FECHA",date("Y-m-d H:i:s"));
define("FECHA_1_DAY",date("Y-m-d H:i:s", strtotime(\FECHA . "+ 1 days")));
define("ZONA_HORARIA_CLIENTE", date_default_timezone_get());
define("RUTA", check_http() . $_ENV['DOMINIO'] . $_ENV['HOMEDIR']);
//Configuración por defecto de JosSecurity
$fecha = \FECHA;
$nombre_app = \NOMBRE_APP;
$version_app = \VERSION;

if ($_ENV['DEBUG'] == 1) {
    echo "<script>console.log('".$nombre_app." está funcionando.');</script>";
}

function head($bootstrap=0){

    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." Head está activo.');</script>";
    }
    return include (__DIR__ . "/config/general_rutes/head/head.php");
    $pagina = nombre_de_pagina();
    if($pagina != "panel.php" && $bootstrap !=0){
        ?>
        <!-- Bootstrap min -->
        <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
        <?php
    }
}

function head_users($bootstrap=0){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." Head admin está activo.');</script>";
    }
    return include (__DIR__ . "/config/general_rutes/head/head_users.php");
    if($bootstrap !=0){
        ?>
        <!-- Bootstrap min -->
        <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
        <?php
    }
}

function head_admin(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." Head admin está activo.');</script>";
    }
    return include (__DIR__ . "/config/general_rutes/head/head_admin.php");
}

function navbar(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." navbar está activo.');</script>";
    }
    return include (__DIR__ . "/config/general_rutes/navbar/navbar.php");
}

function navbar_users(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." navbar users está activo.');</script>";
    }
    return include (__DIR__ . "/config/general_rutes/navbar/navbar_users.php");
}

function navbar_admin(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." navbar admin está activo.');</script>";
    }
    return include (__DIR__ . "/config/general_rutes/navbar/navbar_admin.php");
}

function footer($bootstrap = 0){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." footer está activo.');</script>";
    }
    return include (__DIR__ . "/config/general_rutes/footer/footer.php");
    if($bootstrap !=0){
        ?>
        <!-- Bootstrap JavaScript Libraries -->
    <script src="./../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="<?php echo $_ENV['BOOTSTRAP']; ?>" crossorigin="anonymous"></script>
        <?php
    }
}

function footer_users($bootstrap = 0){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." footer admin está activo.');</script>";
    }
    if($bootstrap !=0){
        ?>
        <!-- Bootstrap JavaScript Libraries -->
        <script src="./../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="<?php echo $_ENV['BOOTSTRAP']; ?>" crossorigin="anonymous"></script>
        <?php
    }
    return include (__DIR__ . "/config/general_rutes/footer/footer_users.php");
}

function footer_admin(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." footer admin está activo.');</script>";
    }
    return include (__DIR__ . "/config/general_rutes/footer/footer_admin.php");
}

// JosSecurity configuración del sistema.

// Google 2FA
// Genera una clave secreta aleatoria para el usuario
function SecretKeyGA(){
    $google2fa = new GoogleAuthenticator();
    $secretKey = $google2fa->generateSecretKey();
    return $secretKey;
}

// Muestra los datos de GoogleGenerate
function DatosGA($correo){
    $google2fa = new GoogleAuthenticator();
    $secretKey = SecretKeyGA();

    $url = $google2fa->getQRCodeUrl(
        NOMBRE_APP,
        $correo,
        $secretKey
    );

    $datos = [
        "secretKey" => $secretKey,
        "url" => $url
    ];

    return $datos;
}

// Verifica si el token proporcionado por el usuario es válido
function validarToken($id, $secretKey, $token){
    $google2fa = new GoogleAuthenticator();
    $valido = $google2fa->verifyKey($secretKey, $token);
    if($valido == TRUE){
        actualizar_datos_mysqli("users","`fa` = 'A', `type_fa` = 'GG', `two_fa` = '$secretKey'","id",$id);
    }
    return header("refresh:1;");
}

//Editor de archivos.
function edit_file($titulo,$directorio, $class = ""){
    $archivo = strip_tags((string) $directorio);
    if(isset($_POST['enviar'])){
        $fp=fopen($archivo, "w+");
        fputs($fp,(string) $_POST['contenido']);
        fclose($fp);
        echo "Editado correctamente";
    }

    $fp=fopen($archivo, "r");
    $contenido = fread($fp, filesize($archivo));
    $contenido = htmlspecialchars($contenido);
    fclose($fp);
    ?>
    <h1 align="center"><?php echo $titulo; ?></h1>
    <form action="" method="post">
        <div class="mb-3">
            <textarea name="contenido" rows="15" class="form-control <?php echo $contenido; ?>"><?php echo $contenido; ?></textarea>
        </div>
        <center>
            <input name="enviar" type="submit" class="btn btn-success" value="Guardar archivo">
        </center>
    </form>
    <?php
}
// Conexiones a la base de datos
if ($_ENV['CONECT_DATABASE'] == 1){

    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('Se ha activado la función para usar la base de datos.');</script>";
    }


    if($_ENV['CONECT_MYSQLI'] == 1){

        function conect_mysqli(){
            try {
                $host = (string)$_ENV['HOST'];
                $user = (string)$_ENV['USUARIO'];
                $pass = (string)$_ENV['CONTRA'];
                $DB = (string)$_ENV['BASE_DE_DATOS'];
                $puerto = (string)$_ENV['PUERTO'];
                $conexion = new mysqli("$host","$user", "$pass","$DB", $puerto);
                $conexion->set_charset("utf8");
                
                // AGREGANDO CHARSET UTF8
                if (!$conexion->set_charset("utf8")) {
                    printf("Error código JSS_utf8, no se puede cargar el conjunto de caracteres utf8: %s\n.", $conexion->error);
                    exit();
                }
                
                if($conexion == TRUE){
                    if ($_ENV['DEBUG'] == 1){
                        echo "<script>console.log('La conexión mysqli ha funcionado.');</script>";
                    }
                }else{
                    if ($_ENV['DEBUG'] == 1){
                        echo "<script>console.log('La conexión mysqli ha fallado.');</script>";
                    }
                }
                return $conexion;
            } catch (Exception) {
                // Manejo del error
                echo "Error al conectar a la base de datos.";
                return null; // O cualquier otro manejo que desees darle al error
            }
        }
        
        

    }
    if($_ENV['CONECT_MYSQLI'] != 1){
        if ($_ENV['DEBUG'] == 1){
            echo "<script>console.log('La conexión mysqli está desactivada.');</script>";
        }
    }

    if($_ENV['CONECT_MYSQL'] == 1){

        function conect_mysql(){

            $host = (string)$_ENV['HOST'];
            $user = (string)$_ENV['USUARIO'];
            $pass = (string)$_ENV['CONTRA'];
            $DB = (string)$_ENV['BASE_DE_DATOS'];
            $puerto = (string)$_ENV['PUERTO'];

            try {
                $pdo = new PDO('mysql:host='.$host.';port='.$puerto.';dbname='.$DB.'', $user, $pass);
            } catch (PDOException $e) {
                echo "¡Error al conectar a la base de datos!: " . $e->getMessage();
                return null; // O cualquier otro manejo que desees darle al error
            }

            if ($pdo != null) {
                if ($_ENV['DEBUG'] == 1) {
                    echo "<script>console.log('La conexión mysql ha funcionado.');</script>";
                }
            } else {
                if ($_ENV['DEBUG'] == 1) {
                    echo "<script>console.log('La conexión mysql ha fallado.');</script>";
                }
            }

            return $pdo;
        }

    }
    if($_ENV['CONECT_MYSQL'] != 1){
        if ($_ENV['DEBUG'] == 1){
            echo "<script>console.log('La conexión mysql está desactivada.');</script>";
        }
    }

    if ($_ENV['CONECT_POSTGRESQL'] == 1 || $_ENV['CONECT_POSTGRESQL_PDO'] == 1){
        include (__DIR__ . "/config/extension/postgresql.php");
    }

}else{
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('Se ha desactivado el uso de bases de datos.');</script>";
    }
}

// Se ha configurado GranMail, como una nueva extensión de JosSecurity para dejar atrás a las funciones obsoletas.
if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "config/extension/GranMail/granmail.php")){
    include (__DIR__ . DIRECTORY_SEPARATOR . "config/extension/GranMail/granmail.php");
}

//configuración de logins, registros y cookies

function FA($correo, $contra, $clave, $cookies="si", $redireccion = "panel"){
    $conexion = conect_mysqli();
    $correo = mysqli_real_escape_string($conexion, (string) $correo);
    $contra = mysqli_real_escape_string($conexion, (string) $contra);
    $cookies = mysqli_real_escape_string($conexion, (string) $cookies);
    $conexion -> close();
    $sql_check = new GranMySQL();
    $sql_check -> seleccion = "id, name, phone, fa, type_fa, two_fa, last_ip";
    $sql_check -> tabla = "users";
    $sql_check -> comparar = "email";
    $sql_check -> comparable = "$correo";
    $consulta = $sql_check -> where();
    if($consulta['fa'] != "A" || $consulta['last_ip'] == $_SERVER['REMOTE_ADDR']){
        return logins($correo,$contra,"users",$cookies, $redireccion);
    }else{
        $generador = generar_llave_alteratorio(16);
        $fecha = \FECHA_1_DAY;
        $id_user = $consulta['id'];
        $nombre_user = $consulta['name'];
        $nombre_app = \NOMBRE_APP;
        $web = \RUTA . "panel?login_auth=" . $generador . "&correo=" . $correo . "&contra=" . $contra . "&cookies=" . $cookies;
        switch($consulta['type_fa']){
            case "correo":
                if($clave !=""){
                    $sql_check -> seleccion = "*";
                    $sql_check -> tabla = "check_users";
                    $sql_check -> comparar = "url";
                    $sql_check -> comparable = "$clave";
                    $sql_check -> respuesta = 'num_rows';
                    (int)$where = $sql_check->where();
                    if($where > 0){
                        $sql_check -> respuesta = 'fetch_assoc';
                        $checking = $sql_check->where();
                        $checker = consulta_mysqli_where("email", "users", "id", $checking['id_user']);
                        if($checker["email"] == $correo){
                            eliminar_datos_con_where("check_users","id_user",$checking['id_user']);
                            logins($_GET['arg1'],$_GET['arg2'],"users","si",$_GET['arg5']);
                        }
                    }else{
                        return "no_check_mail";
                    }
                }else{
                    insertar_datos_clasic_mysqli("check_users","id_user, accion, url, expiracion", "'$id_user', 'login_auth', '$generador', '$fecha'");
                    $mensaje = "<div><p>Hola de nuevo $nombre_user</p></div><div><p>Si deseas entrar en $nombre_app podrás hacerlo <a href='$web'>dando clic aquí</a>.</p></div><div><p>Tu código de acceso es: $generador</p></div>";
                    mail_WP($correo,"Inicia sesión",$mensaje);
                    return "2fa";
                }
            break;
            case "GG":
                $llave =(string) $consulta['two_fa'];
                $google2fa = new GoogleAuthenticator();
                // Verifica si el código de la aplicación ingresado por el usuario coincide con el código generado a partir de la clave secreta
                if ($google2fa->verifyKey($llave, $clave, 0)) {
                    // El código de la aplicación es válido, realiza las acciones necesarias (por ejemplo, permitir el acceso al usuario)
                    return logins($correo, $contra, "users", $cookies, $redireccion);
                } else {
                    // El código de la aplicación no es válido, muestra un mensaje de error o realiza alguna otra acción
                    return "error";
                }
            break;
            case "sms":
                if($clave !=""){
                    $sql_check -> seleccion = "*";
                    $sql_check -> tabla = "check_users";
                    $sql_check -> comparar = "url";
                    $sql_check -> comparable = "$clave";
                    $sql_check -> respuesta = 'num_rows';
                    (int)$where = $sql_check->where();
                    if($where > 0){
                        $sql_check -> respuesta = 'fetch_assoc';
                        $checking = $sql_check->where();
                        $checker = consulta_mysqli_where("email", "users", "id", $checking['id_user']);
                        if($checker["email"] == $correo){
                            eliminar_datos_con_where("check_users","id_user",$checking['id_user']);
                            logins($_GET['arg1'],$_GET['arg2'],"users","si",$_GET['arg5']);
                        }
                    }else{
                        return "no_check_sms";
                    }
                }else{
                    insertar_datos_clasic_mysqli("check_users","id_user, accion, url, expiracion", "'$id_user', 'login_auth', '$generador', '$fecha'");
                    if(isset($_ENV['TWILIO']) && $_ENV['TWILIO'] == 1){
                        $enviar = new Nuevo_Mensaje();
                        $enviar -> numero = $consulta['phone'];
                        $enviar -> mensaje = "Se ha detectado una solicitud para iniciar sesión, para continuar acceda al siguiente link: $web si desea acceder por código, su código de acceso es: $generador ";
                        $enviar -> enviar();
                    }else{
                        $mensaje = "<div><p>Hola de nuevo $nombre_user</p></div><div><p>Si deseas entrar en $nombre_app podrás hacerlo <a href='$web'>dando clic aquí</a>.</p><p>Haz recibido por este método tu acceso ya que tenemos dificultades en poder enviarle un sms.</p></div>";
                        mail_WP($correo,"Inicia sesión",$mensaje);
                    }
                    return "2fa";
                }
                break;
        }
    }
}

function logins($correo,$contra,$tabla = "users",$cookies = "si", $redireccion = "panel"){
    $conexion = conect_mysqli();
    $tabla = mysqli_real_escape_string($conexion, (string) $tabla);
    $correo = mysqli_real_escape_string($conexion, (string) $correo);
    mysqli_close($conexion);
    if(leer_tablas_mysql_custom("SELECT id FROM $tabla WHERE email = '$correo'")>= 1){
        $consulta = consulta_mysqli_where("id_rol","$tabla","email","'$correo'");
        $resultado = $consulta['id_rol'];
        $check = new login;
        $check -> correo = $correo;
        $check -> contra = $contra;
        $check -> cookies = $cookies;
        $check -> redireccion = $redireccion; 
        if($resultado == 1 || $resultado == 2 || $resultado == 4){
            $check -> ejecutar();
            if($check == false){
                return false;
            }
        }elseif($resultado != 1 && $resultado != 2 && $resultado != 4){
            $check -> redireccion = "users";
            $check -> modo_admin = FALSE;
            $check -> ejecutar();
            if($check == false){
                return false;
            }
        }
    }
}

include (__DIR__ . DIRECTORY_SEPARATOR . "config/extension/logins.php");

function cookie_session($sesion,$localizacion_admin,$localizacion_users){
    $consulta = consulta_mysqli_where("id_rol","users","id",$sesion);
    $resultado = $consulta["id_rol"];
    if ($resultado == 1 || $resultado == 2 || $resultado == 4){
        header("Location: $localizacion_admin");
    }elseif($resultado != 1 && $resultado != 2 && $resultado != 4){
        header("Location: $localizacion_users");
    }
}

function login_cookie($table_DB){
    $conexion = conect_mysqli();
    if (isset($_COOKIE['COOKIE_INDEFINED_SESSION'])) {
        if ($_COOKIE['COOKIE_INDEFINED_SESSION']) {
            $nombre_user = $_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['user'];
            $password_user = $_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['pass'];
    
            $sql = "SELECT id, password FROM $table_DB WHERE email = '$nombre_user'";
            $resultado = $conexion->query($sql);
            $rows = $resultado->num_rows;
            if ($rows > 0) {
                $row = $resultado->fetch_assoc();
                $password_encriptada = $row['password'];
                if(password_verify((string) $password_user,(string) $password_encriptada) == TRUE){
                    $_SESSION['id_usuario'] = $row['id'];
                    mysqli_close($conexion);
                }
            }
        }
    }
}

function registro($table_db,$name_user,$email_user,$contra_user,$rol_user,$factor = "D", $factor_type = "correo"){
    global $fecha;
    $conexion = conect_mysqli();
    $nombre = mysqli_real_escape_string($conexion, (string) $name_user);
    $email = mysqli_real_escape_string($conexion, (string) $email_user);
	$password = mysqli_real_escape_string($conexion, (string) $contra_user);
	$password_encriptada = password_hash($password,PASSWORD_BCRYPT,["cost"=>10]);
	$rol = mysqli_real_escape_string($conexion,(string) $rol_user);
    $rol = (int)$rol;
	$fa_status = mysqli_real_escape_string($conexion,(string) $factor);


    $sql_check = "SELECT id FROM $table_db WHERE email = '$email'";
    $sql_rest = $conexion->query($sql_check);
    $filas = $sql_rest -> num_rows;
    mysqli_close($conexion);

    if ($filas <= 0) {
        global $nombre_app;
        $key = generar_llave_alteratorio(16);
        insertar_datos_clasic_mysqli($table_db,"name, email, password, id_rol, fa, type_fa, created_at, updated_at","'$nombre', '$email', '$password_encriptada', '$rol', '$fa_status', '$factor_type', '$fecha', NULL");
        if(!isset($_ENV['CHECK_USER']) || $_ENV['CHECK_USER'] != 1){
            $cuerpo_de_correo = "<div><p align='justify'>Te has registrado de manera correcta en ". $nombre_app .", esperamos sea de tu agrado.😊</p></div><div><p>Bienvenido $nombre.</p></div>";
            mail_smtp_v1_3($nombre,"Su registro ha sido exitoso!!",$cuerpo_de_correo,$email);
        }else{
            if($_ENV['DOMINIO'] != "localhost"){
                $ssl_tls = "https://";
            }else{
                $ssl_tls = "http://";
            }
            $fecha_1_day = date("Y-m-d H:i:s", strtotime($fecha . "+ 1 days"));
            $cuerpo_de_correo = "<div><p align='justify'>Te has registrado de manera correcta en ". $nombre_app .", esperamos sea de tu agrado.😊</p></div><div><p>Bienvenido $nombre, antes de continuar, debes activar tu cuenta <a href='".$ssl_tls.$_ENV['DOMINIO'].$_ENV['HOMEDIR']."panel?check_user=$key'>dando clic aquí</a> para terminar el proceso.</p></div>";
            if(mail_smtp_v1_3($nombre,"Su registro ha sido exitoso!!",$cuerpo_de_correo,$email) == TRUE){
                $consulta_id_new = consulta_mysqli_where("id",$table_db,"email","'$email'");
                $id_new = $consulta_id_new['id'];
                insertar_datos_clasic_mysqli("check_users","id_user, url, accion, expiracion","$id_new, '$key', 'check_user', '$fecha_1_day'");
            }
        }
        $success = "
        <script>
            Swal.fire(
            'Completado',
            'Se ha registrado correctamente el usuario',
            'success'
            )
        </script>";
        return $success;
    }elseif($filas >= 1){
        $error = "
        <script>
            Swal.fire(
            'Falló',
            'El usuario ya existe',
            'error'
            )
        </script>";
        return $error;
    }
}

function resetear_contra($correo){
    $key = generar_llave_alteratorio(16);
    $consulta = consulta_mysqli_where("id","users","email","'$correo'");
    $id_correo = $consulta['id'];
    $fecha_1_day = date("Y-m-d H:i:s", strtotime(\FECHA . "+ 1 days"));

    if(insertar_datos_clasic_mysqli("check_users","id_user, accion, url, expiracion","$id_correo,'cambiar_contra', '$key','$fecha_1_day'") == TRUE){
        $row = consulta_mysqli_where("name","users","email","'$correo'");
    
        $name = $row['name'];
    
        if($_ENV['SMTP_ACTIVE'] == 1){
            $mensaje = 'Recientemente has solicitado restablecer tu contraseña es por eso que, le hemos mandado un link para poder restaurar su contraseña, podrá modificarla dentro del sistema.<br><br>Su link es: <a href="'.check_http().$_ENV['DOMINIO'].$_ENV['HOMEDIR']."panel?cambiar_contra=".$key.'">'.check_http().$_ENV['DOMINIO'].$_ENV['HOMEDIR']."panel?cambiar_contra=".$key.'</a>';
            mail_smtp_v1_3("Soporte de " . $_ENV['NAME_APP'],"Resetea tu contraseña",$mensaje, $correo);
            return TRUE;
        }
        if($_ENV['SMTP_ACTIVE'] != 1){
            ?>
            <p>No puedes enviar correos porque no está activado en el sistema.</p>
            <?php
            return FALSE;
        }
    }
}


function actualizar_contra($id, $nueva_contra){
    $conexion = conect_mysqli();
    $id_check = mysqli_real_escape_string($conexion, (string) $id);
    $contra = mysqli_real_escape_string($conexion, (string) $nueva_contra);
    $password_encriptada = password_hash((string) $contra,PASSWORD_BCRYPT,["cost"=>10]);
    $conexion -> close();
    if(actualizar_datos_mysqli("users","`password` = '$password_encriptada'","id",$id_check) == TRUE){
        return TRUE;
    }else{
        return FALSE;
    }
}

function logout($id,$table_DB){

    if($id == ""){
        global $iduser;
        $id = $iduser;
    }

    $conexion = conect_mysqli();
    $table = mysqli_real_escape_string($conexion, (string) $table_DB);
    $sql = "SELECT email,password FROM $table WHERE id = '$id'";
    $resultado = $conexion->query($sql);
    $row = $resultado->fetch_assoc();
    $usuario = $row['email'];
    $password = $row['password'];

    //eliminar cookies creadas por el sistema
    if (isset($_COOKIE['COOKIE_INDEFINED_SESSION'])) {
        setcookie("COOKIE_INDEFINED_SESSION", FALSE, ['expires' => time()-$_ENV['COOKIE_SESSION'], 'path' => "/"]);
        setcookie("COOKIE_DATA_INDEFINED_SESSION[user]", (string) $usuario, ['expires' => time()-$_ENV['COOKIE_SESSION'], 'path' => "/"]);
        setcookie("COOKIE_DATA_INDEFINED_SESSION[pass]", (string) $password, ['expires' => time()-$_ENV['COOKIE_SESSION'], 'path' => "/"]);
    }

    session_destroy();
    mysqli_close($conexion);

}

function eliminar_cuenta($id,$table_DB,$redireccion){
    global $nombre_app;
    $consulta = consulta_mysqli_where("email, name","users","id",$id);
    if (eliminar_datos_con_where($table_DB,"id",$id)) {
        $cuerpo_de_correo = "<div><p>Hemos eliminado tu cuenta, muchas gracias haber sido parte de $nombre_app, esperamos verte en algún momento.</p></div>";
        if(mail_smtp_v1_3($consulta['name'],"Hasta pronto 😢",$cuerpo_de_correo,$consulta['email'])){
            return header("Location: $redireccion");
        }
        return header("Location: $redireccion");
       }else {
        $error = "
        <script>
            Swal.fire(
            'Falló',
            'No se ha podido eliminar de manera correcta.',
            'error'
            )
        </script>";
        return $error;
       }
}

function eliminar_cuenta_con_cookies($id,$table_DB,$redireccion){
    global $nombre_app;
    $consulta = consulta_mysqli_where("email, password, name","users","id",$id);
    $usuario = $consulta['email'];
    $password = $consulta['password'];
    //eliminar cookies creadas por el sistema
    if (isset($_COOKIE['COOKIE_INDEFINED_SESSION'])) {
        setcookie("COOKIE_INDEFINED_SESSION", FALSE, ['expires' => time()-$_ENV['COOKIE_SESSION'], 'path' => "/"]);
        setcookie("COOKIE_DATA_INDEFINED_SESSION[user]", (string) $usuario, ['expires' => time()-$_ENV['COOKIE_SESSION'], 'path' => "/"]);
        setcookie("COOKIE_DATA_INDEFINED_SESSION[pass]", (string) $password, ['expires' => time()-$_ENV['COOKIE_SESSION'], 'path' => "/"]);
    }
    session_destroy();
    if (eliminar_datos_con_where($table_DB,"id",$id)) {
        $cuerpo_de_correo = "<div><p>Hemos eliminado tu cuenta, muchas gracias haber sido parte de $nombre_app, esperamos verte en algún momento.</p></div>";
        if(mail_smtp_v1_3($consulta['name'],"Hasta pronto 😢",$cuerpo_de_correo,$usuario)){
            return header("Location: $redireccion");
        }
       }else {
        $error = "
        <script>
            Swal.fire(
            'Falló',
            'No se ha podido eliminar de manera correcta.',
            'error'
            )
        </script>";
        return $error;
       }
}

//Generador de llaves

function generar_llave_alteratorio($caracteres){
    $key = "";
    $pattern = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    $max = strlen($pattern)-1;
    for($i = 0; $i < $caracteres; $i++){
        $key .= substr($pattern, random_int(0,$max), 1);
    }
    return $key;
}

function generar_llave($caracteres, $patron){
    $key = "";
    $max = strlen((string) $patron)-1;
    for($i = 0; $i < $caracteres; $i++){
        $key .= substr((string) $patron, random_int(0,$max), 1);
    }
    return $key;
}

// Jossitos de correo

function mail_smtp_v1_3($nombre,$asunto,$contenido,$correo){
    $email = new GranMail\NewMail;
    $email -> metodo = "basic";
    $email -> nombre = $nombre;
    $email -> correo = $correo;
    $email -> asunto = $asunto;
    $email -> contenido = $contenido;
    $json = $email -> send();
    return $json;
}

function mail_WP( $to, $subject, $message, $headers = '', $attachments  = [] ){
    $email = new GranMail\NewMail;
    $email -> metodo = "WordPress";
    $email -> nombre = "José Luis";
    $email -> correo = $to;
    $email -> asunto = $subject;
    $email -> contenido = $message;
    $email -> headers = $headers;
    $email -> attachments = $attachments;
    $json = $email -> send();
    return $json;
}

function mail_smtp_v1_3_recibir($nombre,$asunto,$contenido,$correo){
    $email = new GranMail\NewMail;
    $email -> metodo = "recibir";
    $email -> nombre = $nombre;
    $email -> asunto = $asunto;
    $email -> correo = $correo;
    $email -> contenido = $contenido;
    $json = $email -> send();
    return $json;
}

function mail_smtp_v1_3_check($correo){
    $email = new GranMail\NewMail;
    $email -> metodo = "test";
    $email -> correo = $correo;
    $json = $email -> send();
    return $json;
}

//Consultas, lecturas, inserciones y eliminaciones de datos para MySQL o MariaDB, se recomienda usar estos Jossitos dentro del sistema, si vas a permitir que los usuarios registren información a tu base de datos a través de un formulario, se recomienda usar el plugin GranMySQL.

function arreglo_consulta($code){
    $conexion = conect_mysql();
    $sql = $code;
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $query = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conexion = null;
    return $query;
}

function consulta_mysqli_clasic($select_db,$table_db){
    $conexion = conect_mysqli();
    $sql = "SELECT $select_db FROM $table_db";
    $resultado = $conexion->query($sql);
    $fetch = $resultado->fetch_assoc();
    mysqli_close($conexion);
    return $fetch;
}

function consulta_mysqli_where($select_db,$table_db,$data,$compare){
    $conexion = conect_mysqli();
    $sql = "SELECT $select_db FROM $table_db WHERE $data = $compare";
    $resultado = $conexion->query($sql);
    $fetch = $resultado->fetch_assoc();
    mysqli_close($conexion);
    return $fetch;
}

function consulta_mysqli_innerjoin($select_db,$table_db,$inner,$compare,$data){
    $conexion = conect_mysqli();
    $sql = "SELECT $select_db FROM $table_db INNER JOIN $inner ON $compare = $data";
    $resultado = $conexion->query($sql);
    $fetch = $resultado->fetch_assoc();
    mysqli_close($conexion);
    return $fetch;
}

function consulta_mysqli_estructura_tabla($tabla){
    global $DB;
    $conexion = conect_mysqli();
    $sql = "SHOW CREATE TABLE `$DB`.`$tabla`";
    $resultado = $conexion->query($sql);
    $fetch = $resultado->fetch_assoc();
    mysqli_close($conexion);
    return print_r($fetch);
}

function consulta_mysqli_custom_all($code){
    $conexion = conect_mysqli();
    $sql = "$code";
    $resultado = $conexion->query($sql);
    $fetch = $resultado->fetch_assoc();
    mysqli_close($conexion);
    return $fetch;
}

function consulta_mysqli_custom_all_JSON($code){
    $conexion = conect_mysqli();
    $resultado = $conexion->query((string)$code);
    $json = [];
    while($row = mysqli_fetch_assoc($resultado)){
        $json[] = $row;
    }
    $conexion ->close();
    if($json_resultado = json_encode($json, JSON_UNESCAPED_UNICODE)){
        return $json_resultado;
    }else{
        return false;
    }
}

function leer_tablas_mysql_custom($code){
    $conexion = conect_mysqli();
    $sql = "$code";
    $resultado = $conexion->query($sql);
    $rows = $resultado->num_rows;
    mysqli_close($conexion);
    return $rows;
}

function insertar_datos_clasic_mysqli($tabla,$datos,$contenido){
    $conexion = conect_mysqli();
    $sql = "INSERT INTO $tabla ($datos) VALUES ($contenido);";
    if($conexion -> query($sql) == TRUE){
        mysqli_close($conexion);
        return TRUE;
    }else{
        mysqli_close($conexion);
        return FALSE;
    }
}

function insertar_datos_custom_mysqli($codigo_sql){
    $conexion = conect_mysqli();
    $sql = "$codigo_sql";
    if($conexion -> query($sql) == TRUE){
        mysqli_close($conexion);
        return TRUE;
    }else{
        mysqli_close($conexion);
        return FALSE;
    }
}

function insertar_datos_post_mysqli($tabla,$post){
    $conexion = conect_mysqli();

    $insert = "INSERT INTO $tabla (";
    $values = " VALUES (";
    
    foreach ( $post as $key => $value ) {
    $insert .= "$key, ";
    $values .= " '$value', ";
    }
    
    // Eliminar las ultimas comas y cerrar los parentesis
    $insert = substr($insert, 0, -2).')';
    $values = substr($values, 0, -2).')';
    
    $sql = $insert.$values; 

    if($conexion -> query($sql) == TRUE){
        mysqli_close($conexion);
        return TRUE;
    }else{
        mysqli_close($conexion);
        return FALSE;
    }
}

function actualizar_datos_mysqli($tabla,$edicion,$where,$dato){
    global $fecha;
    $miconexion = conect_mysqli();
    $sql = "UPDATE `$tabla` SET $edicion, `updated_at` = '$fecha' WHERE `$tabla`.`$where` = $dato";
    $miconexion -> query($sql);
    if($miconexion -> query($sql) == TRUE){
        $miconexion -> close();
        return TRUE;
    }else{
        $miconexion -> close();
        return FALSE;
    }

}

function eliminar_datos_con_where($tabla,$where,$dato){
    $conexion = conect_mysqli();
    $sql = "DELETE FROM `$tabla` WHERE `$tabla`.`$where` = $dato";
    if ($conexion->query($sql) === TRUE) {
        $success = "
        <script>
            Swal.fire(
            'Completado',
            'Se ha eliminado todo de manera correcta.',
            'success'
            )
        </script>";
        $conexion -> close();
        return $success;
       }else {
        $error = "
        <script>
            Swal.fire(
            'Falló',
            'No se ha podido eliminar de manera correcta.',
            'error'
            )
        </script>";
        $conexion -> close();
        return $error;
       }
}

function eliminar_datos_custom_mysqli($sql_codigo){
    $conexion = conect_mysqli();
    $sql = "$sql_codigo";
    if ($conexion->query($sql) === TRUE) {
        $success = "
        <script>
            Swal.fire(
            'Completado',
            'Se ha eliminado todo de manera correcta.',
            'success'
            )
        </script>";
        $conexion -> close();
        return $success;    
       }else {
        $error = "
        <script>
            Swal.fire(
            'Falló',
            'No se ha podido eliminar de manera correcta.',
            'error'
            )
            </script>";
        $conexion -> close();
        return $error;
       }
}

function crear_tabla_mysqli($tabla,$contenido){
    $conexion = conect_mysqli();
    $sql = "CREATE TABLE `$tabla` (`id` bigint(25) NOT NULL PRIMARY KEY AUTO_INCREMENT, $contenido, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    if($conexion ->query($sql)){
        mysqli_close($conexion);
        return TRUE;
    }else{
        mysqli_close($conexion);
        return FALSE;
    }

}
function crear_tabla_PDO($tabla,$contenido){
    $pdo = conect_mysql();
    $sql = "CREATE TABLE `$tabla` (`id` bigint(25) NOT NULL PRIMARY KEY AUTO_INCREMENT, $contenido, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    if($pdo ->exec($sql)){
        $pdo = null;
        return TRUE;
    }else{
        $pdo = null;
        return FALSE;
    }
    
}

function eliminar_tabla_PDO($tabla){
    $pdo = conect_mysql();
    $sql = "TRUNCATE TABLE `$tabla`;";
    $pdo -> exec($sql);
}

//Reproductor nativo

function reproductor_video($url){
    ?>
    <video class="fm-video video-js vjs-16-9 vjs-big-play-centered" style="margin-top: 12px; margin-bottom: 12px;" data-setup="{}" controls id="form-video">
        <source src="<?php echo $url; ?>" type="video/mp4">
    </video>
    <?php
}

//mensaje de cookies nativo

function cookie(){
    ?>
    <div class="aviso-cookies" id="aviso-cookies">
		<img class="galleta" src="https://freesvg.org/img/1464300474.png" alt="Galleta">
		<h3 class="titulo">Cookies</h3>
		<p class="parrafo">Utilizamos cookies propias y de terceros para mejorar nuestros servicios.</p>
		<button class="boton" id="btn-aceptar-cookies">De acuerdo</button>
		<a class="enlace" target="_blank" rel="noopener noreferrer" href="https://josprox.com/que-son-las-cookies-son-necesarias-como-desactivarlo/">¿Qué es una cookie?</a>
	</div>
	<div class="fondo-aviso-cookies" id="fondo-aviso-cookies"></div>
    <?php
}

//Sistema de seguridad para el administrador

function secure_auth_admin($iduser,$location){
    $rol = consulta_mysqli_where("id_rol","users","id",$iduser);
    $check_user = $rol['id_rol'];
    if($check_user != 1 && $check_user != 2 && $check_user != 4){
        logout($iduser,"users");
        header("location: $location");
    }
}
//Jossito para traer el nombre de la página donde se encuentra
function nombre_de_pagina(){
    $url = explode("/", (string) $_SERVER['SCRIPT_NAME']);
    $url = array_reverse($url);
    $url = $url[0];
    return $url;
}
//Jossitos para creación, movimiento de archivos y borrador de directorio con su contenido.
//Estos Jossitos probablemente desaparezcan para agregarlos al SysNAND
function crear_archivo($directorio,$contenido_C){
    $dirname = __DIR__ . DIRECTORY_SEPARATOR . $directorio;
    $create = fopen($dirname, 'w');
    fwrite($create, "$contenido_C");
    fclose($create);
    return TRUE;
}

function copiar_archivo($archivo_original,$archivo_copiado){
    if(!@copy(__DIR__ . DIRECTORY_SEPARATOR . $archivo_original,__DIR__ . DIRECTORY_SEPARATOR . $archivo_copiado))
        {
            $errors= error_get_last();
            echo "COPY ERROR: ".$errors['type'];
            echo "<br />\n".$errors['message'];
        } else {
            return TRUE;
        }
}

function borrar_directorio($dirname) {
         //si es un directorio lo abro
         if (is_dir($dirname))
           $dir_handle = opendir($dirname);
        //si no es un directorio devuelvo false para avisar de que ha habido un error
	 if (!$dir_handle)
	      return false;
        //recorro el contenido del directorio fichero a fichero
	 while($file = readdir($dir_handle)) {
	       if ($file != "." && $file != "..") {
                   //si no es un directorio elemino el fichero con unlink()
	            if (!is_dir($dirname."/".$file))
	                 unlink($dirname."/".$file);
	            else //si es un directorio hago la llamada recursiva con el nombre del directorio
	                 borrar_directorio($dirname.'/'.$file);
	       }
	 }
	 closedir($dir_handle);
	//elimino el directorio que ya he vaciado
	 rmdir($dirname);
	 return true;
}

//Jossitos para comprobación interna de seguridad SSL/TLS a través del puerto 80 o 443

function check_http(){
    $domain = $_ENV['DOMINIO'];
    if (isset($domain) && $domain !== 'localhost' && isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        return 'https://';
    } elseif (!isset($domain) || $domain === 'localhost' || !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
        return 'http://';
    } else {
        return '';
    }
}

// Jossito para escanear directorios
function escanear_directorio($url_interno){
    $archivos = scandir(__DIR__ . DIRECTORY_SEPARATOR . $url_interno);
    $resultados = [];
    
    for ($i = 0; $i < (is_countable($archivos) ? count($archivos) : 0); $i++) { 
        if ($archivos[$i] !== "." && $archivos[$i] !== "..") {
            if (!is_dir($archivos[$i])) {
                $resultados[] = [
                    'url' => $archivos[$i],
                    'nombre' => $archivos[$i]
                ];
            } else {
                // Puedes ajustar esta parte según tus necesidades para carpetas
                $resultados[] = $archivos[$i];
            }
        }
    }
    
    // Convertir el array a JSON
    $json_resultados = json_encode($resultados);

    // Retornar el JSON
    return $json_resultados;
}


//Cron de JosSecurity

function evento_programado($task_name, $schedule, $interval) {
    $fecha = \FECHA;
    $timestamp = strtotime((string) $schedule); 
    $next_run = date("Y-m-d H:i:s", $timestamp);
    if(leer_tablas_mysql_custom("SELECT * FROM tareas WHERE funcion = '$task_name'") >=1){
        $consulta = consulta_mysqli_where("sig_fecha","tareas","funcion","'$task_name'");
        if(\FECHA >= $consulta['sig_fecha']){
            $task_name();
            // actualiza el siguiente tiempo de ejecución
            $fecha_creacion = new DateTime();
            $fecha_creacion->modify('+'.$interval);
            $fecha_final = $fecha_creacion->format('Y-m-d H:i:s');
            // actualizar el programa de tareas en la base de datos
            actualizar_datos_mysqli("tareas","`sig_fecha` = '$fecha_final'","funcion","'$task_name'");
        }
    }else{
        $task_name();
        insertar_datos_custom_mysqli("INSERT INTO tareas (funcion, sig_fecha, created_at) VALUES ('$task_name', '$next_run','$fecha')");
    }
}
//Jossito para comprobar zona horaria del cliente
class fecha_cliente{
    private $zona = \ZONA_HORARIA_CLIENTE;
    function __construct(){
        date_default_timezone_set($this->zona);
    }
    function fecha_hora(){
        return date("Y-m-d H:i:s");
    }
    function fecha(){
        return date("Y-m-d");
    }
    function hora_24(){
        return date('H:i');
    }
    function hora_12(){
        return date('h:i A');
    }
    function modificar($fecha){
        return date($fecha);
    }
    function __destruct(){
        $this->zona = $_ENV['ZONA_HORARIA'];
        date_default_timezone_set($_ENV['ZONA_HORARIA']);
    }
}

// Sistema de QR texto.
function qrcode($datos = "https://josprox.com/", $formato = "svg", $color_fondo = "rgb(103, 255, 213)", $color_plano = "rgba(0, 0, 0, 0.8)", $versionQR = 10, $escalaQR = 5, $imageBase64 = false) {
    // Comprobación de formato y configuración de encabezado
    switch($formato){
        case "png":
            $salida = [
                "Tipo" => QROutputInterface::GDIMAGE_PNG,
                "header" => 'Content-Type: image/png'
            ];
            break;
        case "svg":
            $salida = [
                "Tipo" => QROutputInterface::MARKUP_SVG,
                "header" => 'Content-Type: image/svg+xml'
            ];
            break;
        case "webp":
            $salida = [
                "Tipo" => QROutputInterface::GDIMAGE_WEBP,
                "header" => 'Content-Type: image/webp'
            ];
            break;
        case "jpg":
        case "jpeg":
            $salida = [
                "Tipo" => QROutputInterface::GDIMAGE_JPG,
                "header" => 'Content-Type: image/jpeg'
            ];
            break;
        default:
            throw new InvalidArgumentException('Formato no soportado.');
    }

    // Configuración de las opciones del QR
    $options = new QROptions([
        'version'      => $versionQR, // Versión del código QR
        'outputType'   => $salida["Tipo"], // Tipo de salida dinámico basado en el formato
        'eccLevel'     => QRCode::ECC_H, // Nivel de corrección de errores
        'scale'        => $escalaQR, // Escala del código QR
        'imageBase64'  => $imageBase64, // Opcionalmente, puedes devolver en base64 si lo prefieres
        'imageTransparent' => true,
        'bgColor'      => colorToRgb($color_fondo), // Convertir el color de fondo a formato RGB
        'fgColor'      => colorToRgb($color_plano), // Convertir el color de primer plano a formato RGB
        'drawCircularModules' => true,
        'drawLightModules' => true,
        'circleRadius' => 0.4, // Ajustar el radio de los círculos
    ]);

    // Generar el código QR
    $qrcode = (new QRCode($options))->render($datos);

    // Enviar el encabezado adecuado y mostrar el QR
    header($salida["header"]);
    echo $qrcode;
}

// Función para convertir color HEX o RGB a RGB
function colorToRgb($color) {
    if (preg_match('/^#/', $color)) {
        // Si el color comienza con '#', se asume que es HEX
        return hexToRgb($color);
    } elseif (preg_match('/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/', $color, $matches)) {
        // Si el color está en formato RGB
        return [$matches[1], $matches[2], $matches[3]];
    } elseif (preg_match('/^rgba\((\d+),\s*(\d+),\s*(\d+),\s*(\d+(\.\d+)?)\)$/', $color, $matches)) {
        // Si el color está en formato RGBA
        return [$matches[1], $matches[2], $matches[3]]; // Ignora el componente alfa
    } else {
        return [255, 255, 255]; // Color blanco por defecto si el formato es incorrecto
    }
}

// Función para convertir color HEX a RGB
function hexToRgb($hex) {
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 6) {
        list($r, $g, $b) = sscanf($hex, "%02x%02x%02x");
        return [$r, $g, $b];
    } elseif (strlen($hex) === 8) { // Soporta RGBA si se da un valor de 8 caracteres
        list($r, $g, $b, $a) = sscanf($hex, "%02x%02x%02x%02x");
        return [$r, $g, $b]; // Ignora el componente alfa
    } else {
        return [255, 255, 255]; // Color blanco por defecto si el formato es incorrecto
    }
}

//Sistema de Recaptcha

if($_ENV['RECAPTCHA'] != 1 || !isset($_ENV['RECAPTCHA'])){
    function recaptcha(){
        return true;
    }
    echo "<script>console.log('".$_ENV['NAME_APP']." tiene desactivado el sistema de recaptcha.');</script>";
}elseif($_ENV['RECAPTCHA'] == 1){

    function recaptcha(){
        $ip = $_SERVER['REMOTE_ADDR'];
        $captcha = $_POST['g-recaptcha-response'];
        $secretkey = $_ENV['RECAPTCHA_CODE_SECRET'];
    
        $respuesta_captcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");
    
        $atributos = json_decode($respuesta_captcha, TRUE, 512, JSON_THROW_ON_ERROR);
    
        if(!$atributos['success']){
            if ($_ENV['DEBUG'] != 1){
                return FALSE;
            }
        }
        if($atributos['success']){
            return TRUE;
        }
    }
    
}

//Post "salir" para permitir un logout de manera segura

if(isset($_POST['salir'])){
    logout("","users");
    header("Location: ./../panel");
}

//Sistema de plugins

if ($_ENV['PLUGINS'] != 1 || !isset($_ENV['PLUGINS'])){
    if($_ENV['DEBUG']){
        echo "<script>console.log('".$_ENV['NAME_APP']." tiene desactivado el sistema de plugins.');</script>";
    }
}elseif($_ENV['PLUGINS'] == 1){
    function all_in_one($select){
        $select = (int)$select;
        if(!file_exists(__DIR__ . DIRECTORY_SEPARATOR . "plugins/all in one/allinone.php")){
            return FALSE;
        }else{
            include_once (__DIR__ . DIRECTORY_SEPARATOR . "plugins/all in one/allinone.php");
            return allinone_zip_finish($select);
        }
    }

    function not_pay(){
        include (__DIR__ . "/plugins/dont_pay/index.php");
        return check_not_paid();
    }

    if($_ENV['MERCADO_PAGO'] == 1){
        include (__DIR__ . "/plugins/mercado_pago/sdk.php");
    }
    if(file_exists(__DIR__ . "/plugins/Visibility_Logic/Visibility_Logic.php")){
        include (__DIR__ . "/plugins/Visibility_Logic/Visibility_Logic.php");
    }
    if(isset($_ENV['TWILIO']) && $_ENV['TWILIO'] == 1){
        if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "plugins/twilio/SDK.php")){
            include (__DIR__ . DIRECTORY_SEPARATOR . "plugins/twilio/SDK.php");
        }
    }if(isset($_ENV['ONESIGNAL']) && $_ENV['ONESIGNAL'] == 1){
        if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "plugins/onesignal/SDK.php")){
            include (__DIR__ . DIRECTORY_SEPARATOR . "plugins/onesignal/SDK.php");
        }
    }
    if(isset($_ENV['HI_GOOGLE']) && $_ENV['HI_GOOGLE'] == 1){
        include (__DIR__ . DIRECTORY_SEPARATOR . "plugins/Google_client/higoogle.php");
    }
}

// Se ha integrado Gran MySQL como una herramienta completa, dejando de ser solo un plugin.
if(file_exists(__DIR__ . "/config/extension/granmysql/gran_mysql.php")){
    include (__DIR__ . "/config/extension/granmysql/gran_mysql.php");
}

// Podrás crear tus propios Jossitos en el achivo mis_jossitos.php en la carpeta config.
if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "config/mis_jossitos.php")){
    include (__DIR__ . DIRECTORY_SEPARATOR . "config/mis_jossitos.php");
}

// Uso de la configuración plugins internos cuando el sistema de plugins no funcione o se encuentre desactivado.
if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "config/not_paid.php")){
    include (__DIR__ . DIRECTORY_SEPARATOR . "config/not_paid.php");
}

// Tareas programadas.
if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "config/extension/task.php")){
    include (__DIR__ . DIRECTORY_SEPARATOR . "config/extension/task.php");
}

// SysNAND
if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "config/sistema/system_JosSecurity_config.php")){
    include (__DIR__ . DIRECTORY_SEPARATOR . "config/sistema/system_JosSecurity_config.php");
}
?>