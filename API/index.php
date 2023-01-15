<?php
include (__DIR__ . DIRECTORY_SEPARATOR . "../jossecurity.php");
if(!isset($_ENV['API']) OR $_ENV['API'] != 1){
    echo "El sistema de API está desactivado, no podrás usar conexiones API.";
}elseif(!isset($_GET['email']) && !isset($_GET['password']) && !isset($_GET['cmd'])){
    echo "No se ha podido recibir ningún parámetro de manera correcta, favor de checar la documentación.";
}elseif($_GET['email'] == "" OR $_GET['password'] == "" OR $_GET['cmd'] == ""){
    echo "Favor de llenar todos los parámetros.";
}elseif($_GET['email'] != "" && $_GET['password'] != "" && $_GET['cmd'] != ""){
    echo "CONECTANDO...\n\tConexión establecida.\n\tChecando usuario...\n\t";
    $conexion = conect_mysqli();
    $email = mysqli_real_escape_string($conexion, (string) $_GET['email']);
    $password = mysqli_real_escape_string($conexion, (string) $_GET['password']);
    $consulta_admin = consulta_mysqli_where("id , password, id_rol","users","email","'$email'");
    $password_encriptada = $consulta_admin['password'];
    $ip = $_SERVER['REMOTE_ADDR'];
    actualizar_datos_mysqli("users","`last_ip` = '$ip'","id",$consulta_admin['id']);
    if((int)$consulta_admin['id_rol'] == 1 && password_verify($password,(string) $password_encriptada) == TRUE){
        echo "Usuario correcto.\n\tEjecutando código insertado...\n";
        if($_GET['cmd'] == "test"){
            echo "\n\tAPI funcionando.";
        }elseif($_GET['cmd'] == "v-add-user") {
            registro($_GET['arg1'], $_GET['arg2'], $_GET['arg3'], $_GET['arg4'], $_GET['arg5']);
            echo "\n\tCodigo insertado.";
        }elseif($_GET['cmd'] == "v-change-user-password"){
            resetear_contra($_GET['arg1']);
            echo "\n\tCodigo insertado.";
        }elseif($_GET['cmd'] == "v-delete-user"){
            eliminar_cuenta($_GET['arg1'], $_GET['arg2'],"");
            echo "\n\tCodigo insertado.";
        }elseif($_GET['cmd'] == "v-test-smtp"){
            if(mail_smtp_v1_3_check($_GET['arg1']) == TRUE){
                echo "\n\tCodigo insertado.";
            }else{
                echo "\n\tCodigo fallido.";
            }
        }elseif($_GET['cmd'] == "v-send-smtp"){
            if(mail_smtp_v1_3($_GET['arg1'],$_GET['arg2'],$_GET['arg3'],$_GET['arg4']) == TRUE){
                echo "\n\tCodigo insertado.";
            }else{
                echo "\n\tCodigo fallido.";
            }
        }elseif($_GET['cmd'] == "v-receive-smtp"){
            if(mail_smtp_v1_3_recibir($_GET['arg1'],$_GET['arg2'],$_GET['arg3'],$_GET['arg4']) == TRUE){
                echo "\n\tCodigo insertado.";
            }else{
                echo "\n\tCodigo fallido.";
            }
        }elseif($_GET['cmd'] == "v-insert-data-mysqli"){
            insertar_datos_custom_mysqli($_GET['arg1']);
            echo "\n\tCodigo insertado.";
        }elseif($_GET['cmd'] == "v-update-data-mysqli"){
            actualizar_datos_mysqli($_GET['arg1'],$_GET['arg2'],$_GET['arg3'],$_GET['arg4']);
            echo "\n\tCodigo insertado.";
        }elseif($_GET['cmd'] == "v-delete-data-mysqli"){
            eliminar_datos_custom_mysqli($_GET['arg1']);
            echo "\n\tCodigo insertado.";
        }elseif($_GET['cmd'] == "v-delete-table-mysqli"){
            eliminar_tabla_PDO($_GET['arg1']);
            echo "\n\tCodigo insertado.";
        }elseif($_GET['cmd'] == "v-create-table-mysqli"){
            crear_tabla_PDO($_GET['arg1'],$_GET['arg2']);
            echo "\n\tCodigo insertado.";
        }elseif($_GET['cmd'] == "v-delete-directory"){
            borrar_directorio($_GET['arg1']);
            echo "\n\tCodigo insertado.";
        }elseif($_GET['cmd'] == "sms"){
            if(isset($_ENV['TWILIO']) && $_ENV['TWILIO'] == 1){
                $sms = new Nuevo_Mensaje();
                $sms -> numero = "+" . (string)$_GET['arg1'];
                $sms -> mensaje = (string)$_GET['arg2'];
                if($sms -> enviar() == TRUE){
                    $sms -> cerrar();
                    echo "\n\tSe ha enviado el mensaje.";
                }else{
                    echo "\n\tNo se ha enviado el mensaje.";
                }
            }else{
                echo "\n\tEl plugin no se encuentra activado dentro del archivo del sistema.";
            }
        }elseif($_GET['cmd'] == "push"){
            if(isset($_ENV['ONESIGNAL']) && $_ENV['ONESIGNAL'] == 1){
                $push = new Nuevo_Push();
                $push -> titulo_esp = $_GET['arg1'];
                $push -> titulo_ing = $_GET['arg2'];
                $push -> mensaje_esp = $_GET['arg3'];
                $push -> mensaje_ing = $_GET['arg4'];
                $push -> url_personalizado = $_GET['arg5'];
                if($push -> enviar() == TRUE){
                    $push -> cerrar();
                    echo "\n\tSe ha completado la tarea push.";
                }else{
                    $push -> cerrar();
                    echo "\n\tHa fallado la tarea push.";
                }
            }else{
                echo "\n\tEl plugin no se encuentra activado dentro del archivo del sistema.";
            }
        }else{
            echo "\n\tEl codigo insertado no existe.";
        }
        
    }else{
        echo "El usuario no existe, no cumple con el rol para usar la API o la contraseña es incorrecta.";
    }
}

?>
