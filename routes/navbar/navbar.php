<?php $pagina = nombre_de_pagina(); ?>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="./"><?php echo $_ENV['NAME_APP']; ?></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menú
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item <?php if($pagina == "index.php"){ echo "active"; } ?>"><a href="./" class="nav-link">Inicio</a></li>
	          <li class="nav-item <?php if($pagina == "hosting.php"){ echo "active"; } ?>"><a class="nav-link" href="hosting">Hosting</a></li>
	          <li class="nav-item <?php if($pagina == "about.php"){ echo "active"; } ?>"><a href="about" class="nav-link">Acerca de</a></li>
	          <li class="nav-item <?php if($pagina == "contact.php"){ echo "active"; } ?>"><a href="contact" class="nav-link">Contacto</a></li>
	          <li class="nav-item cta"><a href="panel" class="nav-link"><span>Acceder</span></a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>