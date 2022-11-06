<?php

require (__DIR__ . "/../jossecurity.php");

foreach (arreglo_consulta("SELECT id_user, usuario, correo, expiracion FROM tokens_pays") as $row){
    if($row['expiracion'] < $fecha){

        $id = $row['id_user'];

        $cuerpo = '<div>Te mandamos este correo para informarte que, el día de hoy expiró tu plan contratado en '.$_ENV['NAME_APP'].', muchas gracias por todo.</div><div>Nosotros ya hemos borrado todos los datos los cuales estaban en nuestro contrato.</div><div>Recuerda que no borraremos tu cuenta de manera automática, si deseas borrarlo accede a '.$_ENV['NAME_APP'].' y dale en "eliminar cuenta".</div><div>Muchas gracias por haber estado con nosotros. 😊</div>';

        mail_smtp_v1_3($row['usuario'],"Tu paquete ya expiró.",$cuerpo,$row['correo']);

        
        
        // Server credentials
        $hst_hostname = (string)$_ENV['HST_HOSTNAME'];
        $hst_port = (int)$_ENV['HST_PORT'];
        $hst_username = (string)$_ENV['HST_USUARIO'];
        $hst_password = (string)$_ENV['HST_CONTRA'];
        $hst_returncode = 'yes';
        $hst_command = 'v-delete-user';
        
        // Account
        $username = $row['usuario'];
        
        // Prepare POST query
        $postvars = array(
            'user' => $hst_username,
            'password' => $hst_password,
            'returncode' => $hst_returncode,
            'cmd' => $hst_command,
            'arg1' => $username
        );
        
        // Send POST query via cURL
        $postdata = http_build_query($postvars);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://' . $hst_hostname . ':' . $hst_port . '/api/');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
        $answer = curl_exec($curl);
        
        // Parse JSON output
        $data = json_decode($answer, true);
        eliminar_datos_custom_mysqli("DELETE FROM tokens_pays WHERE id_user = $id;");

    }else{
        continue;
    }
}

?>