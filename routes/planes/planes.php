<section class="app_josstinger">
        <div class="flex_center">
            <div class="contenedor">
                <div class="grid_2_auto">
                    <div class="app_josstinger_info">
                        <h2>Conoce <?php echo $_ENV['NAME_APP']; ?></h2>
                        <h3>El hosting que tú necesitas</h3>
                        <p align="justify">Aloja tu sitio web o aplicación web de manera segura, <?php echo $_ENV['NAME_APP']; ?> es el mejor proveedor de hosting de México, consulta nuestros precios.</p>
                        <div class="app_josstinger_appgallery">
                            <div class="img_appgallery">
                                <img src="../resourses/img/Huawei_AppGallery.svg.png" alt="">
                            </div>
                            <div class="text_appgallery">
                                <p>Desde ahora puedes descargar nuestra aplicación nativa en AppGallery gratis.</p>
                            </div>
                        </div>
                    </div>
                    <div class="contenedor">
                        <div class="app_josstinger_youtube flex_center">
                            <iframe class="app_josstinger_youtube_video" src="https://www.youtube.com/embed/-Mu2YuQABLA" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <center>
                            <div class="grid_1">
                                <a class="btn btn_transparente" href="https://appgallery.huawei.com/app/C107358057" target="_blank" rel="noopener noreferrer">Ir a AppGallery</a>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </section>
	<div class="contenedor">

		<section class="ftco-section bg-light">
			<div class="container">
				<div class="row justify-content-center mb-5 pb-3">
			  <div class="col-md-7 text-center heading-section ftco-animate">
				<span class="subheading">Nuestros Planes</span>
				<h2 class="mb-4">Al mejor precio</h2>
			  </div>
			</div>
				<div class="row d-flex">
	
				<?php 
				foreach(arreglo_consulta("SELECT nombre, descripcion,precio FROM servicios") as $row){
					?>
	
					<div class="col-lg-3 col-md-6 ftco-animate" id="<?php echo $row['nombre']; ?>">
					  <div class="block-7">
						<div class="text-center">
							<h2 class="heading"><?php echo $row['nombre']; ?></h2>
							<span class="price"><sup>$USD</sup> <span class="number"><?php echo $row['precio']; ?></span></span>
							
							<?php echo $row['descripcion'] ?>
							<a href="panel" class="btn btn-primary d-block px-3 py-3 mb-4">Elegir plan</a>
						</div>
					  </div>
					</div>
					
					<?php
				} ?>
	
			  </div>
			</div>
		</section>
		
	</div>
