<?php
if(!isset($_GET['cmd'])){
    require (__DIR__ . DIRECTORY_SEPARATOR ."../jossecurity.php");
}else{
    echo "\n\tEl sistema de cron pasa a ser codigo CMD.\n";
}
foreach(arreglo_consulta("SELECT * FROM check_users") as $row){
    if($row['expiracion'] < $fecha){
        eliminar_datos_con_where("check_users","id",$row['id']);
    }
}
?>