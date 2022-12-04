<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ./../panel");
}

$iduser = $_SESSION['id_usuario'];

$row = consulta_mysqli_where("*","users","id",$iduser);

if (leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser && estado = 'Aprobado';") <= 0 && leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser && estado = 'Pendiente';") <= 0 && leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser && estado = 'Actualizando';") <= 0){
    header("Location: ./");
}

eliminar_datos_custom_mysqli("DELETE FROM tokens_pays WHERE id_user = $iduser && estado = 'Cancelado'");

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
    if(isset($_POST['actualizar_info'])){
      $conexion = conect_mysqli();
      $name = mysqli_real_escape_string($conexion, (string) $_POST['name']);
      $email = mysqli_real_escape_string($conexion, (string) $_POST['correo']);
      $password = mysqli_real_escape_string($conexion, (string) $_POST['contra']);
      mysqli_close($conexion);
      $consulta = consulta_mysqli_where("password","users","id",$iduser);
      if(password_verify($password,(string) $consulta['password']) == TRUE){
        actualizar_datos_mysqli('users',"`name` = '$name', `email` = '$email'","id",$iduser);
        echo "
        <script>
            Swal.fire(
            'Completado',
            'Se ha actualizado todo de manera correcta.',
            'success'
            )
        </script>
        <script type='text/javascript'>
          window.location.href = 'cuenta';
        </script>
        ";
      }
    }
      
    if(isset($_POST['update_password'])){
        $conexion = conect_mysqli();
      
        $password = mysqli_real_escape_string($conexion, (string) $_POST['password']);
        $password_new = mysqli_real_escape_string($conexion, (string) $_POST['password_new']);
        $password_repeat = mysqli_real_escape_string($conexion, (string) $_POST['password_repeat']);
        $row = consulta_mysqli_where("password","users","id",$iduser);
        $password_encrypt = $row['password'];
      
        if(password_verify($password, (string) $password_encrypt) == TRUE){
          if ($password_new == $password_repeat){
              $password_encriptada = password_hash($password_new,PASSWORD_BCRYPT,["cost"=>10]);
            actualizar_datos_mysqli('users',"`password` = '$password_encriptada'",'id',$iduser);
            echo "
            <script>
                Swal.fire(
                'Completado',
                'Se ha actualizado todo de manera correcta.',
                'success'
                )
            </script>
            <script type='text/javascript'>
              window.location.href = 'cuenta';
            </script>
            ";
          }else{
            echo "
            <script>
                Swal.fire(
                'Falló',
                'Las nuevas contraseñas no son las mismas.',
                'error'
                )
            </script>
            <script type='text/javascript'>
              window.location.href = 'cuenta';
            </script>
            ";
          }
        }else{
            echo "
            <script>
                Swal.fire(
                'Falló',
                'La contraseña original no es la correcta.',
                'error'
                )
            </script>
            <script type='text/javascript'>
              window.location.href = 'cuenta';
            </script>
            ";
        }
      
        mysqli_close($conexion);
    }
    ?>

    <div class="container">
    <h2 align="center">Modifica tu información</h2>
    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">

      <div class="mb-3">
        <label for="id" class="form-label"><i class="fa fa-id-badge" aria-hidden="true"></i></label>
        <input type="text"
          class="form-control" name="id" id="id" aria-describedby="id" disabled placeholder="ID" value="<?php echo $row['id']; ?>">
        <small id="id" class="form-text text-muted">Mi ID</small>
      </div>

      <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" class="form-control" name="name" id="name" aria-describedby="name" placeholder="Nombre" value="<?php echo $row['name']; ?>">
        <small id="name" class="form-text text-muted">Nombre registrado</small>
      </div>

      <div class="mb-3">
        <label for="correo" class="form-label">Correo</label>
        <input type="text" class="form-control" name="correo" id="correo" aria-describedby="correo" placeholder="correo" value="<?php echo $row['email']; ?>">
        <small id="correo" class="form-text text-muted">Correo Registrado</small>
      </div>

      <div class="mb-3">
        <div class="mb-3">
          <label for="contra" class="form-label">Contraseña</label>
          <input type="text"
            class="form-control" name="contra" id="contra" aria-describedby="contra" placeholder="Pon la contraseña" required>
          <small id="contra" class="form-text text-muted">Para poder modificar tus datos favor de poner la contraseña.</small>
        </div>
      </div>

      <div class="mb-3 row">
        <div class="offset-sm-4 col-sm-8">
          <button type="submit" name="actualizar_info" class="btn btn-primary">Actualizar información personal</button>
        </div>
      </div>
    </form>

    <h2 align="center">Modificar contraseña</h2>

    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">

      <div class="mb-3 row">
        <label for="password" class="form-label">Pon tu contraseña actual</label>
        <input type="password" class="form-control" name="password" id="password" aria-describedby="password" placeholder="contraseña">
        <small id="password" class="form-text text-muted">Pon tu contraseña</small>
      </div>

      <div class="mb-3 row">
        <label for="password_new" class="form-label">Pon la nueva contraseña</label>
        <input type="password"
          class="form-control" name="password_new" id="password_new" aria-describedby="password_new" placeholder="nueva contraseña">
        <small id="password_new" class="form-text text-muted">Escribe la nueva contraseña</small>
      </div>

      <div class="mb-3 row">
        <label for="password_repeat" class="form-label">Repite la nueva contraseña</label>
        <input type="password"
          class="form-control" name="password_repeat" id="password_repeat" aria-describedby="password_repeat" placeholder="repite la contraseña">
        <small id="password_repeat" class="form-text text-muted">Escribe la nueva contraseña</small>
      </div>

      <div class="mb-3 row">
        <div class="offset-sm-4 col-sm-8">
          <button type="submit" name="update_password" class="btn btn-primary">Actualizar contraseña</button>
        </div>
      </div>

    </form>

  </div>

    <?php footer_users(); ?>
    
</body>
</html>
