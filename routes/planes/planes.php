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

				<div class="col-lg-4 col-md-6 ftco-animate">
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