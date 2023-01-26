<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ./../panel");
}

$iduser = $_SESSION['id_usuario'];

if(leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser && estado = 'Aprobado';") <= 0 && leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser && estado = 'Pendiente';") <= 0 && leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser && estado = 'Actualizando';") <= 0){
    header("Location: ./bienvenidos");
}

eliminar_datos_custom_mysqli("DELETE FROM tokens_pays WHERE id_user = $iduser && estado = 'Cancelado'");

$row = consulta_mysqli_where("name","users","id",$iduser);

?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nombre_app; ?> - Escritorio</title>
    <?php head_users(); ?>
</head>
<body>

    <?php navbar_users(); ?>

    <?php
    if (isset($_POST['eliminar'])){
        $conexion = conect_mysqli();
        $id = mysqli_real_escape_string($conexion, (int) $_POST['txtID']);
        mysqli_close($conexion);
    
        echo eliminar_datos_con_where("tokens_pays","id",$id);
      }
    ?>

    <?php include (__DIR__ . "../../../routes/hestia/bienvenida.php") ?>

    <main class="flex_center">
        <?php
        $consulta_fecha_del_usuario = new fecha_cliente();
        ?>
        <div class="tarjeta_del_momento <?php if($consulta_fecha_del_usuario -> hora_24() >= "18:01" && $consulta_fecha_del_usuario -> hora_24() <= "24:00"){
            echo "fondo_oscuro";
        }else{
            echo "fondo_blanco";
        } ?>">
            <?php
            if($consulta_fecha_del_usuario -> hora_24() >= "00:00" && $consulta_fecha_del_usuario -> hora_24() <= "12:00"){
                ?>
                <div class="contenido_momento">Buenos días, espero que cada día sea increible para ti.</div>
                <div class="contenido_icono"><i class="fa-solid fa-cloud-sun"></i></div>
                <?php
            }elseif($consulta_fecha_del_usuario -> hora_24() >= "12:01" && $consulta_fecha_del_usuario -> hora_24() <= "18:00"){
                ?>
                <div class="contenido_momento">Buenas tardes, ya falta poco para terminar el día, échale ganas.</div>
                <div class="contenido_icono"><i class="fa-solid fa-sun"></i></div>
                <?php
            }elseif($consulta_fecha_del_usuario -> hora_24() >= "18:01"){
                ?>
                <div class="contenido_momento">Buenas Noches, ojalá hayas disfrutado tu día.</div>
                <div class="contenido_icono"><i class="fa-solid fa-moon"></i></div>
                <?php
            }
            ?>
        </div>
    </main>

    <h2 class="subtitulos">Recomentaciones</h2>

    <div class="media-scroller">
        <a class="anuncio_scroller" href="https://josprox.com/">¿Necesitas ayuda para crear tu sitio web? conoce El Diamante Soluciones TI</a>
        <a class="anuncio_scroller" href="https://josprox.com/tienda/">Consigue plugins para WordPress con licencia GPL</a>
        <?php
        $ssl = check_http();
        $json_string = file_get_contents("https://josprox.com/entradas.json");
        // Convierte la cadena de texto en un array
        $array = json_decode($json_string, true);
        $count = 0;
        foreach($array as $row){
            ?>
            <a class="anuncio_scroller" href="<?php echo $row['guid']; ?>"><?php echo $row['post_title']; ?></a>
            <?php
            $count ++;
            if($count == 15){
                ?>
                <div class="flex_center">
                    <a name="" id="" class="btn btn-primary" href="#" role="button">Ver más</a>
                </div>
                <?php
                break;
            }
        }
        ?>
    </div>

    <section class="contenedor">

        <div class="flex_center">

            <div class="grid_2_auto">

                <div class="capsula">
                    <div class="tarjeta_contenido">
                        <h4 class="text-center">Gestiona tus DNS en tu hosting</h4>
                        <p class="text-justify">Tu puedes gestionar tus DNS con nosotros, en cada paquete viene como mínimo 1 gestor dns, solo deberás apuntar nos nameservers a los siguientes dominios</p>
                        <?php
                            foreach(arreglo_consulta("SELECT id_pedido FROM request_dns WHERE id_user = $iduser ORDER BY id DESC LIMIT 3") as $pedido){
                                $pedido_num = $pedido['id_pedido'];
                                foreach(arreglo_consulta("SELECT nameservers.id,nameservers.dns1,nameservers.dns2 FROM nameservers INNER JOIN request_dns ON nameservers.id = request_dns.id_nameserver WHERE id_pedido = $pedido_num;" ) as $name){
                                    ?>
                            <p>DNS correspondiente del pedido: <?php echo $pedido_num; ?></p>
                            <ul>
                                <li>Nameserver 1: <?php echo $name['dns1']; ?></li>
                                <li>Nameserver 2: <?php echo $name['dns2']; ?></li>
                            </ul>
                                    <?php
                                }
                            }
                            ?>
                    </div>
                </div>
                <div class="capsula">

                    <div class="tarjeta_contenido">
                        <h4 class="text-center">Tus productos</h4>
                        <p class="text-justify">Gestiona tus productos desde aquí.</p>
                        <div class="table-responsive">
                            <table class="table table-primary">
                                <thead>
                                    <tr>
                                        <th scope="col">ID del servicio</th>
                                        <th scope="col">Mis productos</th>
                                        <th scope="col">Fecha de contrato</th>
                                        <th scope="col">Fecha de expiración</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                <?php
                                if(leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser;")>=1){
                                foreach (arreglo_consulta("SELECT tokens_pays.id, servicios.nombre, tokens_pays.created_at,tokens_pays.expiracion FROM servicios INNER JOIN tokens_pays ON servicios.id = tokens_pays.id_servicio WHERE id_user = $iduser ORDER BY id DESC LIMIT 3;") as $row){?>
                                <tr class="table-primary" >
                                    <td scope="row"><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['nombre']; ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['expiracion']; ?></td>
                                    <td>
                                    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
                                        <input value="<?php echo $row['id']; ?>" type="hidden" name="txtID" id="txtID">
                                        <?php 
                                        if ($row['expiracion'] == ""){
                                            ?>
                                            <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                                            <?php
                                        }elseif($row['expiracion'] != ""){
                                            ?>
                                            <a name="" id="" class="btn btn-primary" href="producto?id=<?php echo $row['id']; ?>" role="button">consultar</a>
                                            <?php
                                        } ?>
                                    </form>
                                </td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
    
                                </tbody>
                            </table>
                            <?php if (leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser;")>=3){
                                ?>
                                <div class="flex_center">
                                    <a class="btn btn-primary" href="suscripciones">Ver todos mis productos</a>
                                </div>
                                <?php
                             } ?>
                        </div>
                        
                    </div>
                </div>


            </div>

        </div>

    </section>

    <?php include ("../../routes/hestia/preguntas.php"); footer_users(); ?>
    
</body>
</html>
