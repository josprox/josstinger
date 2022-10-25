<?php
include (__DIR__ . "/../jossecurity.php");
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nombre_app; ?> - Planes de hosting</title>
    <meta name="description" content="Consulta cómo contratar un hosting en <?php echo $nombre_app; ?>, tu hosting seguro.">
    <?php head(); ?>
</head>
<body>

    <?php navbar(); ?>

    <section class="secction">
        <img src="../resourses/img/backgroud/pexels-pixabay-270348.jpg" class="filtro" alt="">
        <div class="encima">
            <div class="contenedor">
                <div class="grid_1_auto">
                    <div class="contenido">
                        <p>Inicio <i class="fa-solid fa-arrow-right-long"></i> <a href="hosting">hosting</a></p>
                        <h1 class="text-shadow-black text-center">Web Hosting</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="flex_center">
        <div class="contenedor">

            <div class="grid_3_auto">
                <div class="card_icono">
                    <div class="icono">
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <div class="contenido_card">
                        <h3>Elige tu plan</h3>
                        <p>Para poder iniciar deberás elegir el plan que mas se ajuste a tus necesidades.</p>
                    </div>
                </div>
                <div class="card_icono">
                    <div class="icono"><i class="fa-regular fa-user"></i></div>
                    <div class="contenido_card">
                        <h3>Crea una cuenta</h3>
                        <p>Para poderte identificar te pedimos que crees una cuenta.</p>
                    </div>
                </div>
                <div class="card_icono">
                    <div class="icono"><i class="fa-solid fa-headset"></i></div>
                    <div class="contenido_card">
                        <h3>Accede</h3>
                        <p>Te daremos tus credenciales de login para que puedas subir tu sitio web de una manera fácil y sencilla.</p>
                    </div>
                </div>
                
            </div>

        </div>
    </section>

    <section class="contenedor">
      <?php include "../routes/planes/planes.php"; include "../routes/hestia/preguntas.php";  ?>
    </section>

    <?php footer(); ?>
    
</body>
</html>