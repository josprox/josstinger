<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../users/");
}

$iduser = $_SESSION['id_usuario'];

$row = consulta_mysqli_where("name","users","id",$iduser);

if(!isset($_GET['payment_id']) && !isset($_GET['status']) && !isset($_GET['payment_type']) && !isset($_GET['merchant_order_id'])){
    header("Location: ./");
}

$id_user_pay= $_GET['usr'];
$id_product= $_GET['prdct'];
$consulta = consulta_mysqli_custom_all("SELECT id from tokens_pays WHERE id_user = $id_user_pay && id_servicio = $id_product;");
$token = $_GET['token'];
$id_token = $consulta['id'];

$id_de_pago = $_GET['payment_id'];
$estado_de_pago = $_GET['status'];
$tipo_de_pago = $_GET['payment_type'];
$id_del_pedido = $_GET['merchant_order_id'];

$meses= (int)$_GET['mut'];


if(leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE token = '$token' && id_user = $iduser;") <= 0){
    header("Location: ./bienvenidos");
}
if(leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE token = '$token' && id_user = $iduser;") <= 0){
    header("Location: ./");
}
insertar_datos_custom_mysqli("UPDATE `tokens_pays` SET `id_pedido` = '$id_del_pedido', `id_pago` = '$id_de_pago', `pagado_con` = '$tipo_de_pago', `updated_at` = '$fecha' WHERE `tokens_pays`.`token` = '$token'");

$consulta_fecha = consulta_mysqli_custom_all("SELECT DATE_ADD(expiracion, interval $meses month) FROM tokens_pays WHERE id = $id_token;");
$nueva_fecha = $consulta_fecha["DATE_ADD(expiracion, interval $meses month)"];
insertar_datos_custom_mysqli("UPDATE `tokens_pays` SET `expiracion` = '$nueva_fecha' WHERE `tokens_pays`.`id` = $id_token");

header("Location: producto?id=$id_token");

?>