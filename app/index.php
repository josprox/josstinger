<?php 

  require(__DIR__ . DIRECTORY_SEPARATOR . "../jossecurity.php"); 
  if (isset($_SESSION['id_usuario'])) {
      $id_user_session = $_SESSION['id_usuario'];
      cookie_session($id_user_session,ruta."admin/",ruta."users/");
  }

  login_cookie("users");
?>
<!DOCTYPE html>
<html lang="es-MX" >
<head>
  <?php head(); ?>
  <meta charset="UTF-8">
  <title>Cetis CWP App</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
  <link rel="stylesheet" href="./style.css">
  <!-- Metas -->
  <link rel="shortcut icon" href="./../ps-contenido/app img/default.png" type="image/x-icon">
  <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Se bienvenido al panel de Alumnos, generado para que los alumnos puedan convivir con sus maestros de una manera muy segura.">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <script src="https://kit.fontawesome.com/4a5e39d1d1.js" crossorigin="anonymous"></script>

  <!-- Barra del navegador -->
  <meta name="theme-color" content="#7deb6c">
  <!-- Optimizado para moviles -->
  <meta name="MobileOptimized" content="width">
  <meta name="HandheldFriendly" content="true">
  <!-- Meta etiquetas par apple -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <!-- Iconos importantes -->
  <link rel="apple-touch-icon" href="./../ps-contenido/app img/profile.png">
  <link rel="apple-touch-startup-image" href="./../ps-contenido/app img/cover.png">
  <!-- Archivo de manifiesto app -->
  <link rel="manifest" href="./../manifest.json">

</head>
<body>

<!-- partial:index.partial.html -->
<div class="container">
  <div class="info">
    <h1>Cetis CWP</h1><span>Creado con <i class="fa fa-heart"></i> por <a href="http://josprox.com">JOSPROX MX | internacional</a></span>
  </div>
</div>
<div class="form">
  <div class="thumbnail"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/hat.svg"/></div>
  <form class="register-form" action="" method="POST">
  <label for="nombre">¿Cuál es tu nombre?</label>
    <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
    <label for="correo">¿Cuál es tu correo?</label>
    <input type="text" name="correo" id="correo" placeholder="Correo" required>
    <label for="contra">¿Cuál será tu Contraseña?</label>
    <input type="password" name="contra" id="contra" placeholder="Contraseña" required>
    <label for="recontra">Repite la contraseña</label>
    <input type="password" name="recontra" id="recontra" placeholder="Contraseña" required>

    <button name="registrar" type="submit">crear</button>
    <p class="message" >¿Ya estás registrado? <a>Iniciar sesión</a></p>
  </form>

  <form class="login-form" action="" method="POST">
    <input name="correo" type="text" placeholder="usuario"/>
    <input name="contra" type="password" placeholder="Contraseña"/>
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
      <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>
    </div>
    <button name="ingresar" type="submit">Iniciar sesión</button>
    <p class="message">¿No estás registrado? <a>Crear una cuenta</a></p>
  </form>

</div>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script  src="./script.js"></script>

</body>
</html>