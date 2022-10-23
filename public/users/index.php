<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ./../panel");
}

$iduser = $_SESSION['id_usuario'];

if(leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser && estado = 'Completado';") <= 0){
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
        $id = mysqli_real_escape_string($conexion, $_POST['txtID']);
        mysqli_close($conexion);
    
        echo eliminar_datos_con_where("tokens_pays","id",$id);
      }
    ?>

    <?php include (__DIR__ . "../../../routes/hestia/bienvenida.php") ?>

    <section class="contenedor">

        <div class="flex_center">

            <div class="grid_2_auto">

                <div class="capsula">
                    <div class="tarjeta_contenido">
                        <h4 class="text-center">Gestiona tus DNS en tu hosting</h4>
                        <p class="text-justify">Tu puedes gestionar tus DNS con nosotros, en cada paquete viene como mínimo 1 gestor dns, solo deberás apuntar nos nameservers a los siguientes dominios</p>
                        <ul>
                            <li>Nameserver 1: dns10.josprox.ovh</li>
                            <li>Nameserver 2: ns10.josprox.ovh</li>
                        </ul>
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
                            <?php if (leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser;")>3){
                                ?>
                             <a class="btn btn-primary" href="suscripciones">Ver todos mis productos</a>
                                <?php
                             } ?>
                        </div>
                        
                    </div>
                </div>

            </div>

        </div>

    </section>

    <?php footer_users(); ?>
    
</body>
</html>