<?php

//Cron del sistema por defecto.

function limpiador_jpx_check_users(){
    foreach(arreglo_consulta("SELECT * FROM jpx_check_users") as $row){
        if($row['expiracion'] < \FECHA){
            eliminar_datos_con_where("jpx_check_users","id",$row['id']);
        }
    }
}

evento_programado("limpiador_jpx_check_users",\FECHA,"1 hours");

//Cron extendido disponible para el programador.

if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "task_custom.php")){
    include (__DIR__ . DIRECTORY_SEPARATOR . "task_custom.php");
}

?>