<?php

function mercado_pago($titulo_del_producto,$cantidad,$precio,$moneda,$ruta_pago_completado,$ruta_pago_fallido,$ruta_pago_pendiente){
    $access_token=$_ENV['MERCADO_PAGO_ACCESS_TOKEN'];
    MercadoPago\SDK::setAccessToken($access_token);
    $preferencia = new MercadoPago\Preference();
    $preferencia->back_urls=["success" => $_ENV['DOMINIO'].$_ENV['HOMEDIR'].$ruta_pago_completado, "failure" => $_ENV['DOMINIO'].$_ENV['HOMEDIR']. $ruta_pago_fallido, "pending" => $_ENV['DOMINIO'] .$_ENV['HOMEDIR']. $ruta_pago_pendiente];
    $preferencia -> auto_return = "approved";
    $productos = [];
    $item = new MercadoPago\Item();
    $item->title = $titulo_del_producto;
    $item->quantity = $cantidad;
    $item->unit_price = $precio;
    $item->currency_id = $moneda;
    array_push($productos,$item);

    $preferencia ->items=$productos;
    $preferencia->save();
    return $preferencia->init_point;
}

?>