<?php

//Cron del sistema por defecto.

function limpiador_check_users(){
    foreach(arreglo_consulta("SELECT * FROM check_users") as $row){
        if($row['expiracion'] < fecha){
            eliminar_datos_con_where("check_users","id",$row['id']);
        }
    }
}

evento_programado("limpiador_check_users",fecha,"1 hours");

//Cron extendido disponible para el programador.

if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "task_custom.php")){
    include (__DIR__ . DIRECTORY_SEPARATOR . "task_custom.php");
}

?>