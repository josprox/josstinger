<?php
include (__DIR__ . "/../jossecurity.php");
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nombre_app; ?> - El hosting que tú necesitas</title>
    <?php head(); ?>
    <meta name="description" content="Aloja tu sitio web o aplicación web de manera segura,<?php echo $nombre_app; ?> es el mejor proveedor de hosting de México, consulta nuestros precios.">
</head>
<body>

    <?php navbar(); ?>

    <section class="home">
        <img src="../resourses/images/bg_1.jpg" class="filtro" alt="">

        <div class="encima">
            <div class="contenedor">
                <div class="grid_2_auto">
                    <div class="contenido">
                        <h1 class="text-shadow-black text-center titulo_encima">El hosting ideal para ti</h1>
                        <p class="text-shadow-black text-justify">Puedes elegir el plan de acuerdo a tus necesidades, Nuestro servidor protegrá tus sitios web en una plataforma 100% confiable.</p>
                        <div class="flex_center">
                            <a name="" id="" class="btn btn-primary" href="hosting" role="button">Conocer más</a>
                        </div>
                    </div>
                    <div class="contenido">
                        <img class="img_pequeña" src="../resourses/img/josstinger degradado/default.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="flex_center">
        <div class="contenedor">
            <div class="tarjeta-blanca">
                <h2 class="text-center titulo_card">La Garantía <?php echo $nombre_app; ?></h2>
                <p class="text-center">Obten el mejor servicio de hosting, <?php echo $nombre_app; ?> asegura tus sitios web, no te preocupes de nada.</p>
            </div>
            <div class="grid_3_auto">
                <div class="card_icono">
                    <div class="icono">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div class="contenido_card">
                        <h3>99.9% de tiempo de actividad</h3>
                        <p>Ya estuvo bueno de esos hosting que se caen a cada rato, tu sitio web será visible un 99.9% del tiempo.</p>
                    </div>
                </div>
                <div class="card_icono">
                    <div class="icono"><i class="fa-solid fa-shield-halved"></i></div>
                    <div class="contenido_card">
                        <h3>Seguro y protegido</h3>
                        <p>Nuestros servicios de hosting están alojados en el servidor de Oracle Cloud.</p>
                    </div>
                </div>
                <div class="card_icono">
                    <div class="icono"><i class="fa-solid fa-headset"></i></div>
                    <div class="contenido_card">
                        <h3>Gran soporte</h3>
                        <p>¿Tienes alguna duda? nosotros te podemos ayudar a crear tu sitio web de manera fácil y rápida.</p>
                    </div>
                </div>
                <div class="card_icono">
                    <div class="icono"><i class="fa-solid fa-download"></i></div>
                    <div class="contenido_card">
                        <h3>Instala en pocos clics</h3>
                        <p>Si a penas vas a iniciar tu mundo en la web, podrás instalar WordPress, laravel, Magneto, PrestaShop y otros de manera rápida.</p>
                    </div>
                </div>
                <div class="card_icono">
                    <div class="icono"><i class="fa-solid fa-gear"></i></div>
                    <div class="contenido_card">
                        <h3>DNS Control</h3>
                        <p>Gestiona tus DNS en un solo lugar, a demás estarás protegido ante ataques DDoS.</p>
                    </div>
                </div>
                <div class="card_icono">
                    <div class="icono"><i class="fa-solid fa-bolt"></i></div>
                    <div class="contenido_card">
                        <h3>Increible velocidad</h3>
                        <p>Te aseguramos una velocidad de carga increible en nuestro host.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contenedor">
        <?php include ("../routes/planes/planes.php"); ?>
    </section>

    <section class="info">
        <img src="../resourses/images/image_2.jpg" class="filtro" alt="">
        <div class="encima">
            <div class="contenedor">
                <div class="grid_1_auto">
                    <div class="contenido">
                        <h4>NUESTRAS METAS</h4>
                        <h1 class="text-shadow-black text-center">Satisfacer tus necesidades</h1>
                        <p class="text-shadow-black text-justify">Nosotros queremos que, el usuario tenga lo que él necesita, ni más ni menos, mientras nuestros clientes estén satisfechos nosotros nos damos por bien servidos.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include "../routes/hestia/preguntas.php"; footer(); ?>
    
</body>
</html>