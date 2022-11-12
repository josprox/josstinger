<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ./../panel");
}

$iduser = $_SESSION['id_usuario'];

$row = consulta_mysqli_where("name","users","id",$iduser);

if (leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser && estado = 'Aprobado';") <= 0 && leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser && estado = 'Pendiente';") <= 0 && leer_tablas_mysql_custom("SELECT * FROM tokens_pays WHERE id_user = $iduser && estado = 'Actualizando';") <= 0){
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

    <?php navbar_users(); ?>

    <?php include (__DIR__ . "../../../routes/hestia/bienvenida.php") ?>

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