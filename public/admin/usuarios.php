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
    $id = mysqli_real_escape_string($conexion, $_POST['txtID']);
    mysqli_close($conexion);

    echo eliminar_datos_con_where("users","id",$id);
  }

  ?>

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
          <th>Nombre</th>
          <th>Correo</th>
          <th>Rol del usuario</th>
          <th>Creación</th>
          <th>Ultima actualización</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="table-group-divider">
          <?php
          foreach (arreglo_consulta("SELECT * FROM users") as $row){?>
          <tr class="table-primary" >
            <td scope="row"><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['id_rol']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td><?php echo $row['updated_at']; ?></td>
            <td>
              <?php if($row['id'] != $iduser){?>
                <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
                  <input value="<?php echo $row['id']; ?>" type="hidden" name="txtID" id="txtID">
                  <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                </form>
              <?php }elseif($row['id'] == $iduser){ ?>
                  No puedes hacer nada
              <?php } ?>
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