<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ./../panel");
}

$iduser = $_SESSION['id_usuario'];

$row = consulta_mysqli_where("name","users","id",$iduser);

$get_id_product = $_GET['id'];

if (leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser && id = $get_id_product;")<=0){
    header("Location: ./");
}elseif(!$_GET['id']){
    header("Location: ./");
}

$consulta = consulta_mysqli_custom_all("SELECT tokens_pays.id_servicio,tokens_pays.id, tokens_pays.usuario, tokens_pays.correo, tokens_pays.estado, tokens_pays.id_pedido, tokens_pays.id_pago, tokens_pays.pagado_con, tokens_pays.expiracion, servicios.nombre, tokens_pays.created_at FROM servicios INNER JOIN tokens_pays ON servicios.id = tokens_pays.id_servicio WHERE id_user = $iduser && tokens_pays.id = $get_id_product;");

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

    <?php navbar_users(); ?>

    <?php include (__DIR__ . "../../../routes/hestia/bienvenida.php") ?>

    <?php

      if(isset($_POST['eliminar'])){
        $id_product = $_POST['id_product'];

        // Server credentials
        $hst_hostname = (string)$_ENV['HST_HOSTNAME'];
        $hst_port = (int)$_ENV['HST_PORT'];
        $hst_username = (string)$_ENV['HST_USUARIO'];
        $hst_password = (string)$_ENV['HST_CONTRA'];
        $hst_returncode = 'yes';
        $hst_command = 'v-delete-user';

        // Account
        $username = $consulta['usuario'];

        // Prepare POST query
        $postvars = array(
            'user' => $hst_username,
            'password' => $hst_password,
            'returncode' => $hst_returncode,
            'cmd' => $hst_command,
            'arg1' => $username
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

        // Parse JSON output
        $data = json_decode($answer, true);

        // Check result
        if(is_numeric($answer) && $answer == '0') {
            eliminar_datos_con_where("tokens_pays","id",$id_product);
            echo "
            <script>
                Swal.fire(
                'Completado',
                'Se ha eliminado todo de manera correcta.',
                'success'
                )
            </script>";
            echo '
            <script type="text/javascript">
                window.location.href = "./";
            </script>
            ';
        } else {
            echo "Query returned error code: " .$answer. "\n";
        }

      }

    ?>

    <section class="contenedor">
                    <?php
                    if (isset($_POST['renovar'])){
                        ?>
                        <div class="col-datos">
                            <h2 class="text-shadow-white text-center">Tu pedido</h2>
                            <?php
                            if(isset($_POST['renovar'])){
                                $conexion = conect_mysqli();
                                $servicio = $consulta['id_servicio'];
                                $id_producto = $consulta['id'];
                                $meses = (int)mysqli_real_escape_string($conexion, $_POST['meses']);
                                mysqli_close($conexion);
                                $rows = consulta_mysqli_where("nombre,precio","servicios","id",$servicio);
                                $precio = $rows['precio'];
                                $total = $precio * $meses;
                                $token_new = generar_llave_alteratorio(16);
                                insertar_datos_custom_mysqli("UPDATE `tokens_pays` SET `token` = '$token_new' WHERE `tokens_pays`.`id` = $id_producto");
                                $preference_id = mercado_pago($rows['nombre'],$meses,$precio,"USD","hestia/public/users/renovar?token=$token_new&usr=$iduser&prdct=$servicio&mut=$meses","hestia/public/users/falla","hestia/public/users/pendiente");
                                foreach(arreglo_consulta("SELECT nombre,descripcion FROM servicios WHERE id = $servicio") as $row){
                                    ?>
                                    <div class="block-7">
                                        <div class="text-center">
                                            <h2 class="heading"><?php echo $row['nombre']; ?></h2>
                                            <span class="price"><sup>$USD</sup> <span class="number"><?php echo $total; ?></span></span>
                                            
                                            <?php echo $row['descripcion'] ?>
                                        </div>
                                    </div>
                                    <form action="" method="post">
                                        <center>
                                            <a href="<?php echo $preference_id; ?>" class="btn btn-success">Pagar con Mercado Pago</a>
                                        </center>
                                    </form>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>

        <div id="esconder" class="flex_center">

            <div class="grid_1_auto">
                <div id="renovar">
                    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST">
                    <h2>Recueda que, al renovar se te hará un cobro de los meses seleccionados</h2>
                        <div class="mb-3">
                          <label for="meses" class="form-label">Cuántos meses más quieres aumentarlo</label>
                          <input type="number"
                            class="form-control" name="meses" id="meses" aria-describedby="meses" placeholder="Pon los meses" value="1">
                          <small id="meses" class="form-text text-muted">Una vez seleccionado se te cobrará los meses</small>
                        </div>
                        <button type="submit" name="renovar" class="btn btn-primary">Renovar</button>
                    </form>
                </div>
                <div id="agregar">
                    <?php
                    if(isset($_POST['agregar'])){
                        $conexion = conect_mysqli();
                        $dominio = (string)(mysqli_real_escape_string($conexion,$_POST['dominio']));
                        // Server credentials
                        $hst_hostname = (string)$_ENV['HST_HOSTNAME'];
                        $hst_port = (int)$_ENV['HST_PORT'];
                        $hst_username = (string)$_ENV['HST_USUARIO'];
                        $hst_password = (string)$_ENV['HST_CONTRA'];
                        $hst_returncode = 'yes';
                        $hst_command = 'v-add-domain';

                        // Domain details
                        $username = $consulta['usuario'];
                        $domain = $dominio;

                        // Prepare POST query
                        $postvars = array(
                            'user' => $hst_username,
                            'password' => $hst_password,
                            'returncode' => $hst_returncode,
                            'cmd' => $hst_command,
                            'arg1' => $username,
                            'arg2' => $domain
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
                        if($answer != 0) {
                            echo "Query returned error code: " .$answer. "\n";
                        }
                        echo "
                            <script>
                                Swal.fire(
                                'Completado',
                                'Se ha agregado el dominio de manera correcta.',
                                'success'
                                )
                            </script>";
                    } ?>
                    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST">
                        <div class="mb-3">
                          <label for="dominio" class="form-label">Dominio</label>
                          <input type="text"
                            class="form-control" name="dominio" id="dominio" aria-describedby="dominio" placeholder="Pon el dominio">
                          <small id="dominio" class="form-text text-muted">Pon el dominio que desees agregar a tu cuenta</small>
                        </div>
                        <button type="submit" name="agregar" class="btn btn-primary">Agregar dominio</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="flex_center">


            <div class="grid_1_auto">

                <div class="tarjeta_contenido">
                    <h4 class="text-center">Tu producto</h4>
                    <p class="text-justify">A continuación te daremos información del producto contratado, si tiene algún error contáctanos al correo joss@int.josprox.com.</p>
                    <ul>
                        <li>Producto: <?php echo $consulta['nombre']; ?></li>
                        <li>ID del pedido: <?php echo $consulta['id_pedido']; ?></li>
                        <li>ID del pago: <?php echo $consulta['id_pago']; ?></li>
                        <li>Forma de pago que usó: <?php echo $consulta['pagado_con']; ?></li>
                        <li>Expiración: <?php echo $consulta['expiracion']; ?></li>
                    </ul>

                    <p class="text-justify">Los siguientes datos son tus credenciales de acceso.</p>

                    <ul>
                        <li>Usuario: <?php echo $consulta['usuario']; ?></li>
                        <li>Correo: <?php echo $consulta['correo']; ?></li>
                        <li>Contraseña: La misma que usaste cuando te registraste</li>
                    </ul>

                    <div class="flex_center">
                        <div class="grid_3_auto">
    
                            <div class="capsula">
                                <button onclick="renovar();" class="btn btn-primary">Renovar</button>
                            </div>

                            <div class="capsula">
                                <button onclick="agregar();" class="btn btn-warning">Agregar web/DNS</button>
                            </div>
    
                            <div class="capsula">
                                <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
                                <input type="hidden" name="id_product" value="<?php echo $consulta['id']; ?>">
                                    <button type="submit" name="eliminar" class="btn btn-danger">Cancelar contrato y eliminar todo</button>
                                </form>
                            </div>
    
                        </div>
                    </div>
                    
                </div>

            </div>

        </div>

    </section>

    <?php footer_users(); ?>

    <script>
        function renovar(){
            document.getElementById('esconder').style.display = 'block';
            document.getElementById('renovar').style.display = 'block';
            document.getElementById('agregar').style.display = 'none';
            window.location='#renovar';
        }
        function agregar(){
            document.getElementById('esconder').style.display = 'block';
            document.getElementById('renovar').style.display = 'none';
            document.getElementById('agregar').style.display = 'block';
            window.location='#agregar';
        }
    </script>
    
</body>
</html>