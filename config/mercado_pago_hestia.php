<?php

if(isset($_POST['renovar'])){
    $conexion = conect_mysqli();
    $servicio = $consulta['id_servicio'];
    $id_producto = $consulta['id'];
    $meses = (int)mysqli_real_escape_string($conexion, (int) $_POST['meses']);
    mysqli_close($conexion);
    $rows = consulta_mysqli_where("nombre,precio","jpx_servicios","id",$servicio);
    $precio = $rows['precio'];
    $total = $precio * $meses;
    $id_pedido = $consulta['id_pedido'];
    $token_new = generar_llave_alteratorio(16);
    insertar_datos_custom_mysqli("UPDATE `jpx_tokens_pays` SET `token` = '$token_new' WHERE `jpx_tokens_pays`.`id` = $id_producto");
    $preference_id = mercado_pago($rows['nombre'],1,$total,"USD","users/renovar?token=$token_new&usr=$iduser&prdct=$servicio&mut=$meses&back_order=$id_pedido","users/falla?usr=$iduser","users/renovar?token=$token_new&usr=$iduser&prdct=$servicio&mut=$meses&back_order=$id_pedido");
    foreach(arreglo_consulta("SELECT nombre,descripcion FROM jpx_servicios WHERE id = $servicio") as $row){
        ?>
        <div class="block-7">
            <div class="text-center">
                <h2 class="heading"><?php echo $row['nombre']; ?></h2>
                <span class="price"><sup>$USD</sup> <span class="number"><?php echo $total; ?></span></span>
                
                <?php echo $row['descripcion'] ?>
            </div>
        </div>
        <form action="" method="post">
            <center>
                <a href="<?php echo $preference_id; ?>" class="btn btn-success">Pagar con Mercado Pago</a>
            </center>
        </form>
        <?php
    }
}
if(isset($_POST['select'])){
    $conexion = conect_mysqli();
    if($_POST['servicio'] == ""){
        $servicio = 1;
    }else{
        $servicio = (int)mysqli_real_escape_string($conexion, (int) $_POST['servicio']);
    }
    $meses = (int)mysqli_real_escape_string($conexion, (int) $_POST['meses']);
    mysqli_close($conexion);
    $rows = consulta_mysqli_where("nombre,precio","jpx_servicios","id",$servicio);
    $precio = $rows['precio'];
    $total = $precio * $meses;
    $token = generar_llave_alteratorio(16);
    insertar_datos_custom_mysqli("INSERT INTO `jpx_tokens_pays` (`id`, `token`, `estado`, `id_user`, `id_servicio`, `id_pedido`, `id_pago`, `pagado_con`, `created_at`, `updated_at`) VALUES (NULL, '$token', 'Cancelado', '$iduser', '$servicio', NULL, NULL, NULL, '$fecha', NULL);");
    $preference_id = mercado_pago($rows['nombre'],1,$total,"USD","users/hestia_config?token=$token&usr=$iduser&prdct=$servicio&mut=$meses","users/falla?usr=$iduser","users/hestia_config?token=$token&usr=$iduser&prdct=$servicio&mut=$meses");
    foreach(arreglo_consulta("SELECT nombre,descripcion FROM jpx_servicios WHERE id = $servicio") as $row){
        ?>
        <div class="block-7">
            <div class="text-center">
                <h2 class="heading"><?php echo $row['nombre']; ?></h2>
                <span class="price"><sup>$USD</sup> <span class="number"><?php echo $total; ?></span></span>
                
                <?php echo $row['descripcion'] ?>
            </div>
        </div>
        <form action="" method="post">
            <center>
                <a href="<?php echo $preference_id; ?>" class="btn btn-success">Pagar con Mercado Pago</a>
            </center>
        </form>
        <?php
    }
}
?>
