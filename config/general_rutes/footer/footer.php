<!-- JosSecurity footer está funcionando -->
<?php
$pagina = nombre_de_pagina();
if($pagina == "panel.php"){
    ?>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="./../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
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