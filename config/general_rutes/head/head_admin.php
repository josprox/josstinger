<!-- JosSecurity está funcionando -->
<meta name="viewport" content= "width=device-width, user-scalable=no">
<!-- JQUERY -->
<script src="../../node_modules/jquery/dist/jquery.min.js"></script>

<link rel="shortcut icon" href="../../resourses/img/logo transparente/vector/default.svg" type="image/x-icon">
<!-- Bootstrap -->
<link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
<!-- hestia -->
<?php
$fecha_cliente = new fecha_cliente();
if($fecha_cliente -> hora_24() >= "18:01" && $fecha_cliente -> hora_24() <= "24:00"){
  ?>
  <link rel="stylesheet" href="../../resourses/scss/dark_mode.css">
  <?php
}else{
  ?>
  <link rel="stylesheet" href="../../resourses/scss/hestia.css">
  <?php
}
?>
<!-- Fontawesome -->
<link rel="stylesheet" href="../../node_modules/@fortawesome/fontawesome-free/css/all.min.css" defer>
<!-- SweetAlert2 -->
<script src="../../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

<!-- Video.js base CSS -->
<link href="../../resourses/css/video-js.min.css" rel="stylesheet">

<!-- RichText -->
<link rel="stylesheet" href="../../node_modules/richtext_for_npm/src/richtext.min.css">
<script src="../../node_modules/richtext_for_npm/src/jquery.richtext.min.js"></script>

<?php

if($_ENV['RECAPTCHA'] == 1){?>

<script src="https://www.google.com/recaptcha/api.js"></script>

<?php
  }
  if(file_exists(__DIR__ . "/../../../routes/head/head_admin.php")){
    include (__DIR__ . "/../../../routes/head/head_admin.php");
  }
?>