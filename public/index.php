<?php

include (__DIR__ . "/../jossecurity.php");

?>
<!DOCTYPE html>
<html lang="es-MX">
  <head>
    <title><?php echo $nombre_app; ?> tu hosting seguro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Aloja tu sitio web o aplicación web de manera segura,<?php echo $nombre_app; ?> es el mejor proveedor de hosting de México, consulta nuestros precios.">
    <?php head(); ?>
  </head>
  <body>
    
	  <?php navbar(); ?>
    <!-- END nav -->

    <section class="home-slider owl-carousel">
      <div class="slider-item" style="background-image: url(../resourses/images/bg_1.jpg);">
        <div class="overlay"></div>
        <div class="container-fluid">
          <div class="row slider-text align-items-center" data-scrollax-parent="true">

            <div class="col-md-5 wrap col-sm-12 ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
              <h1 class="mb-4 mt-5" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Aloja tus archivos</h1>
              <p class="mb-4 mb-md-5 sub-p" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Nuestro servidor protegerá tus sitios web en una plataforma 100% confiable.</p>
              <p><a href="#home" class="btn btn-primary p-3 px-xl-5 py-xl-3">Vamos allá</a> <a href="./hosting" class="btn btn-primary btn-primary-2 p-3 px-xl-5 py-xl-3">Leer más</a></p>
            </div>
            <div class="col-md-7 ftco-animate">
            	<img src="../resourses/images/dashboard_full_1.png" class="img-fluid" alt="">
            </div>

          </div>
        </div>
      </div>

      <div class="slider-item" style="background-image: url(../resourses/images/bg_2.jpg);">
        <div class="overlay"></div>
        <div class="container-fluid">
          <div class="row slider-text align-items-center" data-scrollax-parent="true">

            <div class="col-md-5 wrap col-sm-12 ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
              <h1 class="mb-4 mt-5" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">El hosting ideal para ti</h1>
              <p class="mb-4 mb-md-5">Puedes elegir entre diferentes planes de acuerdo a tus necesidades.</p>
              <p><a href="#home" class="btn btn-primary p-3 px-xl-5 py-xl-3">Vamos allá</a> <a href="./hosting" class="btn btn-primary btn-primary-2 p-3 px-xl-5 py-xl-3">Leer más</a></p>
            </div>
            <div class="col-md-7 ftco-animate">
            	<img src="../resourses/images/dashboard_full_3.png" class="img-fluid" alt="">
            </div>

          </div>
        </div>
      </div>
    </section>
  
    <section class="ftco-section services-section bg-light" id="home">
      <div class="container">
      	<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <h2 class="mb-4">La Garantía <?php echo $nombre_app; ?></h2>
            <p>Obten el mejor servicio de hosting, <?php echo $nombre_app; ?> asegura tus sitios web, no te preocupes de nada.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block text-center">
              <div class="d-flex justify-content-center">
              	<div class="icon d-flex align-items-center justify-content-center">
              		<span class="flaticon-guarantee"></span>
              	</div>
              </div>
              <div class="media-body p-2 mt-3">
                <h3 class="heading">99.9% de tiempo de actividad</h3>
                <p>Ya estuvo bueno de esos hosting que se caen a cada rato, tu sitio web será visible un 99.9% del tiempo.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-4 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block text-center">
              <div class="d-flex justify-content-center">
              	<div class="icon d-flex align-items-center justify-content-center">
              		<span class="flaticon-shield"></span>
              	</div>
              </div>
              <div class="media-body p-2 mt-3">
                <h3 class="heading">Seguro y protegido</h3>
                <p>Nuestros servicios de hosting están alojados en el servidor de Oracle Cloud.</p>
              </div>
            </div>    
          </div>
          <div class="col-md-4 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block text-center">
              <div class="d-flex justify-content-center">
              	<div class="icon d-flex align-items-center justify-content-center">
              		<span class="flaticon-support"></span>
              	</div>
              </div>
              <div class="media-body p-2 mt-3">
                <h3 class="heading">Gran soporte</h3>
                <p>¿Tienes alguna duda? nosotros te podemos ayudar a crear tu sitio web de manera fácil y rápida.</p>
              </div>
            </div>      
          </div>
					<div class="col-md-4 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block text-center">
              <div class="d-flex justify-content-center">
              	<div class="icon d-flex align-items-center justify-content-center">
              		<span class="flaticon-cloud-computing"></span>
              	</div>
              </div>
              <div class="media-body p-2 mt-3">
                <h3 class="heading">Instala en pocos clics</h3>
                <p>Si a penas vas a iniciar tu mundo en la web, podrás instalar WordPress, laravel, Magneto, PrestaShop y otros de manera rápida.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-4 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block text-center">
              <div class="d-flex justify-content-center">
              	<div class="icon d-flex align-items-center justify-content-center">
              		<span class="flaticon-settings"></span>
              	</div>
              </div>
              <div class="media-body p-2 mt-3">
                <h3 class="heading">DNS Control</h3>
                <p>Gestiona tus DNS en un solo lugar, a demás estarás protegido ante ataques DDoS.</p>
              </div>
            </div>    
          </div>
          <div class="col-md-4 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block text-center">
              <div class="d-flex justify-content-center">
              	<div class="icon d-flex align-items-center justify-content-center">
              		<span class="flaticon-loading"></span>
              	</div>
              </div>
              <div class="media-body p-2 mt-3">
                <h3 class="heading">Increible velocidad</h3>
                <p>Te aseguramos una velocidad de carga increible en nuestro host.</p>
              </div>
            </div>      
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-counter img" id="section-counter" style="background-image: url(../resourses/images/bg_1.jpg);" data-stellar-background-ratio="0.5">
    	<div class="container">
    		<div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
            <span class="subheading">Más de 100.000 sitios web alojados en Oracle Cloud</span>
          </div>
        </div>
    		<div class="row justify-content-center">
    			<div class="col-md-10">
		    		<div class="row">
		          <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number" data-number="2000">0</strong>
		                <span>Instalaciones CMS</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number" data-number="100">0</strong>
		                <span>Protección</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number" data-number="32000">0</strong>
		                <span>Usuarios registrados en Oracle Cloud</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number" data-number="31998">0</strong>
		                <span>Usuarios satisfechos</span>
		              </div>
		            </div>
		          </div>
		        </div>
	        </div>
        </div>
    	</div>
    </section>

    <?php include ("../routes/planes/planes.php"); ?>

    <section class="ftco-section testimony-section">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
            <span class="subheading">Nuestras metas</span>
            <h2 class="mb-4">Satisfacer tus necesidades</h2>
            <p>Nosotros queremos que, el usuario tenga lo que él necesita, ni más ni menos, mientras nuestros clientes estén satisfechos nosotros nos damos por bien servidos.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-partner">
    	<div class="container">
    		<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
            <h2 class="mb-4">Nuestros clientes</h2>
            <p><?php echo $_ENV['NAME_APP']; ?> fue creado por JOSPROX MX | Internacional, esto le asegura la calidad "El Diamante" así que, trabajamos con las siguientes empresas de acuerdo a sus necesidades.</p>
          </div>
        </div>
    		<div class="row">
    			<div class="col-sm ftco-animate">
    				<a href="https://josprox.com/acerca-de/" class="partner"><img src="https://josprox.com/wp-content/uploads/2022/09/AWS-logo.png" class="img-fluid" alt="Colorlib Template"></a>
    			</div>
    			<div class="col-sm ftco-animate">
    				<a href="https://josprox.com/acerca-de/" class="partner"><img src="https://josprox.com/wp-content/uploads/2022/09/Cloudflare-logo.png" class="img-fluid" alt="Colorlib Template"></a>
    			</div>
    			<div class="col-sm ftco-animate">
    				<a href="https://josprox.com/acerca-de/" class="partner"><img src="https://josprox.com/wp-content/uploads/2022/09/hostinger-logo.png" class="img-fluid" alt="Colorlib Template"></a>
    			</div>
    			<div class="col-sm ftco-animate">
    				<a href="https://josprox.com/acerca-de/" class="partner"><img src="https://josprox.com/wp-content/uploads/2022/09/ionos-logo-letra.png" class="img-fluid" alt="Colorlib Template"></a>
    			</div>
    			<div class="col-sm ftco-animate">
    				<a href="https://josprox.com/acerca-de/" class="partner"><img src="https://josprox.com/wp-content/uploads/2022/09/Oracle-Cloud-Logo.png" class="img-fluid" alt="Colorlib Template"></a>
    			</div>
    		</div>
    	</div>
    </section>


  <?php footer(); ?>
    
  </body>
</html>