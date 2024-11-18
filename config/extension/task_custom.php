<?php
    //Hestia tarea de limpieza
    function hestia_clean(){
        foreach (arreglo_consulta("SELECT id_user, id_pedido, usuario, correo, expiracion FROM jpx_tokens_pays") as $row){
            if($row['expiracion'] < \FECHA){
                $id = $row['id_user'];
                $consulta_existente = new GranMySQL();
                $consulta_existente->seleccion = "COUNT(*) as count";
                $consulta_existente->tabla = "jpx_users";
                $consulta_existente->comparable = "{$id}";
                $consulta_personalizada = $consulta_existente->where();
                if($consulta_personalizada >= 1){
                    $cuerpo = '<div>Te mandamos este correo para informarte que, el día de hoy expiró tu plan contratado en '.$_ENV['NAME_APP'].', muchas gracias por todo.</div><div>Nosotros ya hemos borrado todos los datos los cuales estaban en nuestro contrato.</div><div>Recuerda que no borraremos tu cuenta de manera automática, si deseas borrarlo accede a '.$_ENV['NAME_APP'].' y dale en "eliminar cuenta".</div><div>Muchas gracias por haber estado con nosotros. 😊</div>';
                    
                    $consulta_new = new GranMySQL();
                    $consulta_new -> seleccion = "email";
                    $consulta_new -> tabla = "jpx_users";
                    $consulta_new -> comparar = "id";
                    $consulta_new -> comparable = $id;
                    $consulta_respuesta = $consulta_new -> where();
            
                    mail_smtp_v1_3($_ENV['NAME_APP'],"Tu paquete ya expiró",$cuerpo,$consulta_respuesta['email']);
                    eliminar_cuenta_hestia($row['id_pedido'],$row['usuario']);
                }else{
                    eliminar_cuenta_hestia($row['id_pedido'],$row['usuario']);
                }
                
                
            }
        }
    }

    function eliminar_cuenta_hestia($id_pedido,$usuario){
        $pedido = $id_pedido;
        echo $id_pedido;
        $consulta_pedido = new GranMySQL();
        $consulta_pedido->seleccion = "id_hestia";
        $consulta_pedido -> tabla = "jpx_request_dns";
        $consulta_pedido -> comparar = "id_pedido";
        $consulta_pedido -> comparable = $pedido;
        $resultado = $consulta_pedido -> where();
        $id_hestia = $resultado['id_hestia'];
        $consulta_hestia = consulta_mysqli_custom_all("SELECT * FROM jpx_hestia_accounts WHERE id = {$id_hestia}");
        // Server credentials
        $hst_hostname = (string)$consulta_hestia['host'];
        $hst_port = (int)$consulta_hestia['port'];
        $hst_username = (string)$consulta_hestia['user'];
        $hst_password = (string)$consulta_hestia['password'];
        $hst_returncode = 'yes';
        $hst_command = 'v-delete-user';
        
        // Account
        $username = $usuario;
        
        // Prepare POST query
        $postvars = ['user' => $hst_username, 'password' => $hst_password, 'returncode' => $hst_returncode, 'cmd' => $hst_command, 'arg1' => $username];
        
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
        $data = json_decode($answer, true, 512, JSON_THROW_ON_ERROR);
        eliminar_datos_custom_mysqli("DELETE FROM jpx_request_dns WHERE id_pedido = $pedido;");
        eliminar_datos_custom_mysqli("DELETE FROM jpx_tokens_pays WHERE id_pedido = $pedido;");

    }

    //evento_programado("hestia_clean",\FECHA,"1 hours");

?>
