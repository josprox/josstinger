<?php $pagina = nombre_de_pagina(); ?>
<nav class="navbar navbar-expand-sm fixed-top navbar_dashboard">
          <div class="container">
            <a class="navbar-brand" href="#"><?php echo $_ENV['NAME_APP']; ?></a>
            <button class="navbar-toggler  d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                    aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php if($pagina == "index.php"){ echo "active"; } ?>" href="./" aria-current="page">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($pagina == "suscripciones.php"){ echo "active"; } ?>" href="suscripciones">Suscripciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($pagina == "contratar.php"){ echo "active"; } ?>" href="contratar">Contratar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($pagina == "cuenta.php"){ echo "active"; } ?>" href="cuenta">Mi cuenta</a>
                    </li>
                </ul>
                <div class="flex_center">
                    <form role="search">
                        <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
                      </form>
                </div>
                <form class="d-flex my-2 my-lg-0" action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
                    <button class="btn btn-outline-light my-2 my-sm-0" style="width: 100%;" name ="salir" type="submit">Salir</button>
                </form>
            </div>
      </div>
    </nav>

    <br><br>