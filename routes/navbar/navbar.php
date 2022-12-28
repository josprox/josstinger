<?php $pagina = nombre_de_pagina(); ?>

	  <nav class="navbar navbar-expand-sm fixed-top navbar_dashboard">
          <div class="container">
            <a class="navbar-brand" href="./"><?php if(file_exists(__DIR__ . "/../../resourses/img/logo_hestia/vector/default-monochrome.svg")){?>
                <img src="../resourses/img/logo_hestia/vector/default-monochrome.svg" width="auto" height="24">
                <?php }else{
                    echo $_ENV['NAME_APP'];
                } ?>
            </a>
            <button class="navbar-toggler-custom  d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                    aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0 ">
                    <li class="nav-item">
                        <a class="nav-link <?php if($pagina == "index.php"){ echo "active"; } ?>" href="./" aria-current="page">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($pagina == "hosting.php"){ echo "active"; } ?>" href="hosting">Hosting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($pagina == "about.php"){ echo "active"; } ?>" href="about">Acerca de</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($pagina == "contact.php"){ echo "active"; } ?>" href="contact">Contacto</a>
                    </li>
                </ul>
                <form class="d-flex my-2 my-lg-0" action="" method="post">
                    <a class="btn btn-outline-light my-2 my-sm-0" style="width: 100%;" href="panel">Iniciar sesión</a>
                </form>
            </div>
      </div>
    </nav>