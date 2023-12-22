<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../users/");
}

$iduser = $_SESSION['id_usuario'];

$consulta = new GranMySQL();
$consulta -> seleccion = "name, email";
$consulta -> tabla = "users";
$consulta -> comparar = "id";
$consulta -> comparable = $iduser;
$row = $consulta -> where();

if(!isset($_GET['payment_id']) && !isset($_GET['status']) && !isset($_GET['payment_type']) && !isset($_GET['merchant_order_id'])){
    header("Location: ./");
}

$token = $_GET['token'];

$id_de_pago = $_GET['payment_id'];
$estado_de_pago = $_GET['status'];
if($_GET['status'] == "in_process"){
    $echo_estado_de_pago = "Pendiente";
}elseif($_GET['status'] == "approved"){
    $echo_estado_de_pago = "Aprobado";
}
$tipo_de_pago = $_GET['payment_type'];
$id_del_pedido = $_GET['merchant_order_id'];

$id_user_pay= $_GET['usr'];
$id_product= $_GET['prdct'];
$meses= (int)$_GET['mut'];

if(leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE token = '$token' && id = $id_user_pay") > 0 OR leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE token = '$token' && estado = 'Aprobado'") > 0){
    header("Location: ./");
}elseif($_GET['status'] == "in_process"){
    $consulta -> seleccion = "id";
    $consulta -> tabla = "tokens_pays";
    $consulta -> comparar = "token";
    $consulta -> comparable = $token;
    $respuesta = $consulta -> where();
    $id_token = $respuesta['id'];
    insertar_datos_custom_mysqli("UPDATE tokens_pays SET estado = 'Pendiente', id_pedido = $id_del_pedido, id_pago = $id_de_pago, pagado_con = '$tipo_de_pago', updated_at = '$fecha' WHERE id = '$id_token'");

}elseif($_GET['status'] == "approved"){
    $respuesta = consulta_mysqli_where("id","tokens_pays","token","'$token'");
    $id_token = $respuesta['id'];
    insertar_datos_custom_mysqli("UPDATE tokens_pays SET estado = 'Aprobado', id_pedido = $id_del_pedido, id_pago = $id_de_pago, pagado_con = '$tipo_de_pago', updated_at = '$fecha' WHERE id = '$id_token'");
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

        <?php
        if($_GET['status'] == "in_process"){
            ?>
            
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              <strong>El estado de pago está pendiente</strong> Si ya le cobraron no tienes nada de qué preocuparte, sino se le ha cobrado Mercado Pago tiene 7 dias para pagarlo o entonces borraremos todos los datos de tu paquete. Después de registrar tus datos en el formulario de abajo y haber enviado el pago, le pediremos que acceda a este contrato en su panel y envíe una solicitud de revisión del pago.
            </div>
            
            <script>
              var alertList = document.querySelectorAll('.alert');
              alertList.forEach(function (alert) {
                new bootstrap.Alert(alert)
              })
            </script>
            
            <?php
        }
        ?>

        <div class="flex_center">

            <div class="grid_1_auto">

                <div class="tarjeta_contenido">
                    <h1 class="text-center">El pago ha sido válido</h1>
                    <p class="text-justify">Estos son los datos de la transacción</p>
                    <ul>
                        <li>id del pago: <?php echo $id_de_pago; ?></li>
                        <li>id del pedido: <?php echo $id_del_pedido; ?></li>
                        <li>Tipo de pago: <?php echo $tipo_de_pago; ?></li>
                        <li>Estado del pago: <?php echo $echo_estado_de_pago; ?></li>
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
                            <input type="text" class="form-control" id="username" placeholder="Usuario" name="usuario" disabled value="Desde ahora, los usuarios se generan de manera automática." required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" class="form-control" id="password" placeholder="Contraseña" name="contra" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" class="form-control" id="email" placeholder="Correo Electrónico" name="correo" value="<?php echo $row['email']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre del Usuario:</label>
                            <input type="text" class="form-control" id="first_name" placeholder="Nombre del Usuario" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidos">Apellido del Usuario:</label>
                            <input type="text" class="form-control" id="last_name" placeholder="Apellido del Usuario" name="apellidos" required>
                        </div>
                        <div class="mb-3">
                            <label for="nameserver" class="form-label">Selecciona algun sistema nameservers para continuar</label>
                            <select class="form-select form-select-lg" name="nameserver" id="nameserver" required>
                                <option selected>Selecciona alguno</option>
                                <?php
                                foreach(arreglo_consulta("SELECT * FROM nameservers") as $row){
                                    ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['dns1']; ?> - <?php echo $row['dns2']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
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
                        $conexion = conect_mysqli();
                        $nameservers = mysqli_real_escape_string($conexion, (int) $_POST['nameserver']);
                        $consulta -> seleccion = "hestia_accounts.id,hestia_accounts.host,hestia_accounts.port,hestia_accounts.user,hestia_accounts.password";
                        $consulta -> tabla = "hestia_accounts";
                        $consulta -> comparar = "hestia_accounts.nameserver";
                        $consulta -> comparable = $nameservers;
                        $consulta_hestia = $consulta -> where();
                        // Server credentials
                        $hst_hostname = (string)$consulta_hestia['host'];
                        $hst_port = (int)$consulta_hestia['port'];
                        $hst_username = (string)$consulta_hestia['user'];
                        $hst_password = (string)$consulta_hestia['password'];
                        $hst_returncode = 'yes';
                        $hst_command = 'v-add-user';
                        $hst_id = $consulta_hestia['id'];
                        // New Account
                        $consulta -> seleccion = "nombre";
                        $consulta -> tabla = "servicios";
                        $consulta -> comparar = "id";
                        $consulta -> comparable = $id_product;
                        $consulta_paquetes = $consulta -> where();
                        $username = mysqli_real_escape_string($conexion, (string) generar_llave(8,"abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ"));
                        $password = mysqli_real_escape_string($conexion, (string) $_POST['contra']);
                        $email = mysqli_real_escape_string($conexion, (string) $_POST['correo']);
                        $package = (string)$consulta_paquetes['nombre'];
                        $first_name = mysqli_real_escape_string($conexion, (string) $_POST['nombre']);
                        $last_name = mysqli_real_escape_string($conexion, (string) $_POST['apellidos']);
                        mysqli_close($conexion);
                        
                        $token = $_GET['token'];
                        $id_de_pago = $_GET['payment_id'];
                        $estado_de_pago = $_GET['status'];
                        $tipo_de_pago = $_GET['payment_type'];
                        $id_del_pedido = $_GET['merchant_order_id'];
                        
                        $id_user_pay= $_GET['usr'];
                        $id_product= $_GET['prdct'];
                        $meses= (int)$_GET['mut'];
                        $consulta -> seleccion = "id";
                        $consulta -> tabla = "tokens_pays";
                        $consulta -> comparar = "token";
                        $consulta -> comparable = $token;
                        $respuesta = $consulta -> where();
                        $id_token = $respuesta['id'];
                        $fecha_creacion = new DateTime();
                        $fecha_creacion->modify('+'.$meses.' months');
                        $fecha_final = $fecha_creacion->format('Y-m-d H:i:s');
                        $new_token = generar_llave_alteratorio(16);
                        
                        insertar_datos_custom_mysqli("UPDATE tokens_pays SET expiracion = '$fecha_final', usuario = '$username', correo = '$email', token = '$new_token', updated_at = '$fecha' WHERE id = $id_token");


                        insertar_datos_clasic_mysqli("request_dns","id_hestia ,id_nameserver, id_user, id_pedido, created_at","$hst_id,$nameservers, $id_user_pay, $id_del_pedido, '$fecha'");
                        
                        eliminar_datos_custom_mysqli("DELETE FROM tokens_pays WHERE id_user = $id_user_pay && estado = 'Cancelado'");

                        // Prepare POST query
                        $postvars = ['user' => $hst_username, 'password' => $hst_password, 'returncode' => $hst_returncode, 'cmd' => $hst_command, 'arg1' => $username, 'arg2' => $password, 'arg3' => $email, 'arg4' => $package, 'arg5' => $first_name, 'arg6' => $last_name];

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
                            ?>
                            <script type="text/javascript">
                                window.location.href = "./";
                            </script>
                            <?php
                        }if($answer == 4){
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
