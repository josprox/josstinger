<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie('jpx_users');

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../users/");
}

$iduser = $_SESSION['id_usuario'];

$consulta = new GranMySQL();
$consulta -> seleccion = "name";
$consulta -> tabla = "jpx_users";
$consulta -> comparar = "id";
$consulta -> comparable = $iduser;
$row = $consulta -> where();

if(!isset($_GET['payment_id']) && !isset($_GET['status']) && !isset($_GET['payment_type']) && !isset($_GET['merchant_order_id'])){
    header("Location: ./");
}

$id_user_pay= $_GET['usr'];
$id_product= $_GET['prdct'];
$consulta = consulta_mysqli_custom_all("SELECT id from jpx_tokens_pays WHERE id_user = $id_user_pay && id_servicio = $id_product;");
$token = $_GET['token'];
$id_token = $consulta['id'];

$id_de_pago = $_GET['payment_id'];
$estado_de_pago = $_GET['status'];
$tipo_de_pago = $_GET['payment_type'];
$id_del_pedido = $_GET['merchant_order_id'];

$meses= (int)$_GET['mut'];
$new_token = generar_llave_alteratorio(16);

$clasic_id_pedido = $_GET['back_order'];

if(leer_tablas_mysql_custom("SELECT * FROM jpx_tokens_pays WHERE token = '$token' && id_user = $iduser;") <= 0){
    header("Location: ./bienvenidos");
}
if(leer_tablas_mysql_custom("SELECT * FROM jpx_tokens_pays WHERE token = '$token' && id_user = $iduser;") <= 0){
    header("Location: ./");
}
insertar_datos_custom_mysqli("UPDATE jpx_tokens_pays SET id_pedido = $id_del_pedido, id_pago = $id_de_pago, pagado_con = '$tipo_de_pago', updated_at = '$fecha' WHERE id = $id_token;");
actualizar_datos_mysqli("jpx_request_dns","`id_pedido` = $id_del_pedido","id_pedido",$clasic_id_pedido);
$consulta_fecha = consulta_mysqli_custom_all("SELECT DATE_ADD(expiracion, interval $meses month) FROM jpx_tokens_pays WHERE id = $id_token;");
$nueva_fecha = $consulta_fecha["DATE_ADD(expiracion, interval $meses month)"];
insertar_datos_custom_mysqli("UPDATE `jpx_tokens_pays` SET `token` = '$new_token',`expiracion` = '$nueva_fecha' WHERE `jpx_tokens_pays`.`id` = $id_token");
if($_GET['status'] == "in_process"){
insertar_datos_custom_mysqli("UPDATE `jpx_tokens_pays` SET `estado` = 'Actualizando' WHERE `jpx_tokens_pays`.`id` = $id_token");
}
header("Location: producto?id=$id_token");

?>