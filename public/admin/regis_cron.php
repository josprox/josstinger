<?php
include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../panel");
}
$iduser = $_SESSION['id_usuario'];
secure_auth_admin($iduser,"../");
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros de Josscron - <?php echo $nombre_app; ?></title>
    <?php head_admin(); ?>
</head>
<body>

    <?php navbar_admin(); ?>


    <!-- inicio del sistema -->

    <div class="container">
        <br>
    <?php
        if(isset($_POST['eliminar'])){
            $conexion = conect_mysqli();
            $id_funcion = mysqli_real_escape_string($conexion, (int)$_POST['eliminar_funcion']);
            $conexion -> close();
            //echo $id_funcion;
            echo eliminar_datos_con_where("tareas","id",$id_funcion);
            ?>
            <script>
                timer: 8000,
                window.location.href = "./regis_cron"
            </script>
            <?php
        }
    ?>
        <div class="table-responsive-sm">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Jossito</th>
                        <th scope="col">Siguiente fecha de ejecución</th>
                        <th scope="col">Creado el día</th>
                        <th scope="col">Actualizado el día</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach(arreglo_consulta("SELECT * FROM tareas") AS $row){
                        ?>
                        <form action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
                        <tr class="">
                            <td scope="row"><?php echo $row['id']; ?></td>
                            <td><?php echo $row['funcion']; ?></td>
                            <td><?php echo $row['sig_fecha']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td><?php echo $row['updated_at']; ?></td>
                            <input type="hidden" name="eliminar_funcion" value="<?php echo $row['id']; ?>">
                            <td><button type="submit" class="btn btn-warning" name="eliminar">Eliminar</button></td>
                        </tr>
                        </form>
                        <?php
                    }?>
                </tbody>
            </table>
        </div>
    </div>

    <?php footer_admin(); ?>
    
</body>
</html>