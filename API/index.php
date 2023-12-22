<?php
include (__DIR__ . DIRECTORY_SEPARATOR . "../jossecurity.php");

try {
    if (!isset($_ENV['API']) || $_ENV['API'] != 1) {
        throw new Exception("El sistema de API está desactivado, no podrás usar conexiones API.");
    }

    if ((!isset($_GET['email']) && !isset($_GET['password']) && !isset($_GET['cmd'])) && (!isset($_GET['API']))) {
        throw new Exception("No se ha podido recibir ningún parámetro de manera correcta, favor de checar la documentación.");
    }

    if (((isset($_GET['email']) && isset($_GET['password']) && isset($_GET['cmd'])) && ($_GET['email'] == "" && $_GET['password'] == "" && $_GET['cmd'] == "")) && ($_GET['API'] == "")) {
        throw new Exception("Favor de llenar todos los parámetros.");
    }

    if(isset($_GET['email']) && $_GET['password']){
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
                if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "custom_admin.php")){
                    require_once (__DIR__ . DIRECTORY_SEPARATOR . "custom_admin.php");
                }
                    
                default:
                    echo "\n\tEl codigo insertado no existe.";
                    break;
            }
        } else {
            echo "El usuario no existe, no cumple con el rol para usar la API o la contraseña es incorrecta.";
        }
    }elseif(isset($_GET['API']) && $_GET['API'] == "public"){
        switch($_GET['cmd']){
            case "test":
                $respuesta = [
                    "Tipo" => "Prueba",
                    "contenido" => "El sistema de API pública está funcionando.",
                    "respuesta" => 200
                ];
                break;
            case "login":
                if((!isset($_GET['arg1']) || !isset($_GET['arg2']) || !isset($_GET['arg4']))){
                    $respuesta = [
                        "Tipo" => "login",
                        "contenido" => "Favor de ingresar los campos necesarios.",
                        "respuesta" => 200
                    ];
                }else{
                    $fa = FA($_GET['arg1'],$_GET['arg2'],$_GET['arg3'],$_GET['arg4'],$_GET['arg5']);
                    switch ($fa){
                        case NULL:
                            $respuesta = [
                                "Tipo" => "Inicio de sesión",
                                "contenido" => "Se ha realizado el inicio de sesión con éxito, sin embargo, no se ha redireccionado.",
                                "respuesta" => 200
                            ];
                            break;
                            case "2fa":
                                $respuesta = [
                                    "Tipo" => "Inicio de sesión",
                                    "contenido" => "Tienes activado el modo de seguridad, favor de acceder con un código de acceso.",
                                    "respuesta" => 200
                                ];
                                break;
                            case "no_check_mail":
                                $respuesta = [
                                    "Tipo" => "Inicio de sesión",
                                    "contenido" => "El código insertado no existe o ha caducado, favor de comprobar su correo.",
                                    "respuesta" => 200
                                ];
                                break;
                            case "no_check_sms":
                                $respuesta = [
                                    "Tipo" => "Inicio de sesión",
                                    "contenido" => "El código insertado no existe o ha caducado, favor de comprobar su mensaje sms.",
                                    "respuesta" => 200
                                ];
                                break;
                        case "error":
                            $respuesta = [
                                "Tipo" => "Inicio de sesión",
                                "contenido" => "El código de la aplicación no es válido.",
                                "respuesta" => 200
                            ];
                            break;
                    }
                }
                break;
            //Aquí se agregan las API's creadas por el usuario.
            if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "custom_public.php")){
                require_once (__DIR__ . DIRECTORY_SEPARATOR . "custom_public.php");
            }
            default:
            $respuesta = [
                "Tipo" => "error",
                "contenido" => "No existe ningún ajuste de este CMD.",
                "respuesta" => 400
            ];
                break;
        }
        header('Content-Type: application/json');
        $json = json_encode($respuesta, JSON_THROW_ON_ERROR);
        if (json_validate($json) == 1){
            echo $json;
        }else{
            $json_error = [
                "comentario" => "El archivo JSON no está bien redactado.",
                "error" => 400
            ];
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>