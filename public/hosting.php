<?php

include (__DIR__ . "/../jossecurity.php");

?>
<!DOCTYPE html>
<html lang="es-MX">
  <head>
    <title><?php echo $nombre_app; ?> - Hosting</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Consulta cómo contratar un hosting en <?php echo $nombre_app; ?>, tu hosting seguro.">
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
              <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="./">Inicio</a></span> <span>Web Hosting</span></p>
	            <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Web Hosting</h1>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-4 text-center ftco-animate">
    				<div class="steps">
    					<div class="icon mb-4 d-flex justify-content-center align-items-center">
    						<span class="flaticon-cloud-computing-1"></span>
    					</div>
    					<h3>Elige tu plan</h3>
    					<p>Para poder iniciar deberás elegir el plan que mas se ajuste a tus necesidades.</p>
    				</div>
    			</div>
    			<div class="col-md-4 text-center ftco-animate">
    				<div class="steps">
    					<div class="icon mb-4 d-flex justify-content-center align-items-center">
    						<span class="flaticon-account"></span>
    					</div>
    					<h3>Crea una cuenta</h3>
    					<p>Para poderte identificar te pedimos que crees una cuenta.</p>
    				</div>
    			</div>
    			<div class="col-md-4 text-center ftco-animate">
    				<div class="steps">
    					<div class="icon mb-4 d-flex justify-content-center align-items-center">
    						<span class="flaticon-web-page"></span>
    					</div>
    					<h3>Accede</h3>
    					<p>Te daremos tus credenciales de login para que puedas subir tu sitio web de una manera fácil y sencilla.</p>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>

    <?php include ("../routes/planes/planes.php"); ?>

    <section class="ftco-section">
    	<div class="container">
    		<div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <h2 class="mb-4">Preguntas frecuentes</h2>
            <p>Las siguientes son preguntas frecuentes que hacen los clientes.</p>
          </div>
        </div>
    		<div class="row">
    			<div class="col-md-12 ftco-animate">
    				<div id="accordion">
    					<div class="row">
    						<div class="col-md-6">
    							<div class="card">
						        <div class="card-header">
										  <a class="card-link" data-toggle="collapse"  href="#menuone" aria-expanded="true" aria-controls="menuone">¿Puedo usar mi dominio web? <span class="collapsed"><i class="icon-plus-circle"></i></span><span class="expanded"><i class="icon-minus-circle"></i></span></a>
						        </div>
						        <div id="menuone" class="collapse show">
						          <div class="card-body">
												<p>Claro, puedes usar tu dominio web sin transferirlo, solo deberás apuntar a nuestro servicio de DNS.</p>
						          </div>
						        </div>
						      </div>

						      <div class="card">
						        <div class="card-header">
										  <a class="card-link" data-toggle="collapse"  href="#menutwo" aria-expanded="false" aria-controls="menutwo">¿Cuáles dominios puedo usar? <span class="collapsed"><i class="icon-plus-circle"></i></span><span class="expanded"><i class="icon-minus-circle"></i></span></a>
						        </div>
						        <div id="menutwo" class="collapse">
						          <div class="card-body">
												<p>Nuestro sistema te permite usar cualquier dominio web que esté registrado en ICANN.</p>
						          </div>
						        </div>
						      </div>

						      <div class="card">
						        <div class="card-header">
										  <a class="card-link" data-toggle="collapse"  href="#menu3" aria-expanded="false" aria-controls="menu3">¿Ofrecen certificados? <span class="collapsed"><i class="icon-plus-circle"></i></span><span class="expanded"><i class="icon-minus-circle"></i></span></a>
						        </div>
						        <div id="menu3" class="collapse">
						          <div class="card-body">
												<p>Si tu contratas un hosting nosotros te permitimos generar un certificado SSL/TLS de aquellos dominios y subdominios que uses, también podrás usar un certificado externo.</p>
						          </div>
						        </div>
						      </div>
    						</div>

    						<div class="col-md-6">
    							<div class="card">
						        <div class="card-header">
										  <a class="card-link" data-toggle="collapse"  href="#menu4" aria-expanded="false" aria-controls="menu4">¡Puedo transferir mi domimnio con ustedes? <span class="collapsed"><i class="icon-plus-circle"></i></span><span class="expanded"><i class="icon-minus-circle"></i></span></a>
						        </div>
						        <div id="menu4" class="collapse">
						          <div class="card-body">
												<p>Actualmente no somos una entidad verificada por la ICANN para poder hacer uso de registros de dominios web pero, esto no te limita a poder usar nuestros DNS.</p>
						          </div>
						        </div>
						      </div>

						      <div class="card">
						        <div class="card-header">
										  <a class="card-link" data-toggle="collapse"  href="#menu5" aria-expanded="false" aria-controls="menu5">¿Cuánto tarda en preparase mi pedido? <span class="collapsed"><i class="icon-plus-circle"></i></span><span class="expanded"><i class="icon-minus-circle"></i></span></a>
						        </div>
						        <div id="menu5" class="collapse">
						          <div class="card-body">
												<p>El pedido se genera super rápido, todo dependerá de la velocidad en la cuál llegue tu pago a través de nuestras plataformas.</p>
						          </div>
						        </div>
						      </div>

						      <div class="card">
						        <div class="card-header">
										  <a class="card-link" data-toggle="collapse"  href="#menu6" aria-expanded="false" aria-controls="menu6">¿Cómo apunto mi dominio a sus servidores? <span class="collapsed"><i class="icon-plus-circle"></i></span><span class="expanded"><i class="icon-minus-circle"></i></span></a>
						        </div>
						        <div id="menu6" class="collapse">
						          <div class="card-body">
												<p>Tú puedes apuntar los nameservers al dominio que te daremos para poder configurarlo, sin embargo no es obligatorio hacer uso de nuestros propios DNS, si tu quieres tener tus DNS con tu provedor solo deberás crear manualmente los CNAME, registro A, AAAA y otros con la dirección web que te daremos.</p>
						          </div>
						        </div>
						      </div>
    						</div>
    					</div>
				    </div>
    			</div>
    		</div>
    	</div>
    </section>

	<?php footer(); ?>
    
  </body>
</html>