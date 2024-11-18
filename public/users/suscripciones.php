<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie('jpx_users');

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ./../panel");
}

$iduser = $_SESSION['id_usuario'];

$row = consulta_mysqli_where("name","jpx_users","id",$iduser);

if (leer_tablas_mysql_custom("SELECT * FROM jpx_tokens_pays WHERE id_user = $iduser && estado = 'Aprobado';") <= 0 && leer_tablas_mysql_custom("SELECT * FROM jpx_tokens_pays WHERE id_user = $iduser && estado = 'Pendiente';") <= 0 && leer_tablas_mysql_custom("SELECT * FROM jpx_tokens_pays WHERE id_user = $iduser && estado = 'Actualizando';") <= 0){
    header("Location: ./");
}

eliminar_datos_custom_mysqli("DELETE FROM jpx_tokens_pays WHERE id_user = $iduser && estado = 'Cancelado'");

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
    
        echo eliminar_datos_con_where("jpx_tokens_pays","id",$id);
      }
    ?>

    <?php include (__DIR__ . "../../../routes/hestia/bienvenida.php") ?>

    <section class="contenedor">

        <div class="flex_center">

            <div class="grid_1_auto">

                <div class="tarjeta_contenido">
                    <h4 class="text-center">Tus productos</h4>
                    <p class="text-justify">Gestiona tus productos desde aquí.</p>
                    <div class="table-responsive">
                        <table class="table table-primary">
                            <thead>
                                <tr>
                                    <th scope="col">ID del producto</th>
                                    <th scope="col">Mis productos</th>
                                    <th scope="col">Fecha de contrato</th>
                                    <th scope="col">Fecha de expiración</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php
                            if(leer_tablas_mysql_custom("SELECT * FROM jpx_tokens_pays WHERE id_user = $iduser;")>=1){
                            foreach (arreglo_consulta("SELECT jpx_tokens_pays.id, jpx_servicios.nombre, jpx_tokens_pays.created_at,jpx_tokens_pays.expiracion FROM jpx_servicios INNER JOIN jpx_tokens_pays ON jpx_servicios.id = jpx_tokens_pays.id_servicio WHERE id_user = $iduser ORDER BY id DESC;") as $row){?>
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
                                        <a name="" id="" class="btn btn-primary" href="producto?id=<?php echo $row['id']; ?>" role="button">Conocer más</a>
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
                    </div>
                    
                </div>

            </div>

        </div>

    </section>

    <?php include ("../../routes/hestia/preguntas.php"); footer_users(); ?>
    
</body>
</html>
