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
$id_user_pay = $_GET['usr'];
eliminar_datos_custom_mysqli("DELETE FROM tokens_pays WHERE id_user = $id_user_pay && estado = 'Cancelado'");
header("Location: ./");
?>