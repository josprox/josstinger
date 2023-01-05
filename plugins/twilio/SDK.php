<?php
use Twilio\Rest\Client;
class Nuevo_Mensaje{
    public $numero;
    public $mensaje = "";
    function enviar(){
        $sid = $_ENV['TWILIO_SID'];
        $token = $_ENV['TWILIO_AUTH'];
        $client = new Client($sid, $token);
        $numero_envio = (string)$_ENV['TWILIO_PHONE'];

        if(isset($_ENV['TWILIO']) && $_ENV['TWILIO'] == 1){
            $client->messages->create(
                // the number you'd like to send the message to
                "{$this->numero}",
                [
                    // A Twilio phone number you purchased at twilio.com/console
                    'from' => "'$numero_envio'",
                    // the body of the text message you'd like to send
                    'body' => "{$this->mensaje}"
                ]
            );
            return TRUE;
        }else{
            return FALSE;
        }

    }
    function cerrar(){
        return NULL;
    }
}

function resetear_contra_sms($correo){
    $key = generar_llave_alteratorio(16);
    $consulta = consulta_mysqli_where("id","users","email","'$correo'");
    $id_correo = $consulta['id'];
    $fecha_1_day = date("Y-m-d H:i:s", strtotime(fecha . "+ 1 days"));
    if(insertar_datos_clasic_mysqli("check_users","id_user, accion, url, expiracion","$id_correo,'cambiar_contra', '$key','$fecha_1_day'") == TRUE){
        $row = consulta_mysqli_where("name, phone","users","email","'$correo'");
        $name = $row['name'];
        $phone = $row['phone'];
        $ssl = check_http();
        $link = $ssl . $_ENV['DOMINIO'] . $_ENV['HOMEDIR'] . "panel?cambiar_contra=" . $key;
        $mensaje = "Hola $name, acabas de solicitar una restauración de contraseña en ".nombre_app.", para poder restablecerlo tendrás que acceder al siguiente enlace: $link";
        $sms = new Nuevo_Mensaje();
        $sms -> numero = $phone;
        $sms -> mensaje = $mensaje;
        if($sms -> enviar() == TRUE){
            $sms -> cerrar();
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
?>