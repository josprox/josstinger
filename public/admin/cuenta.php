<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../panel");
}

$iduser = $_SESSION['id_usuario'];

secure_auth_admin($iduser,"../");
$cst = new GranMySQL();
$cst -> seleccion = "*";
$cst -> tabla = "users";
$cst -> comparar = "id";
$cst -> comparable = $iduser;
$row = $cst -> where();

if(isset($_POST['actualizar_info'])){

  $conexion = conect_mysqli();

  $name = mysqli_real_escape_string($conexion, (string) $_POST['name']);
  $email = mysqli_real_escape_string($conexion, (string) $_POST['correo']);
  $password = mysqli_real_escape_string($conexion, (string) $_POST['contra']);
  $phone = mysqli_real_escape_string($conexion, (string) $_POST['phone']);
  if(isset($_POST['factor'])){
    $fa= "A";
  }else{
    $fa = "D";
  }
  $type_fa = mysqli_real_escape_string($conexion, (string) $_POST['type_fa']);
  mysqli_close($conexion);
  $consulta = consulta_mysqli_where("password","users","id",$iduser);
  if(password_verify($password,(string) $consulta['password']) == TRUE){
    actualizar_datos_mysqli('users',"`name` = '$name', `email` = '$email', `phone` = '$phone', `fa` = '$fa', `type_fa` = '$type_fa'","id",$iduser);
  }
  header("refresh:1;");
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
    }
  }
  $conexion-> close();
}
if(isset($_POST['2FAGA'])){
  $conexion = conect_mysqli();
  //llave
  $llave = mysqli_real_escape_string($conexion, (string) $_POST['llave']);
  //codigo
  $codigo = mysqli_real_escape_string($conexion, (string) $_POST['codigo']);
  //checker
  validarToken($iduser,$llave,$codigo);
}
if(isset($_POST['2fadesactivar'])){
  $cst->seleccion = "fa";
  $info = $cst -> where();
  if($info['fa'] == "A"){
    actualizar_datos_mysqli("users","`fa` = 'A', `type_fa` = 'correo', `two_fa` = ''","id",$iduser);
  }else{
    actualizar_datos_mysqli("users","`fa` = 'D', `type_fa` = 'correo', `two_fa` = ''","id",$iduser);
  }
  header("refresh:1;");
}

?>

<!doctype html>
<html lang="es-MX">

<head>
  <title><?php echo $nombre_app," versión: ", $version_app; ?></title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <?php head_admin(); ?>

</head>

<body>

  <?php navbar_admin(); ?>

  <br>

  <div class="container">
    <h2 align="center">Modifica tu información</h2>

    <div class="auth_dashboard">
      <div class="dash">
        <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
    
          <div class="grid_3_auto">
    
            <div class="mb-3 contenedor">
              <label for="id" class="form-label"><i class="fa fa-id-badge" aria-hidden="true"></i></label>
              <input type="text"
                class="form-control" name="id" id="id" aria-describedby="id" disabled placeholder="ID" value="<?php echo $row['id']; ?>">
              <small id="id" class="form-text text-muted">Mi ID</small>
            </div>
      
            <div class="mb-3 contenedor">
              <label for="name" class="form-label">Nombre</label>
              <input type="text" class="form-control" name="name" id="name" aria-describedby="name" placeholder="Nombre" value="<?php echo $row['name']; ?>" required>
              <small id="name" class="form-text text-muted">Nombre registrado</small>
            </div>
      
            <div class="mb-3 contenedor">
              <label for="correo" class="form-label">Correo</label>
              <input type="text" class="form-control" name="correo" id="correo" aria-describedby="correo" placeholder="correo" value="<?php echo $row['email']; ?>" required>
              <small id="correo" class="form-text text-muted">Correo Registrado</small>
            </div>
      
            <div class="mb-3 contenedor">
              <label for="phone" class="form-label">Número de telefono</label>
              <input type="tel" class="form-control" name="phone" id="phone" aria-describedby="phone" placeholder="+5255XXXXXXXX" value="<?php echo $row['phone']; ?>">
            </div>
    
            <div class="mb-3 contenedor">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" <?php if($row['fa'] == "A"){echo "checked";} ?> name="factor" id="factor">
                <label class="form-check-label" for="factor">¿Desea Activar la seguridad extrema?</label>
              </div>
              <div class="mb-3">
                <label for="type_fa" class="form-label">Seleccione el metodo de seguridad</label>
                <select class="form-select form-select-sm" name="type_fa" id="type_fa">
                  <option selected value="correo">Correo</option>
                  <?php
                  if(isset($_ENV['TWILIO']) && $_ENV['TWILIO'] == 1 && $row['phone'] != ""){
                    ?>
                    <option value="sms">SMS</option>
                    <?php
                  }
                  ?>
                  <option value="GG">Google Auth</option>
                </select>
              </div>
            </div>
            
            <div class="mb-3 contenedor">
              <div class="mb-3">
                <label for="contra" class="form-label">Contraseña</label>
                <input type="text"
                  class="form-control" name="contra" id="contra" aria-describedby="contra" placeholder="Pon la contraseña" required>
                <small id="contra" class="form-text text-muted">Para poder modificar tus datos favor de poner la contraseña.</small>
              </div>
            </div>
    
          </div>
    
          <div class="flex_center">
            <div class="mb-3">
                <button type="submit" name="actualizar_info" class="btn btn-primary">Actualizar información personal</button>
            </div>
          </div>
    
        </form>
      </div>
      <div class="auth">
        <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
          <h3>Activa la seguridad 2FA</h3>
          <?php
            if($row['two_fa'] == NULL){
              $datos = DatosGA($row['email']);
              ?>
              <div class="grid_2_auto">
                <img src="../../resourses/img/Authenticator.webp" alt="">
                <img src="<?php echo ruta . "qrcode?info=" . $datos['url'] ; ?>" alt="">
              </div>
              <p>Te recomendamos activar la seguridad 2FA, por favor escane el QR que ve a continuación (beta) o registre el siguiente código en su aplicación de 2FA, puede hacerlo con Google Authenticator, Authy, etc.</p>
              <div class="mb-3">
                <input type="hidden" name="llave" value="<?php echo $datos['secretKey']; ?>">
                <input type="text"
                  class="form-control" id="url" aria-describedby="url" placeholder="Aquí está la clave" value="<?php echo $datos['url']; ?>" disabled>
                <small id="url" class="form-text text-muted">Registra la clave que se muestra a continuación en tu app.</small>
              </div>
              <div class="mb-3">
                <input type="number"
                  class="form-control" name="codigo" id="codigo" aria-describedby="codigo" placeholder="Pon el codigo que aparece en tu aplicación.">
                <small id="codigo" class="form-text text-muted">Aquí deberás poner el código que aparece en tu app.</small>
              </div>
              <div class="flex_center">
                <button type="submit" name="2FAGA" class="btn btn-info">Guardar</button>
              </div>
              <?php
            }elseif($row['type_fa'] != "GG" && $row['two_fa'] != NULL){
              ?>
              <img src="../../resourses/img/Authenticator.webp" alt="">
              <h3>Sistema 2FA</h3>
              <p>Ya puede activar como metodo de seguridad Google 2FA.😉</p>
              <div class="flex_center">
                <button name="2fadesactivar" type="submit" class="btn btn-primary">Desactivar</button>
              </div>
              <?php
            }elseif($row['type_fa'] == "GG" && $row['two_fa'] != NULL){
              ?>
              <img src="../../resourses/img/Authenticator.webp" alt="">
              <h3>Sistema 2FA</h3>
              <p>Actualmente ya tienes activado 2FA en tu cuenta.😉</p>
              <div class="flex_center">
                <button name="2fadesactivar" type="submit" class="btn btn-primary">Desactivar</button>
              </div>
              <?php
            }
          ?>
        </form>
      </div>
    </div>


    <h2 align="center">Modificar contraseña</h2>

    <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">

      <div class="grid_3_auto">
        <div class="mb-3 contenedor">
          <label for="password" class="form-label">Pon tu contraseña actual</label>
          <input type="password" class="form-control" name="password" id="password" aria-describedby="password" placeholder="contraseña">
          <small id="password" class="form-text text-muted">Pon tu contraseña</small>
        </div>
  
        <div class="mb-3 contenedor">
          <label for="password_new" class="form-label">Pon la nueva contraseña</label>
          <input type="password"
            class="form-control" name="password_new" id="password_new" aria-describedby="password_new" placeholder="nueva contraseña">
          <small id="password_new" class="form-text text-muted">Escribe la nueva contraseña</small>
        </div>
  
        <div class="mb-3 contenedor">
          <label for="password_repeat" class="form-label">Repite la nueva contraseña</label>
          <input type="password"
            class="form-control" name="password_repeat" id="password_repeat" aria-describedby="password_repeat" placeholder="repite la contraseña">
          <small id="password_repeat" class="form-text text-muted">Escribe la nueva contraseña</small>
        </div>
      </div>

      <div class="flex_center">
        <div class="mb-3">
          <div class="offset-sm-4 col-sm-8">
            <button type="submit" name="update_password" class="btn btn-primary">Actualizar contraseña</button>
          </div>
        </div>
      </div>

    </form>

  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
</body>
</html>
