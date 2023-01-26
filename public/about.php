<?php
include (__DIR__ . "/../jossecurity.php");
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nombre_app; ?> - Contáctanos</title>
    <meta name="description" content="Conoce a <?php echo $nombre_app; ?> y sus soluciones de hosting, el mejor en calidad - precio.">
    <?php head(); ?>
</head>
<body>

    <?php navbar(); ?>

    <section class="secction">
        <img src="../resourses/img/backgroud/pexels-luis-gomes-546819.jpg" class="filtro" alt="">
        <div class="encima">
            <div class="contenedor">
                <div class="grid_1_auto">
                    <div class="contenido">
                        <p>Inicio <i class="fa-solid fa-arrow-right-long"></i> <a href="about">Acerca de</a></p>
                        <h1 class="text-shadow-black text-center">Acerca de</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contenedor">
        <div class="grid_2_auto">
            <div>
                <img class="img_mediana" src="../resourses/images/image_3.webp" alt="">
            </div>
            <div class="tarjeta-blanca">
                <h2>¿Quienes somos?</h2>
                <h3>Un servicio de Hosting</h3>
                <p align="justify">Estamos ofreciendo un increible servicio de hosting para que tú puedas montar tu sitio web de una manera fácil y sencilla, el sistema funciona gracias al panel de control de "Hestia CP".</p>
            </div>
        </div>
        <div class="grid_2_auto">
            <div class="tarjeta-blanca">
                <h2>Misión</h2>
                <h3>Satisfacer tus necesidades</h3>
                <p align="justify">Nosotros queremos que, el usuario tenga lo que él necesita, ni más ni menos, mientras nuestros clientes estén satisfechos nosotros nos damos por bien servidos.</p>
            </div>
            <div>
                <img class="img_mediana" src="../resourses/images/image_2.webp" alt="">
            </div>
        </div>
        <div class="grid_2_auto">
            <div>
                <img class="img_mediana" src="../resourses/images/image_4.webp" alt="">
            </div>
            <div class="tarjeta-blanca">
                <h2>Creador</h2>
                <h3>El Diamante</h3>
                <p align="justify">Este sistema es proporcionado por JOSPROX MX | Internacional y cumple con todas las regularidades de hosting, nosotros ocupamos nuestros mismos servicios para poderte mostrar nuestros productos de "El Diamante Soluciones TI".</p>
            </div>
        </div>
    </section>    

    <?php include "../routes/hestia/preguntas.php"; cookie(); footer(); ?>
    
</body>
</html>