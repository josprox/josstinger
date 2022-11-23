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
        $pedido_catch = $consulta['id_pedido'];
        $consulta_hestia = consulta_mysqli_custom_all("SELECT hestia_accounts.host,hestia_accounts.port,hestia_accounts.user,hestia_accounts.password FROM hestia_accounts INNER JOIN request_dns ON hestia_accounts.id = request_dns.id_hestia WHERE request_dns.id_pedido = $pedido_catch;");
        // Server credentials
        $hst_hostname = (string)$consulta_hestia['host'];
        $hst_port = (int)$consulta_hestia['port'];
        $hst_username = (string)$consulta_hestia['user'];
        $hst_password = (string)$consulta_hestia['password'];
        $hst_returncode = 'yes';
        $hst_command = 'v-delete-user';

        // Account
        $username = $consulta['usuario'];

        // Prepare POST query
        $postvars = ['user' => $hst_username, 'password' => $hst_password, 'returncode' => $hst_returncode, 'cmd' => $hst_command, 'arg1' => $username];

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
        $data = json_decode($answer, true, 512, JSON_THROW_ON_ERROR);

        // Check result
        if(is_numeric($answer) && $answer == '0') {
            eliminar_datos_con_where("tokens_pays","id",$id_product);
            eliminar_datos_con_where("request_dns","id_pedido",$pedido_catch);
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
    if(isset($_POST['revision'])){
        echo mail_smtp_v1_3_recibir($consulta['usuario'],"Revisión de pago","Se ha pedido una revisión dentro de Josstinger pues ya se ha realizado el pago, el id de la transacción es: " .$consulta['id'] . " .",$consulta['correo']);
    }
        if($consulta['estado'] == "Pendiente"){
            ?>
            
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              <strong>El estado de pago está pendiente</strong> Si ya le cobraron le pedimos de la manera más atenta le de clic en el botón "Solicitar revisión" para que nosotros lo pongamos en completado.
            </div>
            
            <script>
              var alertList = document.querySelectorAll('.alert');
              alertList.forEach(function (alert) {
                new bootstrap.Alert(alert)
              })
            </script>
            
            <?php
        }elseif($consulta['estado'] == "Actualizando"){
            ?>
            
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              <strong>El estado de pago está pendiente</strong> Si ya le cobraron le pedimos de la manera más atenta le de clic en el botón "Solicitar revisión" para que nosotros lo pongamos en completado.
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
                    <?php
                    if (isset($_POST['renovar'])){
                        ?>
                        <div class="col-datos">
                            <h2 class="text-shadow-white text-center">Tu pedido</h2>
                            <?php
                                include (__DIR__ . "../../../config/mercado_pago_hestia.php");
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
                        $dominio = (mysqli_real_escape_string($conexion,(string) $_POST['dominio']));
                        $pedido_catch = $consulta['id_pedido'];
                        $consulta_hestia = consulta_mysqli_custom_all("SELECT hestia_accounts.host,hestia_accounts.port,hestia_accounts.user,hestia_accounts.password FROM hestia_accounts INNER JOIN request_dns ON hestia_accounts.id = request_dns.id_hestia WHERE request_dns.id_pedido = $pedido_catch;");
                        // Server credentials
                        echo $hst_hostname = (string)$consulta_hestia['host'];
                        $hst_port = (int)$consulta_hestia['port'];
                        $hst_username = (string)$consulta_hestia['user'];
                        $hst_password = (string)$consulta_hestia['password'];
                        $hst_returncode = 'yes';
                        $hst_command = 'v-add-domain';

                        // Domain details
                        $username = $consulta['usuario'];
                        $domain = $dominio;

                        // Prepare POST query
                        $postvars = ['user' => $hst_username, 'password' => $hst_password, 'returncode' => $hst_returncode, 'cmd' => $hst_command, 'arg1' => $username, 'arg2' => $domain];

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
                        <li>Estado del pago: <?php echo $consulta['estado']; ?></li>
                        <li>Forma de pago que usó: <?php echo $consulta['pagado_con']; ?></li>
                        <li>Expiración: <?php echo $consulta['expiracion']; ?></li>
                    </ul>
                    
                    <p class="text-justify">Los siguientes datos son tus credenciales de acceso.</p>
                    
                    <ul>
                        <li>Usuario: <?php echo $consulta['usuario']; ?></li>
                        <li>Correo: <?php echo $consulta['correo']; ?></li>
                        <li>Contraseña: La misma que usaste cuando te registraste</li>
                    </ul>
                    <p class="text-justify">DNS correspondiente del pedido.</p>
                    <?php
                    $pedido = $consulta['id_pedido'];
                    $consulta_dns = consulta_mysqli_custom_all("SELECT nameservers.dns1,nameservers.dns2 FROM nameservers INNER JOIN request_dns ON nameservers.id = request_dns.id_nameserver WHERE request_dns.id_pedido = $pedido;");
                    ?>
                    <ul>
                        <li>Namerserver 1: <?php echo $consulta_dns['dns1']; ?></li>
                        <li>Namerserver 1: <?php echo $consulta_dns['dns2']; ?></li>
                    </ul>
                    
                    <div class="flex_center">
                        <div class="grid_4_auto">

                            <div class="capsula">
                                <a class="btn btn-success" href="https://gran.josprox.ovh:2053/" role="button">Ingresar al panel</a>
                            </div>
    
                            <div class="capsula">
                            <?php
                            if ($consulta['estado'] == "Aprobado"){
                                ?>
                                <button onclick="renovar();" class="btn btn-primary">Renovar</button>
                                <?php
                            }elseif($consulta['estado'] == "Pendiente" OR $consulta['estado'] == "Actualizando"){
                                ?>
                                <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
                                    <button type="submit" class="btn btn-secondary" name="revision">Solicitar revisión</button>
                                </form>
                                <?php
                            }
                            ?>
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
