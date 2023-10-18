<?php
require_once (__DIR__ . DIRECTORY_SEPARATOR . "../../jossecurity.php");
login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../panel");
}

$iduser = $_SESSION['id_usuario'];

secure_auth_admin($iduser,"../");

if(isset($_GET['info'])){
    echo qrcode($_GET['info']);
}else{
    echo qrcode();
}

?>