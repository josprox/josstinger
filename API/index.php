<?php
include (__DIR__ . DIRECTORY_SEPARATOR . "../jossecurity.php");

try {
    if (!isset($_ENV['API']) || $_ENV['API'] != 1) {
        throw new Exception("El sistema de API está desactivado, no podrás usar conexiones API.");
    }

    if (!isset($_GET['email']) || !isset($_GET['password']) || !isset($_GET['cmd'])) {
        throw new Exception("No se ha podido recibir ningún parámetro de manera correcta, favor de checar la documentación.");
    }

    if ($_GET['email'] == "" || $_GET['password'] == "" || $_GET['cmd'] == "") {
        throw new Exception("Favor de llenar todos los parámetros.");
    }

    echo "CONECTANDO...\n\tConexión establecida.\n\tChecando usuario...\n\t";

    $conexion = conect_mysqli();
    $email = mysqli_real_escape_string($conexion, (string) $_GET['email']);
    $password = mysqli_real_escape_string($conexion, (string) $_GET['password']);
    $consulta_admin = consulta_mysqli_where("id, password, id_rol", "users", "email", "'$email'");
    $password_encriptada = $consulta_admin['password'];
    $ip = $_SERVER['REMOTE_ADDR'];
    actualizar_datos_mysqli("users", "`last_ip` = '$ip'", "id", $consulta_admin['id']);

    if ((int) $consulta_admin['id_rol'] == 1 && password_verify($password, (string) $password_encriptada) == true) {
        echo "Usuario correcto.\n\tEjecutando código insertado...\n";
        
        switch ($_GET['cmd']) {
            //Caso de pruebas
            case "test":
                echo "\n\tAPI funcionando.";
                break;
                
            //Casos de usuarios
            case "v-add-user":
                registro($_GET['arg1'], $_GET['arg2'], $_GET['arg3'], $_GET['arg4'], $_GET['arg5']);
                echo "\n\tCodigo insertado.";
                break;
                
            case "v-change-user-password":
                resetear_contra($_GET['arg1']);
                echo "\n\tCodigo insertado.";
                break;
                
            case "v-delete-user":
                eliminar_cuenta($_GET['arg1'], $_GET['arg2'], "");
                echo "\n\tCodigo insertado.";
                break;
                
            //Pruebas de correo
            case "v-test-smtp":
                if (mail_smtp_v1_3_check($_GET['arg1']) == true) {
                    echo "\n\tCodigo insertado.";
                } else {
                    echo "\n\tCodigo fallido.";
                }
                break;
                
            case "v-send-smtp":
                if (mail_smtp_v1_3($_GET['arg1'], $_GET['arg2'], $_GET['arg3'], $_GET['arg4']) == true) {
                    echo "\n\tCodigo insertado.";
                } else {
                    echo "\n\tCodigo fallido.";
                }
                break;
                
            case "v-receive-smtp":
                if (mail_smtp_v1_3_recibir($_GET['arg1'], $_GET['arg2'], $_GET['arg3'], $_GET['arg4']) == true) {
                    echo "\n\tCodigo insertado.";
                } else {
                    echo "\n\tCodigo fallido.";
                }
                break;
                
            //Casos para MySQL
            case "v-insert-data-mysqli":
                insertar_datos_custom_mysqli($_GET['arg1']);
                echo "\n\tCodigo insertado.";
                break;
                
            case "v-update-data-mysqli":
                actualizar_datos_mysqli($_GET['arg1'], $_GET['arg2'], $_GET['arg3'], $_GET['arg4']);
                echo "\n\tCodigo insertado.";
                break;
                
            case "v-delete-data-mysqli":
                eliminar_datos_custom_mysqli($_GET['arg1']);
                echo "\n\tCodigo insertado.";
                break;
                
            case "v-delete-table-mysqli":
                eliminar_tabla_PDO($_GET['arg1']);
                echo "\n\tCodigo insertado.";
                break;
                
            case "v-create-table-mysqli":
                crear_tabla_PDO($_GET['arg1'], $_GET['arg2']);
                echo "\n\tCodigo insertado.";
                break;
                
            // Eliminación de un directorio
            case "v-delete-directory":
                borrar_directorio($_GET['arg1']);
                echo "\n\tCodigo insertado.";
                break;
                
            // Uso de plugins
            case "sms":
                if (isset($_ENV['TWILIO']) && $_ENV['TWILIO'] == 1) {
                    $sms = new Nuevo_Mensaje();
                    $sms->numero = "+" . (string)$_GET['arg1'];
                    $sms->mensaje = (string)$_GET['arg2'];
                    
                    if ($sms->enviar() == true) {
                        $sms->cerrar();
                        echo "\n\tSe ha enviado el mensaje.";
                    } else {
                        echo "\n\tNo se ha enviado el mensaje.";
                    }
                } else {
                    echo "\n\tEl plugin no se encuentra activado dentro del archivo del sistema.";
                }
                break;
                
            case "push":
                if (isset($_ENV['ONESIGNAL']) && $_ENV['ONESIGNAL'] == 1) {
                    $push = new Nuevo_Push();
                    $push->titulo_esp = $_GET['arg1'];
                    $push->titulo_ing = $_GET['arg2'];
                    $push->mensaje_esp = $_GET['arg3'];
                    $push->mensaje_ing = $_GET['arg4'];
                    $push->url_personalizado = $_GET['arg5'];
                    
                    if ($push->enviar() == true) {
                        $push->cerrar();
                        echo "\n\tSe ha completado la tarea push.";
                    } else {
                        $push->cerrar();
                        echo "\n\tHa fallado la tarea push.";
                    }
                } else {
                    echo "\n\tEl plugin no se encuentra activado dentro del archivo del sistema.";
                }
                break;

            case "v-create-table-postgresql":
                if(isset($_ENV['CONECT_POSTGRESQL']) && $_ENV['CONECT_POSTGRESQL'] == 1){
                    crear_tabla_psg($_GET['arg1'],$_GET['arg2']);
                    echo "\n\tCodigo insertado.";
                }else{
                    echo "\n\tEl plugin no se encuentra activado dentro del archivo del sistema.";
                }
                break;
            
            case "v-insert-data-postgresql":
                if(isset($_ENV['CONECT_POSTGRESQL']) && $_ENV['CONECT_POSTGRESQL'] == 1){
                    insertar_datos_psg($_GET['arg1'],$_GET['arg2'],$_GET['arg3']);
                    echo "\n\tCodigo insertado.";
                }else{
                    echo "\n\tEl plugin no se encuentra activado dentro del archivo del sistema.";
                }
                break;

            case "v-update-data-postgresql":
                if(isset($_ENV['CONECT_POSTGRESQL']) && $_ENV['CONECT_POSTGRESQL'] == 1){
                    actualizar_datos_psg($_GET['arg1'],$_GET['arg2'],$_GET['arg3'], $_GET['arg4']);
                    echo "\n\tCodigo insertado.";
                }else{
                    echo "\n\tEl plugin no se encuentra activado dentro del archivo del sistema.";
                }
                break;

            case "v-delete-data-postgresql":
                if(isset($_ENV['CONECT_POSTGRESQL']) && $_ENV['CONECT_POSTGRESQL'] == 1){
                    eliminar_datos_con_where_psg($_GET['arg1'],$_GET['arg2'],$_GET['arg3']);
                    echo "\n\tCodigo insertado.";
                }else{
                    echo "\n\tEl plugin no se encuentra activado dentro del archivo del sistema.";
                }
                break;

            case "v-delete-table-postgresql":
                if(isset($_ENV['CONECT_POSTGRESQL']) && $_ENV['CONECT_POSTGRESQL'] == 1){
                    eliminar_tabla_psg($_GET['arg1']);
                    echo "\n\tCodigo insertado.";
                }else{
                    echo "\n\tEl plugin no se encuentra activado dentro del archivo del sistema.";
                }
                break;
            //Aquí se agregan las API's creadas por el usuario.
            if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "custom.php")){
                require_once (__DIR__ . DIRECTORY_SEPARATOR . "custom.php");
            }
                
            default:
                echo "\n\tEl codigo insertado no existe.";
                break;
        }
    } else {
        echo "El usuario no existe, no cumple con el rol para usar la API o la contraseña es incorrecta.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
