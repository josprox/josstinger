<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ./../panel");
}

$iduser = $_SESSION['id_usuario'];
secure_auth_admin($iduser,"../");

?>

<!doctype html>
<html lang="es-MX">

<head>
  <title><?php echo $nombre_app," versión: ", $version_app; ?></title>
  <?php head_admin(); ?>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

</head>

<body>

  <?php navbar_admin(); ?>

  <br>

  <div class="container">

  <?php
  
  if (isset($_POST['eliminar'])){
    $conexion = conect_mysqli();
    $id = mysqli_real_escape_string($conexion, (int) $_POST['id']);
    $consulta = consulta_mysqli_where("usuario, id_pedido","tokens_pays","id",$id);
    mysqli_close($conexion);
    // Consulta del pedido.
    $pedido_catch = $consulta['id_pedido'];
    $consulta_hestia = consulta_mysqli_custom_all("SELECT hestia_accounts.host,hestia_accounts.port,hestia_accounts.user,hestia_accounts.password FROM hestia_accounts INNER JOIN request_dns ON hestia_accounts.id = request_dns.id_hestia WHERE request_dns.id_pedido = $pedido_catch;");
    // Credenciales de acceso hestia
    $hst_hostname = (string)$consulta_hestia['host'];
    $hst_port = (int)$consulta_hestia['port'];
    $hst_username = (string)$consulta_hestia['user'];
    $hst_password = (string)$consulta_hestia['password'];
    $hst_returncode = 'yes';
    $hst_command = 'v-delete-user';

    // cuenta
    $username = $consulta['usuario'];

    // Preparamos el metodo POST query
    $postvars = ['user' => $hst_username, 'password' => $hst_password, 'returncode' => $hst_returncode, 'cmd' => $hst_command, 'arg1' => $username];

    // enviamos el metodo POST query por cURL
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
    eliminar_datos_con_where("request_dns","id_pedido",$consulta['id_pedido']);
    eliminar_datos_con_where("tokens_pays","id_pedido",$consulta['id_pedido']);
    ?>
        <script>
            Swal.fire(
            '¡Buen trabajo!',
            'Se ha eliminado de manera correcta',
            'success'
            )
            </script>
        <script>
            timer: 8000,
            window.location.href = "./suscripciones"
        </script>
        <?php
  }elseif(isset($_POST['registrar'])){
    // Registro de datos por metodo POST.
    $conexion = conect_mysqli();
    $token = generar_llave_alteratorio(16);
    $first_name = mysqli_real_escape_string($conexion, (string) $_POST['nombre']);
    $last_name = mysqli_real_escape_string($conexion, (string) $_POST['apellidos']);
    $estado = mysqli_real_escape_string($conexion, (string) $_POST['estado']);
    $usuario = mysqli_real_escape_string($conexion, (string) $_POST['usuario']);
    $correo = mysqli_real_escape_string($conexion, (string) $_POST['correo']);
    $contra = mysqli_real_escape_string($conexion, (string) $_POST['contra']);
    $expiracion = mysqli_real_escape_string($conexion, (string) $_POST['expiracion']);
    $nameserver = mysqli_real_escape_string($conexion, (int) $_POST['nameserver']);
    $id_user = mysqli_real_escape_string($conexion, (int) $_POST['id_user']);
    $id_servicio = mysqli_real_escape_string($conexion, (int) $_POST['id_servicio']);
    // Generamos id únicos y un registro de pago.
    $id_pedido = generar_llave(10,"123456789");
    $id_pago = generar_llave(10,"123456789");
    $pagado_con = "Manual";
    // Consulta de datos de acceso.
    $consulta_hestia = consulta_mysqli_custom_all("SELECT hestia_accounts.id,hestia_accounts.host,hestia_accounts.port,hestia_accounts.user,hestia_accounts.password FROM hestia_accounts INNER JOIN nameservers ON hestia_accounts.nameserver = hestia_accounts.id WHERE nameservers.id = $nameserver");
    $consulta_paquetes = consulta_mysqli_custom_all("SELECT nombre FROM servicios WHERE id = $id_servicio;");
    $package = (string)$consulta_paquetes['nombre'];
    // --------------------------------------------------------
    // Conexión del servidor.
    // --------------------------------------------------------
    // Server credentials
    $hst_hostname = (string)$consulta_hestia['host'];
    $hst_port = (int)$consulta_hestia['port'];
    $hst_username = (string)$consulta_hestia['user'];
    $hst_password = (string)$consulta_hestia['password'];
    $hst_returncode = 'yes';
    $hst_command = 'v-add-user';
    $hst_id = $consulta_hestia['id'];
    // Insertamos los datos SQL
    insertar_datos_clasic_mysqli("tokens_pays","token, estado, id_user, id_servicio, id_pedido, id_pago, pagado_con, usuario, correo, expiracion, created_at","'$token','$estado',$id_user,$id_servicio,$id_pedido, $id_pago,'$pagado_con','$usuario','$correo','$expiracion','$fecha'");
    insertar_datos_clasic_mysqli("request_dns","id_hestia, id_nameserver, id_user, id_pedido, created_at","$hst_id,$nameserver,$id_user,$id_pedido, '$fecha'");
    // Preparamos POST query
    $postvars = ['user' => $hst_username, 'password' => $hst_password, 'returncode' => $hst_returncode, 'cmd' => $hst_command, 'arg1' => $usuario, 'arg2' => $contra, 'arg3' => $correo, 'arg4' => $package, 'arg5' => $first_name, 'arg6' => $last_name];
    // enviamos el metodo POST query por cURL
    $postdata = http_build_query($postvars);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://' . $hst_hostname . ':' . $hst_port . '/api/');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
    $answer = curl_exec($curl);
    ?>
      <script>
        Swal.fire(
          '¡Buen trabajo!',
          'Se ha creado todo de manera correcta',
          'success'
        )
      </script>
      <script>
        timer: 8000,
        window.location.href = "./suscripciones"
      </script>
    <?php
  }elseif(isset($_POST['actualizar'])){
    $conexion = conect_mysqli();
    $id = mysqli_real_escape_string($conexion, (int) $_POST['id']);
    $estado = mysqli_real_escape_string($conexion, (string) $_POST['estado']);
    $conexion -> close();
    actualizar_datos_mysqli("tokens_pays","`estado` = '$estado'","id",$id);
    ?>
      <script>
        Swal.fire(
          '¡Buen trabajo!',
          'Se ha actualizado el estado de manera correcta',
          'success'
        )
      </script>
      <script>
        timer: 8000,
        window.location.href = "./suscripciones"
      </script>
    <?php
  }else{
    ?>
    <div id="register">
        <button class="btn btn-primary" onclick="closeForm();">Cancelar</button>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
          <div class="grid_4_auto">

            <div class="mb-3 contenedor">
              <label for="nombre" class="form-label">Nombre(s)</label>
              <input type="text"
                class="form-control" name="nombre" id="nombre" aria-describedby="nombre" placeholder="Pon el nombre del usuario a registrar" required>
              <small id="nombre" class="form-text text-muted">Pon el nombre a quien se le registra el paquete de esta suscripción.</small>
            </div>
            <div class="mb-3 contenedor">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input type="text"
                class="form-control" name="apellidos" id="apellidos" aria-describedby="apellidos" placeholder="Pon el apellido del usuario" required>
              <small id="apellidos" class="form-text text-muted">Pon el apellido de la persona.</small>
            </div>
            <div class="mb-3 contenedor">
              <label for="estado" class="form-label">Estado</label>
              <input type="text"
                class="form-control" name="estado" id="estado" aria-describedby="estado" placeholder="Pon el estado del producto" required>
              <small id="estado" class="form-text text-muted">Pon el estado del producto, puede ser Aprobado, Actualizando y Pendiente.</small>
            </div>
            <div class="mb-3 contenedor">
              <label for="id_user" class="form-label">ID del usuario</label>
              <input type="number"
                class="form-control" name="id_user" id="id_user" aria-describedby="id_user" placeholder="Pon el id del usuario a quien le corresponde" required>
              <small id="id_user" class="form-text text-muted">Debes poner el ID del usuario a quien le corresponde.</small>
            </div>
            <div class="mb-3 contenedor">
              <label for="id_servicio" class="form-label">Tipo de suscripción</label>
              <select class="form-select form-select-sm" name="id_servicio" id="id_servicio" required>
                <option selected>Selecciona el tipo de suscripción.</option>
                <?php 
                foreach(arreglo_consulta("SELECT id, nombre FROM servicios") as $servicio){
                  ?>
                  <option value="<?php echo $servicio['id']; ?>"><?php echo $servicio['nombre']; ?></option>
                  <?php
                } ?>
              </select>
            </div>
            <div class="mb-3 contenedor">
              <label for="usuario" class="form-label">Usuario</label>
              <input type="text"
                class="form-control" name="usuario" id="usuario" aria-describedby="usuario" placeholder="Pon el usuario a registrar" required>
              <small id="usuario" class="form-text text-muted">Pon el usuario de hestia.</small>
            </div>
            <div class="mb-3 contenedor">
              <label for="correo" class="form-label">Correo</label>
              <input type="email"
                class="form-control" name="correo" id="correo" aria-describedby="correo" placeholder="Pon el correo que se le asignará al contrato." required>
              <small id="correo" class="form-text text-muted">Aquí va el correo del cuál le corresponde el contrato.</small>
            </div>
            <div class="mb-3 contenedor">
              <label for="contra" class="form-label">Contraseña</label>
              <input type="text"
                class="form-control" name="contra" id="contra" aria-describedby="contra" placeholder="Pon la contraseña de acceso para el panel" required>
              <small id="contra" class="form-text text-muted">Pon una contraseña para que el usuario pueda acceder al panel</small>
            </div>
            <div class="mb-3 contenedor">
              <label for="expiracion" class="form-label">Fecha de expiración</label>
              <input type="datetime-local"
                class="form-control" name="expiracion" id="expiracion" aria-describedby="expiracion" placeholder="Pon la fecha" required>
              <small id="expiracion" class="form-text text-muted">Inserta la fecha cuando expira el producto.</small>
            </div>
            <div class="mb-3">
              <label for="nameserver" class="form-label">Selecciona algún proovedor DNS</label>
              <select class="form-select form-select-sm" name="nameserver" id="nameserver" required>
                <option selected>Selecciona un nameserver</option>
                <?php foreach(arreglo_consulta("SELECT * FROM nameservers") as $nameserver){
                  ?>
                  <option value="<?php echo $nameserver['id']; ?>"><?php echo $nameserver['dns1']; ?> - <?php echo $nameserver['dns2']; ?></option>
  
                  <?php
                } ?>
              </select>
            </div>

          </div>
          <div class="flex_center">
            <button type="submit" name="registrar" class="btn btn-success">Registrar</button>
          </div>
        </form>
        <br>
    </div>
    <div id="login">
      <button class="btn btn-primary" onclick="registerForm();">Registrar suscripción manual</button>
      <div class="table-responsive">
        <table class="table table-striped
        table-hover	
        table-borderless
        table-primary
        align-middle">
          <thead class="table-dark">
            <caption>Usuarios</caption>
            <tr>
              <th>ID</th>
              <th>Estado del producto</th>
              <th>Nombre de usuario registrado</th>
              <th>correo del usuario</th>
              <th>Paquete contratado</th>
              <th>Usuaio de acceso</th>
              <th>Correo de acceso</th>
              <th>Número de pedido</th>
              <th>Número de pago</th>
              <th>Forma de pago</th>
              <th>Fecha de expiración</th>
              <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
              <?php
              foreach (arreglo_consulta("SELECT tokens_pays.id ,tokens_pays.estado, users.name, users.email, servicios.nombre, tokens_pays.usuario, tokens_pays.correo,tokens_pays.id_pedido, tokens_pays.id_pago, tokens_pays.pagado_con, tokens_pays.expiracion FROM tokens_pays INNER JOIN users ON users.id = tokens_pays.id_user INNER JOIN servicios ON servicios.id = tokens_pays.id_servicio ORDER BY tokens_pays.id DESC") as $row){?>
              <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
              <tr class="table-primary" >
                <td scope="row"><?php echo $row['id']; ?></td>
                <td><input type="text" name="estado" class="form-control" style="min-width: 120px;" value="<?php echo $row['estado']; ?>"></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['usuario']; ?></td>
                <td><?php echo $row['correo']; ?></td>
                <td><?php echo $row['id_pedido']; ?></td>
                <td><?php echo $row['id_pago']; ?></td>
                <td><?php echo $row['pagado_con']; ?></td>
                <td><?php echo $row['expiracion']; ?></td>
                <td>
                  <center>
                    <div><button type="submit" name="actualizar" class="btn btn-success">Actualizar</button></div>
                    <br>
                    <div><button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button></div>
                  </center>
                </td>
              </tr>
              </form>
              <?php
              }
              ?>
            </tbody>
            <tfoot>
              
            </tfoot>
        </table>
      </div>
    </div>
    <?php
  }

  ?>


  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
  <script>
    function registerForm(){
      document.getElementById('login').style.display = 'none';
      document.getElementById('register').style.display = 'block';
    }
    function closeForm(){
      document.getElementById('login').style.display = 'block';
      document.getElementById('register').style.display = 'none';
    }
  </script>
</body>

</html>
