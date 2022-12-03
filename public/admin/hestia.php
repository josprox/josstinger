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
    $host = mysqli_real_escape_string($conexion, (string) $_POST['host']);
    $puerto = mysqli_real_escape_string($conexion, (int) $_POST['port']);
    $usuario = mysqli_real_escape_string($conexion, (string) $_POST['user']);
    $contra = mysqli_real_escape_string($conexion, (string) $_POST['password']);
    $dns1 = mysqli_real_escape_string($conexion, (string) $_POST['dns1']);
    $dns2 = mysqli_real_escape_string($conexion, (string) $_POST['dns2']);
    mysqli_close($conexion);
    if(insertar_datos_custom_mysqli("INSERT INTO `nameservers` (`dns1`, `dns2`) VALUES ('$dns1', '$dns2');")){
      $id_consulta_nameservers = consulta_mysqli_custom_all("SELECT id FROM nameservers WHERE dns1 = '$dns1' && dns2 = '$dns2'");
      $id_nameservers = $id_consulta_nameservers['id'];
      if(insertar_datos_custom_mysqli("INSERT INTO `hestia_accounts` (`nameserver`, `host`, `port`, `user`, `password`) VALUES($id_nameservers, '$host', $puerto, '$usuario', '$contra');")){
        echo `
        Swal.fire(
          'Correcto',
          'Se ha insertado de manera correcta',
          'success'
        )
        `;
      }
    }
  }

  ?>

  <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">

  <div class="row justify-content-center">

    <div class="col-3">
      <div class="mb-3">
        <label for="host" class="form-label">Host</label>
        <input type="text"
          class="form-control" name="host" id="host" aria-describedby="host" placeholder="Pon el host a registrar">
        <small id="host" class="form-text text-muted">Es necesario registrar el post</small>
      </div>
    </div>

    <div class="col-4">
      <div class="mb-3">
        <label for="port" class="form-label">Puerto</label>
        <input type="text"
          class="form-control" name="port" id="port" aria-describedby="port" placeholder="Pon el puerto donde se conecta">
        <small id="port" class="form-text text-muted">Es necesario saber a donde nos conectamos.</small>
      </div>
    </div>

    <div class="col-3">
      <div class="mb-3">
        <label for="user" class="form-label">Usuario</label>
        <input type="text"
          class="form-control" name="user" id="user" aria-describedby="user" placeholder="Pon el usuario admin">
        <small id="user" class="form-text text-muted">Pon las credenciales de acceso del usuario de administración.</small>
      </div>
    </div>

    <div class="col-3">
      <div class="mb-3">
        <label for="password" class="form-label">Contraseña </label>
        <input type="password"
          class="form-control" name="password" id="password" aria-describedby="password" placeholder="Pon la contraseña de acceso">
        <small id="password" class="form-text text-muted">Pon la contraseña del usuario.</small>
      </div>
    </div>

    <div class="col-4">
      <div class="mb-3">
        <label for="dns1" class="form-label">DNS 1</label>
        <input type="text"
          class="form-control" name="dns1" id="dns1" aria-describedby="dns1" placeholder="Pon el primer nameserver">
        <small id="dns1" class="form-text text-muted">Necesitamos saber con cuál nameserver se conectará el usuario.</small>
      </div>
    </div>

    <div class="col-3">
    <div class="mb-3">
        <label for="dns2" class="form-label">DNS 2</label>
        <input type="text"
          class="form-control" name="dns2" id="dns2" aria-describedby="dns2" placeholder="Pon el segundo nameserver">
        <small id="dns2" class="form-text text-muted">Necesitamos saber con cuál nameserver se conectará el usuario.</small>
      </div>
    </div>

    
  </div>
  <button name="registro" type="submit" class="btn btn-success">Guardar</button>

  </form>

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
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
</body>

</html>
