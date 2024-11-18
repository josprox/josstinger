<?php
require_once (__DIR__ . DIRECTORY_SEPARATOR . "../../jossecurity.php");
login_cookie('jpx_users');

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ./../panel");
}
if(isset($_GET['info'])){
    echo qrcode($_GET['info']);
}else{
    echo qrcode();
}

?>