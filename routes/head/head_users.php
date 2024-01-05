<!-- JosSecurity está funcionando -->

    <!-- JQUERY -->
    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>

    <link rel="shortcut icon" href="../../resourses/img/logo_hestia/vector/default.svg" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- Dashboard -->
    <?php
        $fecha_cliente = new fecha_cliente();
        if($fecha_cliente -> hora_24() >= "18:01" && $fecha_cliente -> hora_24() <= "24:00"){
        ?>
        <link rel="stylesheet" href="../../resourses/scss/dark_dashboard.css">
        <?php
        }else{
            ?>
        <link rel="stylesheet" href="../../resourses/scss/dashboard.css">
        <?php
        }
    ?>
    <!-- Fontawesome -->
    <link rel="stylesheet" href="../../node_modules/@fortawesome/fontawesome-free/css/all.min.css" defer>
    <!-- SweetAlert2 -->
    <script src="../../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>