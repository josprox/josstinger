<?php

/*
    Nombre: Visibility Logic
    Tipo: Plugin
    Función: Muestra contenido con excepciones, de esta manera solo recibirás un "TRUE" si el usuario cumple con las reglas, de no ser así regresará un "FALSE".
    Creador: Melchor Estrada José Luis (JOSPROX MX | Internacional).
    Web: https://josprox.com
*/

class VisibilityLogic{
    public $accion = "mostrar";
    public $ip = "allow-all";
    public $iduser_tabla = "users";
    public $fecha = "";

    function ip(){
        $resultado = null;
        $diferente = null;
        if("{$this->accion}" == "mostrar"){
            $resultado = TRUE;
            $diferente = FALSE;
        }elseif("{$this->accion}" == "ocultar" OR "{$this->accion}" != "mostrar"){
            $resultado = FALSE;
            $diferente = TRUE;
        }
        $error = 3;
        if("{$this->ip}" === "allow-all"){
            return $resultado;
        }elseif ((string)"{$this->ip}" === $_SERVER['REMOTE_ADDR']){
            return $resultado;
        }elseif ((string)"{$this->ip}" !== $_SERVER['REMOTE_ADDR']){
            return $diferente;
        }else{
            return $error;
        }
        
    }

    function rol_usuario(){
        $conexion = conect_mysqli();
        if (isset($_COOKIE['COOKIE_INDEFINED_SESSION'])) {
            if($_COOKIE['COOKIE_INDEFINED_SESSION']){
                $nombre_user = $_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['user'];
            $password_user = $_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['pass'];
    
            $sql = "SELECT id_rol, password FROM {$this->iduser_tabla} WHERE email = '$nombre_user'";
            $resultado = $conexion->query($sql);
            $rows = $resultado->num_rows;
            if ($rows > 0) {
                $row = $resultado->fetch_assoc();
                $password_encriptada = $row['password'];
                (int)$id = $row['id_rol'];
                if(password_verify((string) $password_user,(string) $password_encriptada) == TRUE){
                    mysqli_close($conexion);
                    if("{$this->accion}" == "mostrar"){
                        return $id;
                    }elseif("{$this->accion}" == "ocultar"){
                        return TRUE;
                    }elseif("{$this->accion}" != "mostrar"){
                        return FALSE;
                    }
                }
            }else{
                return FALSE;
            }
            }
        }else{
            return FALSE;
        }
    }

    function DateTime(){
        $resultado = null;
        $diferente = null;
        $fecha = "{$this->fecha}";
        $fecha_fija = date("Y-m-d");
        if("{$this->accion}" == "mostrar"){
            $resultado = TRUE;
            $diferente = FALSE;
        }elseif("{$this->accion}" == "ocultar" OR "{$this->accion}" != "mostrar"){
            $resultado = FALSE;
            $diferente = TRUE;
        }
        $cancelacion = 2;
        $error = 3;
        if($fecha >= $fecha_fija){
            return $resultado;
        }elseif($fecha < $fecha_fija){
            return $diferente;
        }else{
            return $error;
        }
    }

    function cerrar(){
        return null;
    }
}

?>