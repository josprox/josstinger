<?php

if(isset($_POST['renovar'])){
    $conexion = conect_mysqli();
    $servicio = $consulta['id_servicio'];
    $id_producto = $consulta['id'];
    $meses = (int)mysqli_real_escape_string($conexion, $_POST['meses']);
    mysqli_close($conexion);
    $rows = consulta_mysqli_where("nombre,precio","servicios","id",$servicio);
    $precio = $rows['precio'];
    $total = $precio * $meses;
    $token_new = generar_llave_alteratorio(16);
    insertar_datos_custom_mysqli("UPDATE `tokens_pays` SET `token` = '$token_new' WHERE `tokens_pays`.`id` = $id_producto");
    $preference_id = mercado_pago($rows['nombre'],$meses,$precio,"USD","users/renovar?token=$token_new&usr=$iduser&prdct=$servicio&mut=$meses","users/falla?usr=$iduser","users/pendiente");
    foreach(arreglo_consulta("SELECT nombre,descripcion FROM servicios WHERE id = $servicio") as $row){
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
        $servicio = (int)mysqli_real_escape_string($conexion, $_POST['servicio']);
    }
    $meses = (int)mysqli_real_escape_string($conexion, $_POST['meses']);
    mysqli_close($conexion);
    $rows = consulta_mysqli_where("nombre,precio","servicios","id",$servicio);
    $precio = $rows['precio'];
    $total = $precio * $meses;
    $token = generar_llave_alteratorio(16);
    insertar_datos_custom_mysqli("INSERT INTO `tokens_pays` (`id`, `token`, `estado`, `id_user`, `id_servicio`, `id_pedido`, `id_pago`, `pagado_con`, `created_at`, `updated_at`) VALUES (NULL, '$token', 'Cancelado', '$iduser', '$servicio', NULL, NULL, NULL, '$fecha', NULL);");
    $preference_id = mercado_pago($rows['nombre'],$meses,$precio,"USD","users/hestia_config?token=$token&usr=$iduser&prdct=$servicio&mut=$meses","users/falla?usr=$iduser","users/pendiente");
    foreach(arreglo_consulta("SELECT nombre,descripcion FROM servicios WHERE id = $servicio") as $row){
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