<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../panel");
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
      if (isset($_POST["registrar"])){
        echo registro("users",$_POST['name'],$_POST['email'],$_POST['password'],$_POST['rol']);
      }

    ?>

    <div class="container">
      <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST">

        <div class="mb-3 row">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" class="form-control" name="name" id="name" aria-describedby="name" placeholder="Nombre" required>
          <small id="name" class="form-text text-muted">Pon tu nombre</small>
        </div>

        <div class="mb-3 row">
          <label for="email" class="form-label">Correo</label>
          <input type="email" class="form-control" name="email" id="email" aria-describedby="email" placeholder="email" required>
          <small id="email" class="form-text text-muted">Pon tu correo</small>
        </div>

        <div class="mb-3 row">
          <label for="password" class="form-label">Contraseña</label>
          <input type="text" class="form-control" name="password" id="password" aria-describedby="password" placeholder="password">
          <small id="password" class="form-text text-muted">Inserta la contraseña</small>
        </div>

        <div class="mb-3 row">
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

        <div class="mb-3 row">
          <div class="offset-sm-4 col-sm-8">
            <button type="submit" name="registrar" class="btn btn-primary">Registrar usuario</button>
          </div>
        </div>

      </form>
    </div>

  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
</body>

</html>