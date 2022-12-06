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
    eliminar_datos_con_where("users","id",$id);
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
            window.location.href = "./usuarios"
        </script>
        <?php
  }elseif(isset($_POST['registrar'])){
    $conexion = conect_mysqli();
    $name = mysqli_real_escape_string($conexion, (string) $_POST['name']);
    $email = mysqli_real_escape_string($conexion, (string) $_POST['email']);
    $password = mysqli_real_escape_string($conexion, (string) $_POST['password']);
    $rol = mysqli_real_escape_string($conexion, (int) $_POST['rol']);
    mysqli_close($conexion);
    registro("users",$name,$email,$password,$rol);
    ?>
        <script>
            Swal.fire(
            '¡Se ha creado!',
            'Se ha creado de manera correcta',
            'success'
            )
            </script>
        <script>
            timer: 8000,
            window.location.href = "./usuarios"
        </script>
        <?php
    ?>

    <?php
  }elseif(isset($_POST['actualizar'])){
    $conexion = conect_mysqli();
    $id = mysqli_real_escape_string($conexion, (int) $_POST['id']);
    $name = mysqli_real_escape_string($conexion, (string) $_POST['name']);
    $email = mysqli_real_escape_string($conexion, (string) $_POST['email']);
    $password = mysqli_real_escape_string($conexion, (string) $_POST['password']);
	  $password_encriptada = password_hash($password,PASSWORD_BCRYPT,["cost"=>10]);
    $rol = mysqli_real_escape_string($conexion, (int) $_POST['rol']);
    mysqli_close($conexion);
    actualizar_datos_mysqli("users","`name` = '$name', `email` = '$email',`password` = '$password_encriptada', `id_rol` = '$rol'","id",$id);
    ?>
        <script>
            Swal.fire(
            '¡Se ha actualizado!',
            'Se ha actualizado de manera correcta',
            'success'
            )
            </script>
        <script>
            timer: 8000,
            window.location.href = "./usuarios"
        </script>
        <?php
  }elseif(isset($_POST['modificar'])){
    $conexion = conect_mysqli();
    $id = mysqli_real_escape_string($conexion, (int) $_POST['txtID']);
    mysqli_close($conexion);
    $consulta = consulta_mysqli_where("*","users","id",$id);
    ?>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
              <label for="name" class="form-label">Nombre</label>
              <input type="text"
                class="form-control" name="name" id="name" aria-describedby="name" placeholder="Pon el nombre" value="<?php echo $consulta['name']; ?>">
              <small id="name" class="form-text text-muted">¿Cuál es su nombre?</small>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Correo</label>
              <input type="email"
                class="form-control" name="email" id="email" aria-describedby="email" placeholder="Pon el correo" value="<?php echo $consulta['email']; ?>">
              <small id="email" class="form-text text-muted">¿Cuál es el correo?</small>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password"
                class="form-control" name="password" id="password" aria-describedby="password" placeholder="Pon la contraseña a registrar">
              <small id="password" class="form-text text-muted">Pon la contraseña nueva de este usuario o repitala</small>
            </div>
            <div class="mb-3">
              <label for="rol" class="form-label">Rol </label>
              <input type="number"
                class="form-control" name="rol" id="rol" aria-describedby="rol" placeholder="Este es el rol del usuario" value="<?php echo $consulta['id_rol']; ?>">
              <small id="rol" class="form-text text-muted">Modifica con un rol existente</small>
            </div>
            <center>
                <button type="submit" name="actualizar" class="btn btn-success">Agregar</button>
            </center>
        </form>
    <?php
  }else{
    ?>
    <div id="register">
        <button class="btn btn-primary" onclick="closeForm();">Cancelar</button>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
            <div class="mb-3">
              <label for="name" class="form-label">Nombre</label>
              <input type="text"
                class="form-control" name="name" id="name" aria-describedby="name" placeholder="Pon el nombre">
              <small id="name" class="form-text text-muted">¿Cuál es su nombre?</small>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Correo</label>
              <input type="email"
                class="form-control" name="email" id="email" aria-describedby="email" placeholder="Pon el correo">
              <small id="email" class="form-text text-muted">¿Cuál es el correo?</small>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña </label>
              <input type="password"
                class="form-control" name="password" id="password" aria-describedby="password" placeholder="Pon la contraseña a registrar">
              <small id="password" class="form-text text-muted">Pon la contraseña nueva de este usuario</small>
            </div>
            <div class="mb-3">
          <label for="rol" class="form-label">Rol</label>
          <select class="form-control" name="rol" id="rol">
            <option selected>¿Cuál rol le corresponde?</option>
            <?php

              $conexion = conect_mysqli();

              $rol = "SELECT * FROM `roles`";

              if ($resultadosex = mysqli_query($conexion, $rol)) {
                  while ($registro1 = mysqli_fetch_array($resultadosex)) {
                      echo '<option value="' . $registro1['id'] .'">' . $registro1['rol'] .'</option>';
                  }
              }
              mysqli_close($conexion);
            ?>
          </select>
        </div>
            <center>
                <button type="submit" name="registrar" class="btn btn-success">Agregar</button>
            </center>
        </form>
    </div>
    <div id="login">
      <button class="btn btn-primary" onclick="registerForm();">Registrar nuevo usuario manualmente</button>
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
                <td><?php 
                if($row['created_at'] == NULL){
                  echo "No se registró.";
                }else{
                  echo $row['created_at']; 
                }
                ?></td>
                <td><?php 
                if($row['updated_at'] == NULL){
                  echo "No se registró.";
                }else{
                  echo $row['updated_at']; 
                }
                ?></td>
                <td>
                  <?php if($row['id'] != $iduser){?>
                    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
                      <input value="<?php echo $row['id']; ?>" type="hidden" name="txtID" id="txtID">
                      <button type="submit" name="modificar" class="btn btn-primary">Modificar</button>
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
