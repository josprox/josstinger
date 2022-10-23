<?php

include (__DIR__ . "/../jossecurity.php");

?>
<!DOCTYPE html>
<html lang="es_MX">
  <head>
    <title><?php echo $nombre_app; ?> - Acerca de</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Conoce a <?php echo $nombre_app; ?> y sus soluciones de hosting, el mejor en calidad - precio.">
    <?php head(); ?>
  </head>
  <body>
    
	  <?php navbar(); ?>

    <section class="home-slider owl-carousel">
      <div class="slider-item bread-item" style="background-image: url(../resourses/images/bg_1.jpg);" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container-fluid">
          <div class="row slider-text align-items-center justify-content-center" data-scrollax-parent="true">

            <div class="col-md-8 mt-5 text-center col-sm-12 ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
              <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="./">Inicio</a></span> <span>Acerca de</span></p>
	            <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Acerca de</h1>
            </div>
          </div>
        </div>
      </div>
    </section>
  
    <section class="ftco-section bg-light">
    	<div class="container">
    		<div class="row d-md-flex">
	    		<div class="col-md-6 ftco-animate img about-image" style="background-image: url(../resourses/images/about.jpg);">
	    		</div>
	    		<div class="col-md-6 ftco-animate p-md-5">
		    		<div class="row">
		          <div class="col-md-12 nav-link-wrap mb-5">
		            <div class="nav ftco-animate nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
		              <a class="nav-link active" id="v-pills-whatwedo-tab" data-toggle="pill" href="#v-pills-whatwedo" role="tab" aria-controls="v-pills-whatwedo" aria-selected="true">¿Quienes somos?</a>

		              <a class="nav-link" id="v-pills-mission-tab" data-toggle="pill" href="#v-pills-mission" role="tab" aria-controls="v-pills-mission" aria-selected="false">Misión</a>

		              <a class="nav-link" id="v-pills-goal-tab" data-toggle="pill" href="#v-pills-goal" role="tab" aria-controls="v-pills-goal" aria-selected="false">Creador</a>
		            </div>
		          </div>
		          <div class="col-md-12 d-flex align-items-center">
		            
		            <div class="tab-content ftco-animate" id="v-pills-tabContent">

		              <div class="tab-pane fade show active" id="v-pills-whatwedo" role="tabpanel" aria-labelledby="v-pills-whatwedo-tab">
		              	<div>
			                <h2 class="mb-4">Un servicio de Hosting</h2>
			              	<p>Estamos ofreciendo un increible servicio de hosting para que tú puedas montar tu sitio web de una manera fácil y sencilla.</p>
				            </div>
		              </div>

		              <div class="tab-pane fade" id="v-pills-mission" role="tabpanel" aria-labelledby="v-pills-mission-tab">
		                <div>
			                <h2 class="mb-4">Satisfacer tus necesidades</h2>
			              	<p>Nosotros queremos que, el usuario tenga lo que él necesita, ni más ni menos, mientras nuestros clientes estén satisfechos nosotros nos damos por bien servidos.</p>
				            </div>
		              </div>

		              <div class="tab-pane fade" id="v-pills-goal" role="tabpanel" aria-labelledby="v-pills-goal-tab">
		                <div>
			                <h2 class="mb-4">El Diamante</h2>
			              	<p>Este servicio es proporcionado por JOSPROX MX | Internacional y cumple con todas las regularidades de hosting, nosotros ocupamos nuestros mismos servicios para poderte mostrar nuestros productos de "El Diamante".</p>
				            </div>
		              </div>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>
    	</div>
    </section>

    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <h2 class="mb-4">Equipo especialista</h2>
            <p>El equipo que monta el servicio <?php echo $nombre_app; ?> está especializado para poderte ofrecer el mejor Hosting</p>
          </div>
        </div>
      </div>
    </section>

    <?php footer(); ?>
    
  </body>
</html>