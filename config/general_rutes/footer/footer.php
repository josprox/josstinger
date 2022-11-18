<!-- JosSecurity footer está funcionando -->
<?php
$pagina = nombre_de_pagina();
if($pagina == "panel.php"){
    ?>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="./../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <?php
}elseif($pagina != "panel.php"){
    ?>
    <!-- Aquí va el footer personalizado -->
    <?php
    include __DIR__ . "/../../../routes/footer/footer.php";
    correr_not_pay();
}
if($_ENV['PWA'] == 1){
    ?>
    <script src="./PWA/service.js"></script>
    <?php
}
?>