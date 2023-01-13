<meta name="viewport" content= "width=device-width, user-scalable=no">
<?php
// Aquí va el head_users propio
if(file_exists(__DIR__ ."/../../../routes/head/head_users.php")){
    include (__DIR__ ."/../../../routes/head/head_users.php");
}
if(isset($_ENV['ONESIGNAL']) && $_ENV['ONESIGNAL'] == 1){
    if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "../../../plugins/onesignal/head.php")){
      include (__DIR__ . DIRECTORY_SEPARATOR . "../../../plugins/onesignal/head.php");
    }
  }
?>