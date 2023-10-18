<!-- JosSecurity footer está funcionando -->
<?php
$pagina = nombre_de_pagina();
if($pagina == "panel.php"){
    ?>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="./../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <?php
}elseif($pagina != "panel.php"){
    ?>
    <!-- Aquí va el footer personalizado -->
    <?php
    if(file_exists(__DIR__ . "/../../../routes/footer/footer.php")){
        include __DIR__ . "/../../../routes/footer/footer.php";
    }
    correr_not_pay();
}
?>
<!-- Cookies aviso -->
<script src="./../resourses/js/aviso-cookies.js"></script>
<?php
if($_ENV['PWA'] == 1){
    ?>
    <script src="./PWA/service.js"></script>
    <?php
}
?>