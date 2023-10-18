    <?php

        $url = explode("/", $_SERVER['SCRIPT_NAME']);
        $url = array_reverse($url);
        $url = $url[0];

        if ($url == 'index.php') {
            $url = 'Inicio';
        }
        if ($url == 'perfil.php') {
            $url = 'Perfil';
        }
        if ($url == 'publicaciones.php') {
            $url = 'Publicaciones';
        }
        if ($url == 'post.php') {
            $url = 'Entrada';
        }

    ?>
    <div class="inicio">
        <div class="titulo">
            <h1><?php echo $url; ?></h1>
        </div>
        <div class="nav">
            <ul class="nav_ul">
                <a href="perfil">
                    <li><i class="fa-solid fa-user"></i></li>
                </a>
                <a class="settings_open">
                    <li><i class="fa-solid fa-gear"></i></li>
                </a>
            </ul>

        </div>
    </div>