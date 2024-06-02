<?php
use PragmaRX\Google2FAQRCode\Google2FA;
use PragmaRX\Google2FA\Google2FA as GoogleAuthenticator;
    class login{
        public $correo;
        public $contra;
        public $tabla = "users";
        public $redireccion ="admin";
        public $check_user = "panel";
        public $cookies = "si";
        public $modo_admin = TRUE;
        public $clave = "";
        private $conexion;
        private string $nombre_app = \NOMBRE_APP;
        private string $fecha = \FECHA;
        private $ip;
        public function __construct(){
            $this->conexion = conect_mysqli();
            $this->ip = $_SERVER['REMOTE_ADDR'];
        }
        // Comprueba y retorna los datos si existe el usuario, si no existe manda un código de error 404.
        function compilar(){
            // Preparamos los datos para una consulta.
            $table = mysqli_real_escape_string($this->conexion, (string) $this->tabla);
            $correo = mysqli_real_escape_string($this->conexion, (string) $this->correo);
            $password = mysqli_real_escape_string($this->conexion, (string) $this->contra);
            // Hacemos una consulta.
            $consulta = new GranMySQL;
            $consulta -> seleccion = "*";
            $consulta -> tabla = $table;
            $consulta -> comparar = "email";
            $consulta -> comparable = $correo;
            // Checamos si existe el usuario
            $consulta -> respuesta = "num_rows";
            $respuesta = $consulta -> where();

            echo $respuesta;

            if ($respuesta > 0){
                $consulta -> respuesta = "fetch_assoc";
                $where = $consulta -> where ();

                $datos = [
                    "id" => $where['id'],
                    "rol" => $where['id_rol'],
                    "correo" => $correo,
                    "nombre" => $where['name'],
                    "contra" => $password,
                    "celular" => $where['phone'] ?? 0,
                    "ultimo_acceso" => $where['last_ip'] ?? 0,
                    "estado_doble_factor" => $where['fa'] ?? 0,
                    "tipo_doble_factor" => $where['type_fa'] ?? 0,
                    "encypt_Google" => $where['two_fa'] ?? 0,
                    "encriptacion" => $where['password'],
                    "estado" => $where['checked_status'] ?? 0,
                    "codigo" => 200
                ];
    
                return $datos;
            }else{
                return $datos =  [
                    "mensaje" => "El correo o contraseña son incorrectos.",
                    "codigo" => 400
                ];
            }

        }

        // Ejecuta el inicio de sesión
        public function ejecutar(){
            $compilar = self::compilar();
            if (($compilar == "2fa" || $compilar == "error") || (is_array($compilar) && $compilar['codigo'] != 200)){
                return $compilar;
            }else{
                switch ($this->modo_admin){
                    case FALSE:
                        $seguridad = "desactivado" == "desactivado";
                    break;
                    case TRUE:
                        echo json_encode($compilar);
                        $seguridad = $compilar['rol'] == 1 || $compilar['rol'] == 2 || $compilar['rol'] == 4;
                    break;
                }
                $ip = $this->ip;
                $location = $this->redireccion;
                
                if ($compilar['codigo'] !=  400) {
                    if(!isset($_ENV['CHECK_USER']) || $_ENV['CHECK_USER'] != 1){
                        $check = TRUE;
                    }else{
                        $check = $compilar['estado'];
                    }
                    if($check == TRUE){
                        if(self::compilar()){
                            if(password_verify($compilar['contra'],(string) $compilar['encriptacion']) == TRUE){
                
                                $_SESSION['id_usuario'] = $compilar['id'];
                
                                if ($this->cookies == "si"){
                                    //Cookie de usuario y contraseña
                                    setcookie("COOKIE_INDEFINED_SESSION", TRUE, ['expires' => time()+$_ENV['COOKIE_SESSION'], 'path' => "/"]);
                                    setcookie("COOKIE_DATA_INDEFINED_SESSION[user]", $compilar['correo'], ['expires' => time()+$_ENV['COOKIE_SESSION'], 'path' => "/"]);
                                    setcookie("COOKIE_DATA_INDEFINED_SESSION[pass]", $compilar['contra'], ['expires' => time()+$_ENV['COOKIE_SESSION'], 'path' => "/"]);
                                }
                
                                actualizar_datos_mysqli("users","`last_ip` = '$ip'","id",$compilar['id']);
                
                                $cuerpo_de_correo = "<div><p align='justify'>Te informamos que hemos recibido un inicio de sesión desde ". $this->nombre_app .", sino fuiste tú te recomendamos que cambies tu contraseña lo más pronto posible.😊</p></div><div><p>La dirección ip donde se ingresó fue: ".$this->ip."</p><p>Accedió el día: ".$this->fecha ."</p></div>";
        
                                $correo_confirmar = json_decode(mail_smtp_v1_3($compilar['nombre'],"Haz iniciado sesión",$cuerpo_de_correo,$compilar['correo']), true);
                
                                if($correo_confirmar['Estado'] == 200){
                                    header("Location: $location");
                                }
                
                            }else{
                                return FALSE;
                            }
                        }
                    }else{
                        $ssl_tls = check_http();
                        $key = generar_llave_alteratorio(16);
                        $fecha_1_day = \FECHA_1_DAY;
                        $id = $compilar['id'];
                        $cuerpo_de_correo = "<div>Hola, has intentado iniciar sesión pero primero debes de activar tu cuenta para verificar que realmente eres tú, por favor <a href='".$ssl_tls.$_ENV['DOMINIO'].$_ENV['HOMEDIR'].$this->check_user."?check_user=$key'>da clic aquí</a> para activar tu correo.</div>";
                        insertar_datos_clasic_mysqli("check_users","id_user, url, accion, expiracion","$id,'$key', 'check_user','$fecha_1_day'");
                        if(mail_smtp_v1_3($compilar['nombre'],"Activa tu cuenta",$cuerpo_de_correo,$compilar['correo']) == TRUE){
                        ?>
                        <script>
                            Swal.fire(
                            'Falló',
                            'El usuario no ha sido verificado, favor de checar su correo para activarlo.',
                            'error'
                            )
                        </script>
                        <?php
                        header("refresh:1;");
                        }
                    }
                }
            }
        }


        // Destructor
        public function __destruct() {
            // Borrar los datos sensibles antes de que el objeto sea destruido
            $this->correo = null;
            $this->contra = null;
            $this->conexion->close(); // Cerrar la conexión a la base de datos
            // También puedes borrar otros datos sensibles que puedan estar almacenados en el objeto
            unset($this->tabla);
            unset($this->redireccion);
            unset($this->check_user);
            unset($this->cookies);
            unset($this->modo_admin);
        }
    }
?>