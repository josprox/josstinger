<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../users/");
}

$iduser = $_SESSION['id_usuario'];

$row = consulta_mysqli_where("name","users","id",$iduser);

if(!isset($_GET['payment_id']) && !isset($_GET['status']) && !isset($_GET['payment_type']) && !isset($_GET['merchant_order_id'])){
    header("Location: ./");
}

$token = $_GET['token'];

$id_de_pago = $_GET['payment_id'];
$estado_de_pago = $_GET['status'];
$tipo_de_pago = $_GET['payment_type'];
$id_del_pedido = $_GET['merchant_order_id'];

$id_user_pay= $_GET['usr'];
$id_product= $_GET['prdct'];
$meses= (int)$_GET['mut'];

if(leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE token = '$token' && estado = 'Completado'") > 0){
    header("Location: ./");
}


?>

<!DOCTYPE html>
<html lang="es-MX">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $nombre_app; ?> - Escritorio</title>
        <?php head_users(); ?>
</head>
<body>
    <section class="bienvenida">
        <div class="contenedor">
            <h2 class="text-center text-shadow-black">Hola <?php echo $row['name']; ?></h2>
            <hr>
            <h3 class="text-center">Bienvenido al panel de control de <?php echo $_ENV['NAME_APP']; ?></h3>
        </div>
    </section>

    <section class="contenedor">

        <div class="flex_center">

            <div class="grid_1_auto">

                <div class="tarjeta_contenido">
                    <h1 class="text-center">El pago ha sido válido</h1>
                    <p class="text-justify">Estos son los datos de la transacción</p>
                    <ul>
                        <li>id del pago: <?php echo $id_de_pago; ?></li>
                        <li>id del pedido: <?php echo $id_del_pedido; ?></li>
                        <li>Tipo de pago: <?php echo $tipo_de_pago; ?></li>
                        <li>Estado del pago: <?php echo $estado_de_pago; ?></li>
                    </ul>


                </div>
                    
            </div>
                
        </div>
            
    </section>

    <div class="container">
        <br>

        <div class="container">
            <h2>Registrar datos de acceso para tu servicio</h2>
            <div class="card">
                <div class="card-body">

                    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST">
                        <div class="form-group">
                            <label for="username">Usuario:</label>
                            <input type="text" class="form-control" id="username" placeholder="Usuario" name="usuario">
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" class="form-control" id="password" placeholder="Contraseña"
                                name="contra">
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" class="form-control" id="email" placeholder="Correo Electrónico"
                                name="correo">
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre del Usuario:</label>
                            <input type="text" class="form-control" id="first_name" placeholder="Nombre del Usuario"
                                name="nombre">
                        </div>
                        <div class="form-group">
                            <label for="apellidos">Apellido del Usuario:</label>
                            <input type="text" class="form-control" id="last_name" placeholder="Apellido del Usuario"
                                name="apellidos">
                        </div>
                        <button type="submit" name="registrar_hestia" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
            </div>
        </div>

        <br>

        <div class="container">

            <?php 
                        
                        
                        if (isset($_POST['registrar_hestia'])) {
                        // Server credentials
                        $hst_hostname = (string)$_ENV['HST_HOSTNAME'];
                        $hst_port = (int)$_ENV['HST_PORT'];
                        $hst_username = (string)$_ENV['HST_USUARIO'];
                        $hst_password = (string)$_ENV['HST_CONTRA'];
                        $hst_returncode = 'yes';
                        $hst_command = 'v-add-user';
                        // Server credentials
                        $hst_hostname = $_ENV['HST_HOSTNAME'];
                        $hst_port = $_ENV['HST_PORT'];
                        $conexion = conect_mysqli();
                        // New Account
                        $consulta_paquetes = consulta_mysqli_custom_all("SELECT nombre FROM servicios WHERE id = $id_product;");
                        $username = mysqli_real_escape_string($conexion, $_POST['usuario']);
                        $password = mysqli_real_escape_string($conexion, $_POST['contra']);
                        $email = mysqli_real_escape_string($conexion, $_POST['correo']);
                        $package = (string)$consulta_paquetes['nombre'];
                        $first_name = mysqli_real_escape_string($conexion, $_POST['nombre']);
                        $last_name = mysqli_real_escape_string($conexion, $_POST['apellidos']);
                        mysqli_close($conexion);

                        // Prepare POST query
                        $postvars = array(
                            'user' => $hst_username,
                            'password' => $hst_password,
                            'returncode' => $hst_returncode,
                            'cmd' => $hst_command,
                            'arg1' => $username,
                            'arg2' => $password,
                            'arg3' => $email,
                            'arg4' => $package,
                            'arg5' => $first_name,
                            'arg6' => $last_name
                        );

                        // Send POST query via cURL
                        $postdata = http_build_query($postvars);
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, 'https://' . $hst_hostname . ':' . $hst_port . '/api/');
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                        curl_setopt($curl, CURLOPT_POST, true);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
                        $answer = curl_exec($curl);

                        // Check result
                        if($answer == 0) {
                            $consula = consulta_mysqli_where("id","tokens_pays","token","'$token'");
                            $id_token = $consula['id'];
                            $fecha_creacion = new DateTime();
                            $fecha_creacion->modify('+'.$meses.' months');
                            $fecha_final = $fecha_creacion->format('Y-m-d H:i:s');

                            insertar_datos_custom_mysqli("UPDATE `tokens_pays` SET `estado` = 'Completado', `id_pedido` = '$id_del_pedido', `id_pago` = '$id_de_pago', `pagado_con` = '$tipo_de_pago', `updated_at` = '$fecha' WHERE `tokens_pays`.`token` = '$token'");

                            eliminar_datos_custom_mysqli("DELETE FROM tokens_pays WHERE id_user = $id_user_pay && estado = 'Cancelado'");

                            insertar_datos_custom_mysqli("UPDATE `tokens_pays` SET `expiracion` = '$fecha_final', `usuario` = '$username', `correo` = '$email' WHERE `tokens_pays`.`id` = $id_token");
                            ?>
                            <script type="text/javascript">
                                window.location.href = "./";
                            </script>
                            <?php
                        }elseif($answer == 4){
                            echo "
                            <script>
                            Swal.fire(
                            'Falló',
                            'Ya existe un usuario con ese nombre.',
                            'error'
                            )
                        </script>
                            ";
                        } else {
                            echo "Query returned error code: " .$answer. "\n";
                        }

                    }

                ?>



        </div>

    </div>
        
    <?php footer_users(); ?>
    
</body>
</html>