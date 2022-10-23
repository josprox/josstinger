<?php

include (__DIR__ . "/../jossecurity.php");

if (isset($_SESSION['id_usuario'])) {
    header("Location: ./admin/");
}

login_cookie("users");

if (file_exists("./../installer.php")){
    unlink('./../installer.php');
}

?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nombre_app; ?> - Iniciar sesión</title>
    <?php echo head(); ?>
</head>
<body>
    <?php
    if (isset($_POST["ingresar"])){
        if(recaptcha() == TRUE){
            logins($_POST['txtCorreo'],$_POST['txtPassword'],"users","./admin/","./users/");
        }
        if (recaptcha() == FALSE){
            echo "
            <script>
                Swal.fire(
                'Falló',
                'El inicio de sesión ha fallado, favor de volver a intentarlo.',
                'error'
                )
            </script>";
        }
    }
    if(isset($_POST['reset'])){
        if(recaptcha() == TRUE){
            if(resetear_contra($_POST['txtCorreo']) == TRUE){
                echo "<script>
                        Swal.fire(
                        'Éxito',
                        'Se ha enviado un correo con tu nueva contraseña.',
                        'success'
                        )
                    </script>";
            }else{
                echo "<script>
                        Swal.fire(
                        'Falló',
                        'No funcionó, favor de volverlo a intentar.',
                        'success'
                        )
                    </script>";
            }
        }
    }
    if(isset($_POST['registrar'])){
        if(recaptcha() == TRUE){
            echo registro("users",$_POST['txtName'],$_POST['txtCorreo'],$_POST['txtPassword'],6);
        }
    }
    ?>

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
                        <form action="" method="post">

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

                                </button>

                            </div>
                        </form>
                    </div>

                    <div id="register">
                        <h1 class="text-center">Regístrate</h1>
                            <form action="" method="post">

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
                        <form action="" method="post">

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
                                        <button type="submit" name="reset" class="btn btn-success">Iniciar sesión</button>
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
    </div>

    <?php echo footer(); ?>

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