<?php

include (__DIR__ . "/../jossecurity.php");

if (isset($_SESSION['id_usuario'])) {
    $id_user_session = $_SESSION['id_usuario'];
    cookie_session($id_user_session,"./admin/","./users/");
}

login_cookie("users"); 

?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nombre_app; ?> - Iniciar sesión</title>
    <?php head(); ?>
</head>
<body>
    <div class="contenedor">
    <?php
        if($_ENV['DEBUG'] == 1){?>

        <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>Advertencia</strong> Actualmente tienes el modo DEBUG activado, si estás en modo prueba no hay de que preocuparse, si estás en un entorno de producción favor de desactivar el modo DEBUG en el panel de administración o modificando el archivo .env.
        </div>

        <div class="alert alert-primary" role="alert">
          <h4 class="alert-heading"><?php echo $nombre_app; ?></h4>
          <p>Sistema de control de datos. Versión: <?php echo $version_app; ?>.</p>
          <hr>
          <p class="mb-0" align="justify">Muchas gracias por instalar <?php echo $nombre_app; ?>, para poder usar la librería deberas incluir al archivo jossecurity.php en tus archivos principales del proyecto.</p>
        </div>

        <?php
        }
        ?>

        <?php
        if($_ENV['DEBUG'] != 1){?>

            <div class="alert alert-success" role="alert">
                <strong><?php echo $nombre_app; ?></strong> El sistema se encuentra funcionando.
            </div>
            

        <?php
        }
    if(isset($_GET['check_user'])){
        $conexion = conect_mysqli();
        $check = mysqli_real_escape_string($conexion, (string) $_GET['check_user']);
        if(leer_tablas_mysql_custom("SELECT id_user FROM check_users WHERE check_users.url = '$check' && check_users.accion = 'check_user'") >=1){
            $checking = consulta_mysqli_where("id, id_user, accion","check_users","check_users.url","'$check'");
            $id_user = $checking['id_user'];
            if($checking['accion'] == "check_user"){
                if(actualizar_datos_mysqli("users","`checked_status` = 'TRUE'","id",$id_user) == TRUE){
                    eliminar_datos_con_where("check_users","id_user",$id_user);?>
                    <script>
                        Swal.fire(
                        'Completado',
                        'Se ha verificado tu cuenta de manera correcta.',
                        'success'
                        )
                    </script>
                    <?php
                    header("location: panel");
                }
            }
        }else{
            ?>
            <script>
                Swal.fire(
                'Oh no!',
                'No se ha podido verificar este token, favor de intentar acceder a tu cuenta para generar otro token.',
                'error'
                )
            </script>
            <?php
            header("location: panel");
        }
    }elseif (isset($_POST["ingresar"])){
        if(recaptcha() == TRUE){
            $check = logins($_POST['txtCorreo'],$_POST['txtPassword'],"users","./admin/","./users/");
            if($check == false){
                ?>
                <script>
                    Swal.fire(
                    'Falló',
                    'La contraseña es incorrecta.',
                    'error'
                    )
                </script>
                <?php
                header("refresh:1;");
            }
        }else{
            ?>
            <script>
                Swal.fire(
                'Falló',
                'No ingresaste el recaptcha.',
                'error'
                )
            </script>
            <?php
            header("refresh:1;");
        }
    }elseif(isset($_POST['reset'])){
        $correo = $_POST['txtCorreo'];
        if(recaptcha() == TRUE){
            if(leer_tablas_mysql_custom("SELECT users.name FROM users WHERE users.email = '$correo'") >=1 ){
                $consulta = consulta_mysqli_where("name, last_ip, phone","users","email","'$correo'");
                $ip_acceso_completado = (string)$consulta['last_ip'];
                $ip_usuario = (string)$_SERVER['PHP_SELF'];
                ?>
                <div class="contenedor_blanco">
                    <center><h2>Recupera tu contraseña</h2><p>Hola <?php echo $consulta['name'] ?>, estás a punto de restaurar tu contraseña, a continuación te daremos opciones de cómo poder restaurar tu contraseña.</p><p>Tu dirección ip es la siguiente: <?php echo $_SERVER['REMOTE_ADDR']; ?></p></center>
                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                        <input type="hidden" name="correo" value="<?php echo $correo; ?>">
                        <?php
                        if($ip_acceso_completado == $ip_usuario){
                            ?>
                            <p>¡Buenas noticias!</p>
                            <p>Anteriormente haz iniciado sesión desde esta dirección IP, a continuación ingresa tu nueva contraseña</p>
                            <div class="grid_2_auto">
                                <div class="mb-3 contenedor">
                                  <label for="contra" class="form-label">Contraseña</label>
                                  <input type="password"
                                    class="form-control" name="contra" id="contra" aria-describedby="contra" placeholder="Pon tu nueva contraseña">
                                  <small id="contra" class="form-text text-muted">Pon la contraseña que usarás.</small>
                                </div>
                                <div class="mb-3 contenedor">
                                  <label for="new_contra" class="form-label">Repita la contraseña</label>
                                  <input type="password"
                                    class="form-control" name="new_contra" id="new_contra" aria-describedby="new_contra" placeholder="Repite la contraseña">
                                  <small id="new_contra" class="form-text text-muted">Favor de repetir la contraseña para confirmar su selección.</small>
                                </div>
                            </div>
                            <div class="flex_center">
                                <button type="submit" name="contra_update_ip" class="btn btn-primary">Actualizar contraseña</button>
                            </div>
                            <?php
                        }else{
                            ?>
                            <center>
                            <div class="mb-3">
                                <label for="contra_update_select" class="form-label">Selecciona una opción:</label>
                                <select class="form-select form-select-sm" name="contra_update_select" id="contra_update_select">
                                    <option selected>Selecciona alguna opción para restaurar tu contraseña.</option>
                                    <option value="1">Correo electrónico</option>
                                    <?php
                                    if (isset($_ENV['TWILIO']) && $_ENV['TWILIO'] == 1 && $consulta['phone'] != NULL){
                                        ?>
                                        <option value="2">Restaurar contraseña por sms</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" name="contra_update" class="btn btn-primary">Actualizar</button>
                            </center>
                            <?php
                        }
                        ?>
                    </form>
                </div>
                <?php
            }else{
                ?>
                <script>
                    Swal.fire(
                    'Falló',
                    'El correo que insertaste no existe, favor de verificarlo.',
                    'error'
                    )
                </script>
                <?php
                header("refresh:1;");
            }
        }else{
            ?>
            <script>
                Swal.fire(
                'Falló',
                'No ingresaste el recaptcha.',
                'error'
                )
            </script>
            <?php
            header("refresh:1;");
        }
    }elseif(isset($_POST['contra_update'])){
        $conexion = conect_mysqli();
        $opcion = mysqli_real_escape_string($conexion, (string) $_POST['contra_update_select']);
        $conexion ->close();
        if($opcion == 1){
            if(resetear_contra($_POST['correo']) == TRUE){
                ?>
                <script>
                    Swal.fire(
                    'Éxito',
                    'Se ha enviado un correo para restablecer tu contraseña.',
                    'success'
                    )
                </script>
                <?php
                header("refresh:1;");
            }else{
                ?>
                <script>
                    Swal.fire(
                    'Falló',
                    'No funcionó, favor de volverlo a intentar.',
                    'success'
                    )
                </script>
                <?php
                header("refresh:1;");
            }
        }elseif($opcion == 2){
            if(resetear_contra_sms($_POST['correo']) == TRUE){
                ?>
                <script>
                    Swal.fire(
                    'Éxito',
                    'Se ha enviado un sms para restablecer tu contraseña.',
                    'success'
                    )
                </script>
                <?php
                header("refresh:1;");
            }else{
                ?>
                <script>
                    Swal.fire(
                    'Falló',
                    'No funcionó, favor de volverlo a intentar una vez más, sino funciona intente con otro metodo de recuperación.',
                    'success'
                    )
                </script>
                <?php
                header("refresh:1;");
            }
        }
    }elseif(isset($_POST['contra_update_ip'])){
        $conexion = conect_mysqli();
        $correo = mysqli_real_escape_string($conexion, (string) $_POST['correo']);
        $contra = mysqli_real_escape_string($conexion, (string) $_POST['contra']);
        $new_contra = mysqli_real_escape_string($conexion, (string) $_POST['new_contra']);
        $conexion -> close();
        if($contra == $new_contra){
            $consulta_id = consulta_mysqli_where("id","users","email","'$correo'");
            if(actualizar_contra($consulta_id['id'],$contra) == TRUE){
                ?>
                <script>
                    Swal.fire(
                    'Completado',
                    'La contraseña se acaba de actualizar de manera correcta.',
                    'success'
                    )
                </script>
                <?php
                header("refresh:1;");
            }
        }else{
            ?>
            <script>
                Swal.fire(
                'Falló',
                'Las contraseñas no se parecen, favor de volverlo a intentar.',
                'error'
                )
            </script>
            <?php
            header("refresh:1;");
        }
    }elseif(isset($_POST['registrar'])){
        if(recaptcha() == TRUE){
            $conexion = conect_mysqli();
            $contra = mysqli_real_escape_string($conexion, (string) $_POST['txtPassword']);
            $contra_repeat = mysqli_real_escape_string($conexion, (string) $_POST['txtPassword_repeat']);
            $conexion -> close();
            if($contra == $contra_repeat){
                echo registro("users",$_POST['txtName'],$_POST['txtCorreo'],$_POST['txtPassword'],6);
                header("refresh:1;");
            }else{
                ?>
                <script>
                    Swal.fire(
                    'Falló',
                    'Las contraseñas no se parecen, favor de volverlo a intentar.',
                    'error'
                    )
                </script>
                <?php
                header("refresh:1;");
            }
        }else{
            ?>
            <script>
                Swal.fire(
                'Falló',
                'No ingresaste el recaptcha.',
                'error'
                )
            </script>
            <?php
            header("refresh:1;");
        }
    }elseif(isset($_GET['cambiar_contra'])){
        $conexion = conect_mysqli();
        $token = mysqli_real_escape_string($conexion, (string) $_GET['cambiar_contra']);
        $conexion -> close();
        if(leer_tablas_mysql_custom("SELECT id_user FROM check_users WHERE url = '$token' && accion = 'cambiar_contra'") >=1){
            $consulta = consulta_mysqli_where("id_user","check_users","url","'$token'");
            $consulta_id = consulta_mysqli_where("name","users","id",$consulta['id_user']);
            if(isset($_POST['actualizar_contra'])){
                $conexion = conect_mysqli();
                $token = mysqli_real_escape_string($conexion, (string) $_GET['cambiar_contra']);
                $contra = mysqli_real_escape_string($conexion, (string) $_POST['contra']);
                $repit_contra = mysqli_real_escape_string($conexion, (string) $_POST['repit_contra']);
                $conexion -> close();
                if(eliminar_datos_con_where("check_users","url","'$token'") == TRUE){
                    if($contra == $repit_contra){
                        if(actualizar_contra($consulta['id_user'],$contra) == TRUE){
                            ?>
                            <script>
                                Swal.fire(
                                'Completado',
                                'La contraseña se ha actualizado correctamente.',
                                'success'
                                )
                            </script>
                            <?php
                            header("refresh:1;");
                        }else{
                            ?>
                            <script>
                                Swal.fire(
                                'Falló',
                                'La contraseña no se pudo actualizar, favor de volver a intentarlo.',
                                'success'
                                )
                            </script>
                            <?php
                            header("refresh:1;");
                        }
                    }else{
                        ?>
                        <script>
                            Swal.fire(
                            'Falló',
                            'La contraseña no se parece, favor de volver a intentarlo.',
                            'success'
                            )
                        </script>
                        <?php
                        header("refresh:1;");
                    }
                }
            }
        }else{
            header("Location: panel");
        }
        ?>
        <div class="contenedor_blanco">
            <center><h1>Cambio de contraseña</h1></center>
            <p>Un gusto volver a verte <?php echo $consulta_id['name']; ?>, en unos momentos podrás restaurar tu contraseña, a continuación le pediremos que llene la nueva solicitud.</p>
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

                <div class="grid_2_auto">

                    <div class="mb-3 contenedor">
                      <label for="contra" class="form-label">Contraseña </label>
                      <input type="password"
                        class="form-control" name="contra" id="contra" aria-describedby="contra" placeholder="Pon tu nueva contraseña">
                      <small id="contra" class="form-text text-muted">Inserta la nueva contraseña.</small>
                    </div>

                    <div class="mb-3 contenedor">
                      <label for="repit_contra" class="form-label">Repite la contraseña</label>
                      <input type="password"
                        class="form-control" name="repit_contra" id="repit_contra" aria-describedby="repit_contra" placeholder="repite la contraseña">
                      <small id="repit_contra" class="form-text text-muted">Vuelve a insertar la contraseña para poder verificarla.</small>
                    </div>

                </div>

                <div class="flex_center">
                    <button type="submit" name="actualizar_contra" class="btn btn-success">Actualizar contraseña</button>
                </div>

            </form>
        </div>
        <?php
    }else{
        ?>
    <div class="flex_center">
        <div class="login_register">
            <div class="form">
                <div class="check">
                    <button class="boton_login" onclick="iniciarForm();">Iniciar sesión</button>
                    <button class="boton_register" onclick="registerForm();">Registrarme</button>
                    <button class="boton_reset" onclick="resetForm();">Olvidé mi contraseña</button>
                </div>

                <div id="login">
                    <h1 class="text-center">Iniciar sesión</h1>
                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

                        <div class="forms">

                            <div class="grid_1_auto">
                                <label for="">Correo</label>
                                <input type="email" name="txtCorreo" placeholder="Por favor pon tu correo" required>
                            </div>
                            <div class="grid_1_auto">
                                <label for="">contraseña</label>
                                <input type="password" name="txtPassword" placeholder="Por favor pon tu contraseña" required>
                            </div>
                            <div class="grid_1_auto">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="cookie" type="checkbox" id="flexSwitchCheckDefault">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Desea tener la sesión abierta</label>
                                  </div>
                            </div>
                            <div class="flex_center">
                                <div class="mb-3">
                                    <div class="g-recaptcha" data-sitekey="<?php echo $_ENV['RECAPTCHA_CODE_PUBLIC']; ?>"></div>
                                </div>
                            </div>
                            <div class="flex_center">
                                <div class="grid_1_auto">
                                    <button type="submit" name="ingresar" class="btn btn-success">Iniciar sesión</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <div id="register">
                    <h1 class="text-center">Regístrate</h1>
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

                            <div class="forms">

                                <div class="grid_1_auto">
                                    <label for="">¿Cúál es tu nombre completo?</label>
                                    <input type="text" name="txtName" placeholder="Por favor pon tu nombre" required>
                                </div>
                                <div class="grid_1_auto">
                                    <label for="">¿Cuál es tu correo?</label>
                                    <input type="email" name="txtCorreo" placeholder="Por favor pon tu correo" required>
                                </div>
                                <div class="grid_1_auto">
                                    <label for="">Crea una contraseña</label>
                                    <input type="password" name="txtPassword" placeholder="Por favor pon tu contraseña" required>
                                </div>
                                <div class="grid_1_auto">
                                    <label for="">Repite la contraseña</label>
                                    <input type="password" name="txtPassword_repeat" placeholder="Por favor pon tu contraseña" required>
                                </div>
                                <div class="flex_center">
                                    <div class="mb-3">
                                        <div class="g-recaptcha" data-sitekey="<?php echo $_ENV['RECAPTCHA_CODE_PUBLIC']; ?>"></div>
                                    </div>
                                </div>
                                <div class="flex_center">
                                    <div class="grid_1_auto">
                                        <button type="submit" name="registrar" class="btn btn-success">Registrarme</button>
                                    </div>
                                </div>

                                </button>

                            </div>
                        </form>
                </div>

                <div id="reset">
                    <h1 class="text-center">Olvidé mi contraseña</h1>
                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

                        <div class="forms">
                            
                            <div class="grid_1_auto">
                                <label for="">Correo</label>
                                <input type="email" class="form-control" name="txtCorreo" placeholder="Por favor pon tu correo">
                            </div>
                            <div class="flex_center">
                                <div class="mb-3">
                                    <div class="g-recaptcha" data-sitekey="<?php echo $_ENV['RECAPTCHA_CODE_PUBLIC']; ?>"></div>
                                </div>
                            </div>
                            <div class="flex_center">
                                <div class="grid_1_auto">
                                    <button type="submit" name="reset" class="btn btn-success">Restaurar</button>
                                </div>
                            </div>

                            </button>

                        </div>
                    </form>
                </div>

            </div>
            <div class="presentacion">
                <img src="../resourses/img/logo transparente/default.png" alt="">
                <div class="flex_start">
                    <center>
                        <h1 class="text-shadow-black" style="color: #fff;text-align:center;">Seguridad a tu alcance</h1>
                    </center>
                    <p class="text-justify text-shadow-black" style="color: #fff;">
                    Este sitio ha sido creado con la tecnología de JosSecurity, seguridad a tu alcance. <br> Un proyecto de JOSPROX.
                    </p>
                </div>
            </div>
        </div>
    </div>
        <?php
    }
    ?>
        
    </div>

    <?php footer(); ?>

    <script>
        var alertList = document.querySelectorAll('.alert');
        alertList.forEach(function (alert) {
        new bootstrap.Alert(alert)
        })
    </script>

    <script>
        function resetForm(){
            document.getElementById('reset').style.display = 'block';
            document.getElementById('login').style.display = 'none';
            document.getElementById('register').style.display = 'none';
        }
        function registerForm(){
            document.getElementById('reset').style.display = 'none';
            document.getElementById('login').style.display = 'none';
            document.getElementById('register').style.display = 'block';
        }
        function iniciarForm(){
            document.getElementById('reset').style.display = 'none';
            document.getElementById('register').style.display = 'none';
            document.getElementById('login').style.display = 'block';
        }
    </script>
    
</body>
</html>