<?php

// JosSecurity, la mejor seguridad al alcance de tus manos.

// NO ELIMINES las lineas 6 a 9 por seguridad, si tu borras estas linea dejará de funcionar JosSecurity.
require_once (__DIR__ . '/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
session_start();

//Configuración por defecto de JosSecurity
date_default_timezone_set($_ENV['ZONA_HORARIA']);
$fecha = date("Y-m-d H:i:s");
$nombre_app = (string)$_ENV['NAME_APP'];
$version_app = (string)$_ENV['VERSION'];

$host = (string)$_ENV['HOST'];
$user = (string)$_ENV['USUARIO'];
$pass = (string)$_ENV['CONTRA'];
$DB = (string)$_ENV['BASE_DE_DATOS'];
$puerto = (string)$_ENV['PUERTO'];

if ($_ENV['DEBUG'] == 1) {
    echo "<script>console.log('".$nombre_app." está funcionando.');</script>";
}

function head(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." Head está activo.');</script>";
    }
    return include (__DIR__ . "/config/general_rutes/head/head.php");
}

function head_users(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." Head admin está activo.');</script>";
    }
    return include (__DIR__ . "/config/general_rutes/head/head_users.php");
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
    return include (__DIR__ . "/routes/navbar/navbar.php");
}

function navbar_users(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." navbar users está activo.');</script>";
    }
    return include (__DIR__ . "/routes/navbar/navbar_users.php");
}

function navbar_admin(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." navbar admin está activo.');</script>";
    }
    return include (__DIR__ . "/routes/navbar/navbar_admin.php");
}

function footer(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." footer está activo.');</script>";
    }
    return include (__DIR__ . "/config/general_rutes/footer/footer.php");
}

function footer_users(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." footer admin está activo.');</script>";
    }
    return include (__DIR__ . "/config/general_rutes/footer/footer_admin.php");
}

function footer_admin(){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('".$_ENV['NAME_APP']." footer admin está activo.');</script>";
    }
    return include (__DIR__ . "/config/general_rutes/footer/footer_admin.php");
}

// JosSecurity

function edit_file($titulo,$directorio){
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
    echo '<h1 align="center">'.$titulo.'</h1>';
    echo '<form action="" method="post">';
    echo '<div class="mb-3">';
    echo "<textarea class='form-control' name='contenido' rows='15'>$contenido</textarea>";
    echo '</div>';
    echo "<center><input type='submit' class='btn btn-success' name='enviar' value='Guardar archivo'></center>";
    echo "</form>";
}

if ($_ENV['CONECT_DATABASE'] == 1){

    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('Se ha activado la función para usar la base de datos.');</script>";
    }


    if($_ENV['CONECT_MYSQLI'] == 1){

        function conect_mysqli(){
            global $host,$user,$pass,$DB,$puerto;
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
        
        }

    }
    if($_ENV['CONECT_MYSQLI'] != 1){
        if ($_ENV['DEBUG'] == 1){
            echo "<script>console.log('La conexión mysqli está desactivada.');</script>";
        }
    }

    if($_ENV['CONECT_MYSQL'] == 1){

        function conect_mysql(){

            global $host,$user,$pass,$DB,$puerto;
        
            try {
                $pdo = new PDO('mysql:host='.$host.';port='.$puerto.';dbname='.$DB.'', $user, $pass);
                //echo "conectado";
            } catch (PDOException $e) {
                print "¡Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        
            if($pdo == TRUE){
                if ($_ENV['DEBUG'] == 1){
                    echo "<script>console.log('La conexión mysql ha funcionado.');</script>";
                }
            }else{
                if ($_ENV['DEBUG'] == 1){
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

    if ($_ENV['CONECT_POSTGRESQL'] == 1 OR $_ENV['CONECT_POSTGRESQL_PDO'] == 1){
        include (__DIR__ . "/config/extension/postgresql.php");
    }

}else{
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('Se ha desactivado el uso de bases de datos.');</script>";
    }
}

function logins($correo,$contra,$tabla,$localizacion_admin,$localizacion_users){
    $conexion = conect_mysqli();
    $tabla = mysqli_real_escape_string($conexion, (string) $tabla);
    $correo = mysqli_real_escape_string($conexion, (string) $correo);
    mysqli_close($conexion);
    if(leer_tablas_mysql_custom("SELECT id FROM $tabla WHERE email = '$correo'")>= 1){
        $consulta = consulta_mysqli_where("id_rol","$tabla","email","'$correo'");
        $resultado = $consulta['id_rol'];
        if($resultado == 1 OR $resultado == 2 OR $resultado == 4){
            login_admin($correo,$contra,"$tabla","$localizacion_admin");
        }elseif($resultado != 1 && $resultado != 2 && $resultado != 4){
            login($correo,$contra,$tabla,$localizacion_users);
        }
    }
}

function login($login_email,$login_password,$table_DB,$location){

    global $nombre_app, $fecha;

    $conexion = conect_mysqli();
        $table = mysqli_real_escape_string($conexion, (string) $table_DB);
        $usuario = mysqli_real_escape_string($conexion, (string) $login_email);
        $password = mysqli_real_escape_string($conexion, (string) $login_password);
        $ip = $_SERVER['REMOTE_ADDR'];
        if(isset($_POST['cookie'])){
            $cookies = TRUE;
        }else{
            $cookies = FALSE;
        }
        
        $sql = "SELECT id, name, password FROM $table WHERE email = '$usuario'";
        $resultado = $conexion->query($sql);
        $rows = $resultado->num_rows;
        if ($rows > 0) {
            $row = $resultado->fetch_assoc();
            $password_encriptada = $row['password'];
            $id = $row['id'];
            if(password_verify($password,(string) $password_encriptada) == TRUE){

                $_SESSION['id_usuario'] = $row['id'];

                if ($cookies == TRUE){
                    //Cookie de usuario y contraseña
                    setcookie("COOKIE_INDEFINED_SESSION", TRUE, ['expires' => time()+$_ENV['COOKIE_SESSION'], 'path' => "/"]);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[user]", $usuario, ['expires' => time()+$_ENV['COOKIE_SESSION'], 'path' => "/"]);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[pass]", $password, ['expires' => time()+$_ENV['COOKIE_SESSION'], 'path' => "/"]);
                }
                

                actualizar_datos_mysqli("users","`last_ip` = '$ip'","id",$id);

                mysqli_close($conexion);

                $cuerpo_de_correo = "<div><p align='justify'>Te informamos que hemos recibido un inicio de sesión desde ". $nombre_app .", sino fuiste tú te recomendamos que cambies tu contraseña lo más pronto posible.😊</p></div><div><p>La dirección ip donde se ingresó fue: ".$ip."</p><p>Accedió el día: ".$fecha."</p></div>";

                if(mail_smtp_v1_3($row['name'],"Haz iniciado sesión",$cuerpo_de_correo,$usuario) == TRUE){
                    header("Location: $location");
                }


                }else{
                    mysqli_close($conexion);
                }
            }
        else{
        mysqli_close($conexion);
        }
            
}

function login_admin($login_email,$login_password,$table_DB,$location){

    $conexion = conect_mysqli();
    global $nombre_app ,$fecha;
        $table = mysqli_real_escape_string($conexion, (string) $table_DB);
        $usuario = mysqli_real_escape_string($conexion, (string) $login_email);
        $password = mysqli_real_escape_string($conexion, (string) $login_password);
        $ip = $_SERVER['REMOTE_ADDR'];
        if(isset($_POST['cookie'])){
            $cookies = TRUE;
        }else{
            $cookies = FALSE;
        }
    
        
        $sql = "SELECT id, name, password, id_rol FROM $table WHERE email = '$usuario'";
        $resultado = $conexion->query($sql);
        $rows = $resultado->num_rows;
        if ($rows > 0) {
            $row = $resultado->fetch_assoc();
            $password_encriptada = (string)$row['password'];
            $rol = $row['id_rol'];
            $id = $row['id'];
            if($rol == 1 OR $rol == 2 OR $rol == 4){

                if(password_verify($password,$password_encriptada) == TRUE){
    
                    $_SESSION['id_usuario'] = $row['id'];
                    
                    if ($cookies == TRUE){
                        //Cookie de usuario y contraseña
                        setcookie("COOKIE_INDEFINED_SESSION", TRUE, ['expires' => time()+$_ENV['COOKIE_SESSION'], 'path' => "/"]);
                        setcookie("COOKIE_DATA_INDEFINED_SESSION[user]", $usuario, ['expires' => time()+$_ENV['COOKIE_SESSION'], 'path' => "/"]);
                        setcookie("COOKIE_DATA_INDEFINED_SESSION[pass]", $password, ['expires' => time()+$_ENV['COOKIE_SESSION'], 'path' => "/"]);
                    }

                    actualizar_datos_mysqli("users","`last_ip` = '$ip'","id",$id);
    
                    mysqli_close($conexion);

                    $cuerpo_de_correo = "<div><p align='justify'>Te informamos que hemos recibido un inicio de sesión desde ". $nombre_app .", sino fuiste tú te recomendamos que cambies tu contraseña lo más pronto posible.😊</p></div><div><p>La dirección ip donde se ingresó fue: ".$ip."</p><p>Accedió el día: ".$fecha."</p></div>";

                    if(mail_smtp_v1_3($row['name'],"Haz iniciado sesión",$cuerpo_de_correo,$usuario) == TRUE){
                        header("Location: $location");
                    }
    
                    }else{
                        mysqli_close($conexion);
                    }
            }
            }
        else{
        mysqli_close($conexion);
        }
            
}

function cookie_session($sesion,$localizacion_admin,$localizacion_users){
    $consulta = consulta_mysqli_where("id_rol","users","id",$sesion);
    $resultado = $consulta["id_rol"];
    if ($resultado == 1 OR $resultado == 2 OR $resultado == 4){
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

function registro($table_db,$name_user,$email_user,$contra_user,$rol_user){
    global $fecha;
    $conexion = conect_mysqli();
    $nombre = mysqli_real_escape_string($conexion, (string) $name_user);
    $email = mysqli_real_escape_string($conexion, (string) $email_user);
	$password = mysqli_real_escape_string($conexion, (string) $contra_user);
	$password_encriptada = password_hash($password,PASSWORD_BCRYPT,["cost"=>10]);
	$rol = mysqli_real_escape_string($conexion,(string) $rol_user);
    $rol = (int)$rol;


    $sql_check = "SELECT id FROM $table_db WHERE email = '$email'";
    $sql_rest = $conexion->query($sql_check);
    $filas = $sql_rest -> num_rows;
    mysqli_close($conexion);

    if ($filas <= 0) {
        global $nombre_app;
        insertar_datos_clasic_mysqli($table_db,"name, email, password, id_rol, created_at, updated_at","'$nombre', '$email', '$password_encriptada', '$rol', '$fecha', NULL");
        $cuerpo_de_correo = "<div><p align='justify'>Te haz registrado de manera correcta en ". $nombre_app .", esperamos sea de tu agrado.😊</p></div><div><p>Bienvenido $nombre</p></div>";

        if(mail_smtp_v1_3($nombre,"Su registro ha sido exitoso!!",$cuerpo_de_correo,$email) == TRUE){

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

function generar_llave_alteratorio($caracteres){
    $key = "";
    $pattern = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    $max = strlen($pattern)-1;
    for($i = 0; $i < $caracteres; $i++){
        $key .= substr($pattern, random_int(0,$max), 1);
    }
    return $key;
}

function resetear_contra($correo){
    global $fecha;
    $conexion = conect_mysqli();
    $key = generar_llave_alteratorio(16);
    $password_encriptada = password_hash((string) $key,PASSWORD_BCRYPT,["cost"=>10]);
    $insert = "UPDATE `users` SET `password` = '$password_encriptada', `updated_at` = '$fecha' WHERE `users`.`email` = '$correo'";
    $conexion -> query($insert);

    $row = consulta_mysqli_where("name","users","email","'$correo'");

    $name = $row['name'];

    if($_ENV['SMTP_ACTIVE'] == 1){
        include (__DIR__ . "/config/correo/correo_reset_password.php");
        mysqli_close($conexion);
        return TRUE;
    }
    if($_ENV['SMTP_ACTIVE'] != 1){
        echo "<p>No puedes enviar correos porque no está activado en el sistema.</p>";
        mysqli_close($conexion);
        return FALSE;
    }
}

function logout($id,$table_DB){

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

function mail_smtp_v1_3($nombre,$asunto,$contenido,$correo){
    if($_ENV['SMTP_ACTIVE'] == 1){
        include (__DIR__ . "/config/correo/correo.php");
        return TRUE;
    }elseif($_ENV['SMTP_ACTIVE'] != 1){
        return FALSE;
    }
}

function mail_smtp_v1_3_recibir($nombre,$asunto,$contenido,$correo){
    if($_ENV['SMTP_ACTIVE'] == 1){
        include (__DIR__ . "/config/correo/correo_recibir.php");
        return TRUE;
    }elseif($_ENV['SMTP_ACTIVE'] != 1){
        return FALSE;
    }
}

function mail_smtp_v1_3_check($correo){
    if($_ENV['SMTP_ACTIVE'] == 1){
        include (__DIR__ . "/config/correo/correo_check.php");
        return TRUE;
    }elseif($_ENV['SMTP_ACTIVE'] != 1){
        return FALSE;
    }
}

function consulta_mysqli($select_db,$table_db,$custom,$sentence,$data,$compare,$inner){
    $conexion = conect_mysqli();
    if ($sentence == "clasic"){
        $sql = "SELECT $select_db FROM $table_db";
        $resultado = $conexion->query($sql);
        $fetch = $resultado->fetch_assoc();
        mysqli_close($conexion);
        return $fetch;
    }elseif($sentence == "where"){
        $sql = "SELECT $select_db FROM $table_db $custom WHERE $data = $compare";
        $resultado = $conexion->query($sql);
        $fetch = $resultado->fetch_assoc();
        mysqli_close($conexion);
        return $fetch;
    }elseif($sentence == "innerjoin"){
        $sql = "SELECT $select_db FROM $table_db INNER JOIN $inner ON $compare = $data $custom";
        $resultado = $conexion->query($sql);
        $fetch = $resultado->fetch_assoc();
        mysqli_close($conexion);
        return $fetch;
    }
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
    $conexion -> query($sql);
    mysqli_close($conexion);
}

function insertar_datos_custom_mysqli($codigo_sql){
    $conexion = conect_mysqli();
    $sql = "$codigo_sql";
    $conexion -> query($sql);
    mysqli_close($conexion);
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

    $conexion -> query($sql);

    mysqli_close($conexion);
}

function actualizar_datos_mysqli($tabla,$edicion,$where,$dato){
    global $fecha;
    $miconexion = conect_mysqli();
    $sql = "UPDATE `$tabla` SET $edicion, `updated_at` = '$fecha' WHERE `$tabla`.`$where` = $dato";
    $miconexion -> query($sql);
    $miconexion -> close();

}

function arreglo_consulta($code){

    $conexion = conect_mysql();
    $sql = "$code";
    $query = $conexion->query($sql);
    $conexion = null;
    return $query;

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

function reproductor_video($url){
    echo '<video class="fm-video video-js vjs-16-9 vjs-big-play-centered" style="margin-top: 12px; margin-bottom: 12px;" data-setup="{}" controls id="form-video">
        <source src="'.$url.'" type="video/mp4">
    </video>';
}

function secure_auth_admin($iduser,$location){
    $rol = consulta_mysqli_where("id_rol","users","id",$iduser);
    $check_user = $rol['id_rol'];
    if($check_user != 1 && $check_user != 2 && $check_user != 4){
        logout($iduser,"users");
        header("location: $location");
    }
}

function nombre_de_pagina(){
    $url = explode("/", (string) $_SERVER['SCRIPT_NAME']);
    $url = array_reverse($url);
    $url = $url[0];
    return $url;
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

if($_ENV['RECAPTCHA'] == 1){

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

if(isset($_POST['salir'])){
    logout($iduser,"users");
    header("Location: ./../panel");
}

if ($_ENV['PLUGINS'] == 1){
    function all_in_one($select){
        $select = (int)$select;
        include (__DIR__ . "/plugins/all in one/allinone.php");
        return allinone_zip_finish($select);
    }
    function not_pay(){
        include (__DIR__ . "/plugins/dont_pay/index.php");
        return check_not_paid();
    }
    if($_ENV['MERCADO_PAGO'] == 1){
        include (__DIR__ . "/plugins/mercado_pago/sdk.php");
    }

}

// Podrás crear tus propios Jossitos en el achivo mis_jossitos.php en la carpeta config.

include (__DIR__ . "/config/mis_jossitos.php");

// Uso de la configuración plugins internos cuando el sistema de plugins no funcione o se encuentre desactivado.
include (__DIR__ . "/config/not_paid.php");

?>
