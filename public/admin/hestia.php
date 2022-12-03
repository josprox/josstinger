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
    $id = mysqli_real_escape_string($conexion, (int) $_POST['txtID']);
    mysqli_close($conexion);
    $consulta_nameserver = consulta_mysqli_where("nameserver","hestia_accounts","id",$id);
    if (eliminar_datos_con_where("nameservers","id",(int)$consulta_nameserver["nameserver"])){
      echo eliminar_datos_con_where("hestia_accounts","id",$id);
    }
  }

  if (isset($_POST['registro'])){
    $conexion = conect_mysqli();
    $host_hestia = mysqli_real_escape_string($conexion, (string) $_POST['host_hestia']);
    $puerto_hestia = mysqli_real_escape_string($conexion, (int) $_POST['port_hestia']);
    $usuario_hestia = mysqli_real_escape_string($conexion, (string) $_POST['user_hestia']);
    $contra_hestia = mysqli_real_escape_string($conexion, (string) $_POST['password_hestia']);
    $dns1_hestia = mysqli_real_escape_string($conexion, (string) $_POST['dns1_hestia']);
    $dns2_hestia = mysqli_real_escape_string($conexion, (string) $_POST['dns2_hestia']);
    mysqli_close($conexion);
    insertar_datos_custom_mysqli("INSERT INTO `nameservers` (dns1, dns2) VALUES ('$dns1_hestia', '$dns2_hestia');");
    $id_consulta_nameservers = consulta_mysqli_custom_all("SELECT nameservers.id FROM nameservers WHERE nameservers.dns1 = '$dns1_hestia' && nameservers.dns2 = '$dns2_hestia';");
    $id_nameservers = $id_consulta_nameservers['id'];
    insertar_datos_custom_mysqli("INSERT INTO `hestia_accounts` (nameserver, host, port, user, password) VALUES($id_nameservers, '$host_hestia', $puerto_hestia, '$usuario_hestia', '$contra_hestia');");
  }

  ?>
  <div id="register">
    <button class="btn btn-primary" onclick="closeForm();">Cancelar</button>
    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
  
      <div class="row justify-content-center">
  
        <div class="col-3">
          <div class="mb-3">
            <label for="host_hestia" class="form-label">Host</label>
            <input type="text"
              class="form-control" name="host_hestia" id="host_hestia" aria-describedby="host_hestia" placeholder="Pon el host a registrar">
            <small id="host_hestia" class="form-text text-muted">Es necesario registrar el post</small>
          </div>
        </div>
  
        <div class="col-4">
          <div class="mb-3">
            <label for="port_hestia" class="form-label">Puerto</label>
            <input type="number"
              class="form-control" name="port_hestia" id="port_hestia" aria-describedby="port_hestia" placeholder="Pon el puerto donde se conecta">
            <small id="port_hestia" class="form-text text-muted">Es necesario saber a donde nos conectamos.</small>
          </div>
        </div>
  
        <div class="col-3">
          <div class="mb-3">
            <label for="user_hestia" class="form-label">Usuario</label>
            <input type="text"
              class="form-control" name="user_hestia" id="user_hestia" aria-describedby="user_hestia" placeholder="Pon el usuario admin">
            <small id="user_hestia" class="form-text text-muted">Pon las credenciales de acceso del usuario de administración.</small>
          </div>
        </div>
  
        <div class="col-3">
          <div class="mb-3">
            <label for="password_hestia" class="form-label">Contraseña</label>
            <input type="password_hestia"
              class="form-control" name="password_hestia" id="password_hestia" aria-describedby="password_hestia" placeholder="Pon la contraseña de acceso">
            <small id="password_hestia" class="form-text text-muted">Pon la contraseña del usuario.</small>
          </div>
        </div>
  
        <div class="col-4">
          <div class="mb-3">
            <label for="dns1_hestia" class="form-label">DNS 1</label>
            <input type="text"
              class="form-control" name="dns1_hestia" id="dns1_hestia" aria-describedby="dns1_hestia" placeholder="Pon el primer nameserver">
            <small id="dns1_hestia" class="form-text text-muted">Necesitamos saber con cuál nameserver se conectará el usuario.</small>
          </div>
        </div>
  
        <div class="col-3">
        <div class="mb-3">
            <label for="dns2_hestia" class="form-label">DNS 2</label>
            <input type="text"
              class="form-control" name="dns2_hestia" id="dns2_hestia" aria-describedby="dns2_hestia" placeholder="Pon el segundo nameserver">
            <small id="dns2_hestia" class="form-text text-muted">Necesitamos saber con cuál nameserver se conectará el usuario.</small>
          </div>
        </div>
  
        
      </div>
      <center>
        <button name="registro" type="submit" class="btn btn-success">Guardar</button>
      </center>
  
    </form>
  </div>

  <div id="login">
    <button class="btn btn-primary" onclick="registerForm();">Registrar nuevo servidor</button>
  </div>

  <br>

  <div class="table-responsive">
    <table class="table table-striped
    table-hover	
    table-borderless
    table-primary
    align-middle">
      <thead class="table-dark">
        <caption>Registros de Nameservers</caption>
        <tr>
          <th>ID</th>
          <th>Nameservers</th>
          <th>Host</th>
          <th>Puerto</th>
          <th>Usuario</th>
          <th>Contraseña</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="table-group-divider">
          <?php
          foreach (arreglo_consulta("SELECT hestia_accounts.id, nameservers.dns1, nameservers.dns2, hestia_accounts.host, hestia_accounts.port, hestia_accounts.user, hestia_accounts.password FROM hestia_accounts INNER JOIN nameservers ON hestia_accounts.nameserver = nameservers.id;") as $row){?>
          <tr class="table-primary" >
            <td scope="row"><?php echo $row['id']; ?></td>
            <td><?php echo $row['dns1']; ?> - <?php echo $row['dns2']; ?></td>
            <td><?php echo $row['host']; ?></td>
            <td><?php echo $row['port']; ?></td>
            <td><?php echo $row['user']; ?></td>
            <td><?php echo $row['password']; ?></td>
            <td>
                <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
                  <input value="<?php echo $row['id']; ?>" type="hidden" name="txtID" id="txtID">
                  <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                </form>
          </td>
          </tr>
          <?php
          }
          ?>
        </tbody>
        <tfoot>
          
        </tfoot>
    </table>
  </div>

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
