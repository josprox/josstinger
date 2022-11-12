<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ./../panel");
}

$iduser = $_SESSION['id_usuario'];

$row = consulta_mysqli_where("name","users","id",$iduser);

if(leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser && estado = 'Aprobado';") >= 1 OR leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser && estado = 'Actualizando';") >= 1 OR leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser && estado = 'Pendiente';") >= 1){
    header("Location: ./");
}

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

<?php
if (isset($_POST['eliminar'])){
    $conexion = conect_mysqli();
    $id = mysqli_real_escape_string($conexion, $_POST['txtID']);
    mysqli_close($conexion);
    eliminar_datos_con_where("tokens_pays","id_user",$id);
    echo eliminar_cuenta_con_cookies($id,"users","../");
    
  }
?>

    <section class="bienvenida">
        <div class="contenedor">
            <h2 class="text-center text-shadow-black">Hola <?php echo $row['name']; ?></h2>
            <hr>
            <h3 class="text-center">Bienvenido al panel de control de <?php echo $_ENV['NAME_APP']; ?></h3>
            <center>
                <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $iduser; ?>">
                    <button type="submit" name="eliminar" class="btn btn-danger">Eliminar datos de mi cuenta</button>
                </form>
            </center>
        </div>
    </section>

    <section class="contenedor">

        <div class="flex_center">

            <div class="grid_1_auto">

                <div class="tarjeta_contenido">
                    <h1 class="text-center">Selecciona tu plan</h1>
                    <p class="text-justify">Muchas gracias por elegirnos, para poder continuar te pediremos que selecciones un plan de hosting, después podrás contratar el servicio a través de mercado pago.<br>
                    Recuerda que solo podrás comprar tu hosting, próximamente te podremos vender un dominio web.😁</p>
                    <div class="checkout">
                        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" class="col-select">

                        <div class="mb-3">
                            <label for="" class="form-label">Selecciona un producto.</label>
                            <select class="form-select form-select-lg" name="servicio" id="" required>
                                <option selected value="">Selecciona uno</option>
                                <?php 
                                foreach(arreglo_consulta("SELECT id,nombre FROM servicios") as $row){
                                    ?>

                                <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                    
                                    <?php
                                } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                          <label for="meses" class="form-label">Cuántos meses lo quieres contratar</label>
                          <input type="number"
                            class="form-control" name="meses" id="meses" aria-describedby="meses" placeholder="Pon los meses" value="1" required>
                          <small id="meses" class="form-text text-muted">Selecciona los meses de su contrato</small>
                        </div>

                        <div >
                            <button type="submit" name="select" class="btn btn-primary">Seleccionar</button>
                        </div>
                                    
                        </form>
                        <div class="col-datos">
                            <h2 class="text-shadow-white text-center">Tu pedido</h2>
                            <?php
                            include (__DIR__ . "../../../config/mercado_pago_hestia.php");
                            ?>
                        </div>
                    </div>
                </div>

                <div class="tarjeta_contenido">
                    <div class="row d-flex">
                    <?php 
                    foreach(arreglo_consulta("SELECT nombre, descripcion,precio FROM servicios") as $row){
                        ?>

                        <div class="col-lg-4 col-md-6 ftco-animate">
                        <div class="block-7">
                            <div class="text-center">
                                <h2 class="heading"><?php echo $row['nombre']; ?></h2>
                                <span class="price"><sup>$USD</sup> <span class="number"><?php echo $row['precio']; ?></span></span>
                                
                                <?php echo $row['descripcion'] ?>
                            </div>
                        </div>
                        </div>
                        
                        <?php
                    } ?>
                    </div>
                </div>
                    
                </div>
                
            </div>
            
        </section>
        
    <?php footer_users(); ?>
    
</body>
</html>