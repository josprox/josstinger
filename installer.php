<?php

$name_app_default = "Josstinger";

$version_app_default = "1.8";

if(isset($_POST['instalar'])){

  //Sistema básico
  $name_app = $_POST['nameapp'];
  $version_app = $_POST['version'];
  //Datos de la Base de datos
  $usuariodb = $_POST['usuariodb'];
  $password_db = $_POST['password_db'];
  $db = $_POST['db'];
  $servidor_db = $_POST['servidor_db'];
  $puerto = $_POST['puerto_mysql'];
  //Datos de la Base de datos PostgreSQL
  if(isset($_POST['check_psg'])){
    $check_psg = "1";
  }else{
    $check_psg = "0";
  }
  $usuariodb_psg = $_POST['usuariodb_psg'];
  $password_db_psg = $_POST['password_db_psg'];
  $db_psg = $_POST['db_psg'];
  $servidor_db_psg = $_POST['servidor_db_psg'];
  $puerto_psg = $_POST['puerto_psg'];
  // Modo depuración
  if(isset($_POST['service'])){
    $service = "1";
  }else{
    $service = "0";
  }
  if(isset($_POST['API'])){
    $API = "1";
  }else{
    $API = "0";
  }
  if(isset($_POST['check_user_db'])){
    $CHECK_USER = "1";
  }else{
    $CHECK_USER = "0";
  }
  //Recaptcha
  $RCP = $_POST['RCP'];
  $RCS = $_POST['RCS'];
  //Mercado Pago
  $MPPK = $_POST['MPPK'];
  $MPAT = $_POST['MPAT'];
  //Hestia login
  $host_hestia = $_POST['host_hestia'];
  $puerto_hestia = $_POST['puerto_hestia'];
  $usuario_hestia = $_POST['usuario_hestia'];
  $contra_hestia = $_POST['contra_hestia'];
  $ns1 = $_POST['ns1'];
  $ns2 = $_POST['ns2'];
  //Sistema de correo
  $user_smtp = $_POST['user_smtp'];
  $pass_smtp = $_POST['pass_smtp'];
  $server_smtp = $_POST['server_smtp'];
  $smtp_port = $_POST['smtp_port'];
  //Dominio web
  $dominio = $_POST['dominio'];
  //Homedir
  if($_POST['dir'] == ""){
    $dir = "/";
  }else{
    $dir = "/".$_POST['dir']."/";
  }
  if(isset($_POST['homedir'])){
    $homedir = "";
  }else{
    $homedir = "public/";
  }
  //Installer
  $conexion = new mysqli("$servidor_db","$usuariodb", "$password_db","$db");
  $query = "";
  
  $sqlScript = file('hestia.sql');
  foreach ($sqlScript as $line)   {
                
    $startWith = substr(trim($line), 0 ,2);
    $endWith = substr(trim($line), -1 ,1);
    
    if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
            continue;
    }
            
    $query = $query . $line;
    if ($endWith == ';') {
            mysqli_query($conexion,$query) or die('
            <script>
                alert("Ha fallado la instalación.");
                window.location= "./";
            </script>
            ');
            $query= '';             
    }

    
  }
  $sql_insert = "INSERT INTO `nameservers` (`dns1`, `dns2`) VALUES ('$ns1', '$ns2');";
    if($conexion -> query($sql_insert)){
      $sql_info = "SELECT id FROM nameservers WHERE dns1 = '$ns1' && dns2 = '$ns2'";
      $datos_procesados = $conexion -> query($sql_info);
      $fetch = $datos_procesados->fetch_assoc();
      $id_fetch = $fetch['id'];
      $sql_insert_2 = "INSERT INTO `hestia_accounts` (`nameserver`, `host`, `port`, `user`, `password`) VALUES($id_fetch, '$host_hestia', $puerto_hestia, '$usuario_hestia', '$contra_hestia');";
      $conexion -> query($sql_insert_2);
    }
  if(file_exists("./.gitignore")){
    $delete_gitignore = unlink('./.gitignore');
  }

  if(file_exists("./cron code.txt")){
    $delete_gitignore = unlink('./cron code.txt');
  }

  if(file_exists("./.env")){
    $delete_gitignore = unlink('./.env');
  }

  if(file_exists("./hestia.sql")){
    $delete_gitignore = unlink('./hestia.sql');
  }

  if(file_exists("./jossecurity.sql")){
    $delete_sql = unlink('./jossecurity.sql');
  }

  if(file_exists("./README.md")){
    $delete_readme = unlink('./README.md');
  }

  if(file_exists("./LICENCE.txt")){
    $delete_licence = unlink('./LICENCE.txt');
  }
  if(file_exists("./JosSecurity.postman_collection.json")){
    $delete_licence = unlink('./JosSecurity.postman_collection.json');
  }

  $zip_installer = glob('./*.zip'); //obtenemos todos los nombres de los ficheros
  foreach($zip_installer as $file){
      if(is_file($file))
      unlink($file); //elimino el fichero
  }

  // Creamos el archivo .env
  $env_create = fopen('./.env', 'w');
  fwrite($env_create, "# Datos de la aplicación.\n");
  if($name_app_default == $name_app){
    
    fwrite($env_create, "NAME_APP=".$name_app_default."\n");
    
  }elseif($name_app_default != $name_app){

    fwrite($env_create, "NAME_APP=".$name_app_default."\n");

  }
  if($version_app_default == $version_app){
    
    fwrite($env_create, "VERSION=".$version_app_default."\n\n");
    
  }elseif($version_app_default != $version_app){
    
    fwrite($env_create, "VERSION=".$version_app."\n\n");

  }

  fwrite($env_create, "# Token de acceso a Base de datos.\n");
  fwrite($env_create, "CONECT_DATABASE=1\n");
  fwrite($env_create, "CONECT_MYSQLI=1\n");
  fwrite($env_create, "CONECT_MYSQL=1\n");
  fwrite($env_create, "CONECT_POSTGRESQL=".$check_psg."\n");
  fwrite($env_create, "CONECT_POSTGRESQL_PDO=".$check_psg."\n\n");
  
  fwrite($env_create, "# modo de depuración.\n");
  fwrite($env_create, "DEBUG=0\n");
  fwrite($env_create, "PLUGINS=1\n");
  fwrite($env_create, "PWA=".$service."\n");
  fwrite($env_create, "API=".$API."\n");
  fwrite($env_create, "CHECK_USER=".$CHECK_USER."\n\n");
  
  fwrite($env_create, "# Conexión a la base de datos MySQL.\n");
  fwrite($env_create, "USUARIO=".$usuariodb."\n");
  fwrite($env_create, "CONTRA=".$password_db."\n");
  fwrite($env_create, "BASE_DE_DATOS=".$db."\n");
  fwrite($env_create, "HOST=".$servidor_db."\n");
  fwrite($env_create, "PUERTO=".$puerto."\n\n");
  
  fwrite($env_create, "# Conexión a la base de datos PostgreSQL.\n");
  fwrite($env_create, "USUARIO_PSG=".$usuariodb_psg."\n");
  fwrite($env_create, "CONTRA_PSG=".$password_db_psg."\n");
  fwrite($env_create, "BASE_DE_DATOS_PSG=".$db_psg."\n");
  fwrite($env_create, "HOST_PSG=".$servidor_db_psg."\n");
  fwrite($env_create, "PUERTO_PSG=".$puerto_psg."\n\n");

  fwrite($env_create, "# Funcion de recaptcha.\n");
  fwrite($env_create, "RECAPTCHA=1\n");
  fwrite($env_create, "RECAPTCHA_CODE_PUBLIC=".$RCP."\n");
  fwrite($env_create, "RECAPTCHA_CODE_SECRET=".$RCS."\n\n");

  fwrite($env_create, "# Activador de Mercado Pago.\n");
  fwrite($env_create, "MERCADO_PAGO=1\n");
  fwrite($env_create, "MERCADO_PAGO_PUBLIC_KEY=".$MPPK."\n");
  fwrite($env_create, "MERCADO_PAGO_ACCESS_TOKEN=".$MPAT."\n\n");
  
  fwrite($env_create, "# Acceso smtp para enviar correos.\n");
  fwrite($env_create, "SMTP_ACTIVE=1\n");
  fwrite($env_create, "SMTP_SERVER=".$server_smtp."\n");
  fwrite($env_create, "SMTP_USERNAME=".$user_smtp."\n");
  fwrite($env_create, "SMTP_PASSWORD=".$pass_smtp."\n");
  fwrite($env_create, "SMTP_PORT=".$smtp_port."\n\n");

  fwrite($env_create, "# Dominio registrado\n");
  fwrite($env_create, "DOMINIO=".$dominio."\n\n");

  fwrite($env_create, "# Directorio\n");
  fwrite($env_create, "HOMEDIR=".$dir.$homedir."\n\n");

  fwrite($env_create, "# Zona horaria.\n");
  fwrite($env_create, "ZONA_HORARIA=America/Mexico_City\n\n");

  fwrite($env_create, "# Funcionamiento de cookies.\n");
  fwrite($env_create, "COOKIE_SESSION=31622400\n\n");
  fclose($env_create);
  
  if(isset($_POST['homedir'])){
    if(file_exists("./.htaccess")){
      $delete_htaccess = unlink('./.htaccess');
      $htaccess_create = fopen('./.htaccess', 'w');
      fwrite($htaccess_create, "<IfModule mod_rewrite.c>\nRewriteEngine On\nRewriteRule ^(.*)$ public/$1 [L]\nErrorDocument 404 /public/document_errors/404.html\nErrorDocument 403 /public/document_errors/404.html\nErrorDocument 410 /public/document_errors/410.html\nErrorDocument 500 /public/document_errors/500.html\n</IfModule>\n<Files .htaccess>\norder allow,deny\ndeny from all\n</Files>\n\n<Files .env>\norder allow,deny\ndeny from all\n</Files>");

      fclose($htaccess_create);
    }
    echo "<script>
    alert('Se ha insertado los datos de manera correcta, ahora será redireccionado al panel de control, gracias por instalar JosSecurity.😁');
    window.location= './panel';
    </script>";
  }else{
    echo "<script>
    alert('Se ha insertado los datos de manera correcta, ahora será redireccionado al panel de control, gracias por instalar JosSecurity.😁');
    window.location= './public/panel';
    </script>";
  }


}


?>

<!doctype html>
<html lang="es-MX">

<head>
  <title>Instalador</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.0-beta1 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

</head>

<body>

    <h1 align="center">Instalador de JosSecurity</h1>
    <div class="container">
        <p align="center">Bienvenido al instalador de JosSecurity, a continuación tendrás que llenar un formulario para poder instalar el sistema de manera fácil y segura.</p><br>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">

          <p align="justify">Por defecto el sistema maneja el nombre de JosSecurity y la versión preliminar del mismo pero, si tu quieres modificarlo podrás hacerlo, de esta manera también evitarás que las personas conozcan el sistema de seguridad que usas.</p>

            <div class="row justify-content-center">

              <div class="col-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="check_user_db" name="check_user_db">
                  <label class="form-check-label" for="check_user_db">¿Deseas activar el sistema de autenticacion de usuarios?</label>
                </div>
              </div>

              <div class="col-4">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="service" name="service">
                  <label class="form-check-label" for="service">¿Desea activar el service worker que viene por defecto?</label>
                </div>
              </div>

              <div class="col-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="API" name="API">
                  <label class="form-check-label" for="API">¿Deseas activar el sistema de API que viene por defecto?</label>
                </div>
              </div>

              <div class="col-5">
                <div class="mb-3">
                  <label for="nameapp" class="form-label">Nombre de la aplicación</label>
                  <input type="text"
                    class="form-control" name="nameapp" id="nameapp" aria-describedby="nameapp" value="<?php echo $name_app_default; ?>" placeholder="JosSecurity" required>
                  <small id="nameapp" class="form-text text-muted">Ingresa el nombre de la aplicación.</small>
                </div>
              </div>
              <div class="col-5">
                <div class="mb-3">
                  <label for="version" class="form-label">Versión de la aplicación</label>
                  <input type="number" step="any" value="<?php echo $version_app_default; ?>"
                    class="form-control" name="version" id="version" aria-describedby="version" required>
                  <small id="version" class="form-text text-muted">Ingresa el número de la aplicación.</small>
                </div>
              </div>

            </div>

            <p>Ahora vamos a configurar una conexión a la base de datos, esta opción es obligatoria, ya que, meteremos todo lo necesario a la base de datos.</p>

            <div class="row justify-content-center">

                <div class="col-4">
                  <div class="mb-3">
                    <label for="usuariodb" class="form-label">Usuario para base de datos</label>
                    <input type="text"
                      class="form-control" name="usuariodb" id="usuariodb" aria-describedby="usuariodb" placeholder="usuario" required>
                    <small id="usuariodb" class="form-text text-muted">Inserta el usuario para conectarnos a la base de datos.</small>
                  </div>
                </div>

                <div class="col-4">
                  <div class="mb-3">
                    <label for="password_db" class="form-label">Contraseña para la base de datos.</label>
                    <input type="password"
                      class="form-control" name="password_db" id="password_db" aria-describedby="password_db" placeholder="Contraseña">
                    <small id="password_db" class="form-text text-muted">Inserta la cotraseña del usuario que pusiste anteriormente.</small>
                  </div>
                </div>

                <div class="col-4">
                    <div class="mb-3">
                      <label for="db" class="form-label">Inserta la base de datos</label>
                      <input type="text"
                        class="form-control" name="db" id="db" aria-describedby="db" placeholder="Base de datos" required>
                      <small id="db" class="form-text text-muted">Pon la base de datos en la cual nos conectaremos.</small>
                    </div>
                </div>

                <div class="col-5">
                  <div class="mb-3">
                    <label for="servidor_db" class="form-label">Inserta el servidor</label>
                    <input type="text"
                      class="form-control" name="servidor_db" id="servidor_db" aria-describedby="servidor_db" placeholder="localhost" required>
                    <small id="servidor_db" class="form-text text-muted">Por favor ayudanos a conectarnos a la base de datos, puedes poner localhost.</small>
                  </div>
                </div>

                <div class="col-5">
                  <div class="mb-3">
                    <label for="puerto_mysql" class="form-label">Puerto</label>
                    <input type="text"
                      class="form-control" name="puerto_mysql" id="puerto_mysql" aria-describedby="puerto_mysql" placeholder="Por favor selecciona el puerto de MySQL" value="3306" required>
                    <small id="puerto_mysql" class="form-text text-muted">Por favor, pon el puerto para conectarte en MySQL. Por defecto es el 3306</small>
                  </div>
                </div>
                
            </div>

            <p>También puedes conectarte con PostgreSQL si así lo requieres, en caso de no usarlo puedes dejar en blanco esta sección.</p>

            <div class="row justify-content-center">

              <div class="col-10">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="check_psg" name="check_psg">
                  <label class="form-check-label" for="check_psg"> ¿Desea activar el sistema PostgreSQL?</label>
                </div>
              </div>

                <div class="col-4">
                  <div class="mb-3">
                    <label for="usuariodb_psg" class="form-label">Usuario para base de datos</label>
                    <input type="text"
                      class="form-control" name="usuariodb_psg" id="usuariodb_psg" aria-describedby="usuariodb_psg" placeholder="usuario">
                    <small id="usuariodb" class="form-text text-muted">Inserta el usuario para conectarnos a la base de datos.</small>
                  </div>
                </div>

                <div class="col-4">
                  <div class="mb-3">
                    <label for="password_db_psg" class="form-label">Contraseña para la base de datos.</label>
                    <input type="password"
                      class="form-control" name="password_db_psg" id="password_db_psg" aria-describedby="password_db_psg" placeholder="Contraseña">
                    <small id="password_db_psg" class="form-text text-muted">Inserta la cotraseña del usuario que pusiste anteriormente.</small>
                  </div>
                </div>

                <div class="col-4">
                    <div class="mb-3">
                      <label for="db_psg" class="form-label">Inserta la base de datos</label>
                      <input type="text"
                        class="form-control" name="db_psg" id="db_psg" aria-describedby="db_psg" placeholder="Base de datos">
                      <small id="db_psg" class="form-text text-muted">Pon la base de datos en la cual nos conectaremos.</small>
                    </div>
                </div>

                <div class="col-5">
                  <div class="mb-3">
                    <label for="servidor_db_psg" class="form-label">Inserta el servidor</label>
                    <input type="text"
                      class="form-control" name="servidor_db_psg" id="servidor_db_psg" aria-describedby="servidor_db_psg" placeholder="localhost">
                    <small id="servidor_db_psg" class="form-text text-muted">Por favor ayudanos a conectarnos a la base de datos, puedes poner localhost.</small>
                  </div>
                </div>

                <div class="col-5">
                  <div class="mb-3">
                    <label for="puerto_psg" class="form-label">Puerto</label>
                    <input type="text"
                      class="form-control" name="puerto_psg" id="puerto_psg" aria-describedby="puerto_psg" placeholder="Selecciona el puerto que usará PostgreSQL" value="5432">
                    <small id="puerto_psg" class="form-text text-muted">Por favor dime el puerto al cuál se conectará PostgreSQL. Por defecto se usa el puerto 5432.</small>
                  </div>
                </div>

                
            </div>

              <p align="justify">Por defecto el sistema usa recaptcha para poder hacer un inicio de sesión exitoso y seguro, por favor ingrese el codigo público y secreto en el sistema.</p>

              <div class="row justify-content-center">

                <div class="col-5">

                  <div class="mb-3">
                    <label for="RCP" class="form-label">Codigo público</label>
                    <input type="text"
                      class="form-control" name="RCP" id="RCP" aria-describedby="RCP" placeholder="recaptcha llave pública" required>
                    <small id="RCP" class="form-text text-muted">Inserta la llave pública.</small>
                  </div>
                  
                </div>
                <div class="col-5">
                  <div class="mb-3">
                    <label for="RCS" class="form-label">Código privado</label>
                    <input type="text" class="form-control" name="RCS" id="RCS" aria-describedby="RCS" placeholder="recaptcha llave privada" required>
                    <small id="RCS" class="form-text text-muted">Inserta la llave privada.</small>
                  </div>
                </div>

              </div>

              <p align="justify">Para casi finalizar necesitamos credenciales de correo para poder enviar correos con alta seguridad, por defecto el sistema mando correos con la seguridad tls 3.0.</p>

              <div class="row justify-content-center">

                <div class="col-5">
                  <div class="mb-3">
                    <label for="user_smtp" class="form-label">Usuario de acceso</label>
                    <input type="text"
                      class="form-control" name="user_smtp" id="user_smtp" aria-describedby="user_smtp" placeholder="Pon el usuario de acceso" required>
                    <small id="user_smtp" class="form-text text-muted">Pon las credenciales para acceder al correo.</small>
                  </div>
                </div>

                <div class="col-5">
                  <div class="mb-3">
                    <label for="pass_smtp" class="form-label">Contraseña de acceso</label>
                    <input type="password"
                      class="form-control" name="pass_smtp" id="pass_smtp" aria-describedby="pass_smtp" placeholder="Pon la contraseña de acceso" required>
                    <small id="pass_smtp" class="form-text text-muted">Pon las credenciales para acceder al correo.</small>
                  </div>
                </div>

                <div class="col-5">
                  <div class="mb-3">
                    <label for="server_smtp" class="form-label">Servidor de uso</label>
                    <input type="text"
                      class="form-control" name="server_smtp" id="server_smtp" aria-describedby="server_smtp" placeholder="smtp.google.com" required>
                    <small id="server_smtp" class="form-text text-muted">necesitamos conectarnos al servidor de correos, sino lo conoces ponte en contacto con tu provedor de correos.</small>
                  </div>
                </div>

                <div class="col-5">
                  <div class="mb-3">
                    <label for="smtp_port" class="form-label">Puerto del servidor</label>
                    <input type="text"
                      class="form-control" name="smtp_port" id="smtp_port" aria-describedby="smtp_port" placeholder="587" required>
                    <small id="smtp_port" class="form-text text-muted">Pon el puero que escucha el servidor.</small>
                  </div>
                </div>

              </div>

              <p align="justify">La aplicacion de Josstinger necesita conectarse con <a href="https://www.hestiacp.com/">Hestia Control Panel</a> para poderse usar, por favor ponga a continuación los accesos de login del administrador principal, sino lo pone el código dentro de JossSecurity fallará.</p>

              <div class="row justify-content-center">

                <div class="col-5">
                  <div class="mb-3">
                    <label for="host_hestia" class="form-label">Host</label>
                    <input type="text"
                      class="form-control" name="host_hestia" id="host_hestia" aria-describedby="host_hestia" placeholder="Pon el dominio de acceso" required>
                    <small id="host_hestia" class="form-text text-muted">Pon el host donde accedes.</small>
                  </div>
                </div>

                <div class="col-5">
                  <div class="mb-3">
                    <label for="puerto_hestia" class="form-label">Puerto</label>
                    <input type="text"
                      class="form-control" name="puerto_hestia" id="puerto_hestia" aria-describedby="puerto_hestia" placeholder="Pon el puerto de acceso, por defecto es el 8083" required>
                    <small id="puerto_hestia" class="form-text text-muted">Pon el puerto donde accedes desde tu host.</small>
                  </div>
                </div>

                <div class="col-5">
                  <div class="mb-3">
                    <label for="usuario_hestia" class="form-label">Usuario</label>
                    <input type="text"
                      class="form-control" name="usuario_hestia" id="usuario_hestia" aria-describedby="usuario_hestia" placeholder="Por defecto es admin" required>
                    <small id="usuario_hestia" class="form-text text-muted">Pon el usuario de acceso.</small>
                  </div>
                </div>

                <div class="col-5">
                  <div class="mb-3">
                    <label for="contra_hestia" class="form-label">Contraseña</label>
                    <input type="password"
                      class="form-control" name="contra_hestia" id="contra_hestia" aria-describedby="contra_hestia" placeholder="Pon la contraseña" required>
                    <small id="contra_hestia" class="form-text text-muted">Pon la contraseña de acceso del usuario de administración.</small>
                  </div>
                </div>

                <div class="col-5">
                  <div class="mb-3">
                    <label for="ns1" class="form-label">Nombre del servidor primario</label>
                    <input type="text"
                      class="form-control" name="ns1" id="ns1" aria-describedby="ns1" placeholder="Pon el nombre del primer servidor">
                    <small id="ns1" class="form-text text-muted">Cuando el usuario se registre, necesitará un nameserver a donde apuntar su dominio, este paso es obligatorio, ejemplo dns10.josprox.ovh</small>
                  </div>
                </div>
                <div class="col-5">
                  <div class="mb-3">
                    <label for="ns2" class="form-label">Nombre del servidor secundario</label>
                    <input type="text"
                      class="form-control" name="ns2" id="ns2" aria-describedby="ns2" placeholder="Pon el nombre del segundo servidor">
                    <small id="ns2" class="form-text text-muted">Cuando el usuario se registre, necesitará un segundo nameserver a donde apuntar su dominio, este paso es obligatorio, ejemplo ns10.josprox.ovh</small>
                  </div>
                </div>

              </div>

              <p align="justify">El sistema necesita sus credenciales de Mercado pago para poder ejecutar pagos, podrás modificarlo después en el archivo env.</p>

              <div class="row justify-content-center">

                <div class="col-5">
                  <div class="mb-3">
                    <label for="MPPK" class="form-label">Llave pública de Mercado Pago</label>
                    <input type="text"
                      class="form-control" name="MPPK" id="MPPK" aria-describedby="MPPK" placeholder="Pon la llave" required>
                    <small id="MPPK" class="form-text text-muted">Para poder continuar debes poner la llave pública.</small>
                  </div>
                </div>

                <div class="col-5">
                  <div class="mb-3">
                    <label for="MPAT" class="form-label">Access Token</label>
                    <input type="text"
                      class="form-control" name="MPAT" id="MPAT" aria-describedby="MPAT" placeholder="pon el access token" required>
                    <small id="MPAT" class="form-text text-muted">Para poder conectarnos necesitamos el Access Token.</small>
                  </div>
                </div>

              </div>

              <p align="justify">El sistema necesita saber cuál es el dominio en el que se trabajará, es por eso que te pedimos que ingreses tú dominio web. En caso de estar instalando el servidor en un sistema local puede poner localhost.</p>

              <div class="row justify-content-center">

                <div class="col-auto">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="homedir" name="homedir">
                    <label class="form-check-label" for="homedir">Deseas activar el modo producción</label>
                  </div>
                </div>
                <div class="col-auto">
                  <div class="mb-3">
                    <label for="dominio" class="form-label">Nombre del dominio</label>
                    <input type="text"
                      class="form-control" name="dominio" id="dominio" aria-describedby="dominio" value="<?php echo $_SERVER [ 'SERVER_NAME' ]; ?>" placeholder="example.com" required>
                    <small id="dominio" class="form-text text-muted">Por favor inserta tu dominio web.</small>
                  </div>
                </div>


                <div class="col-auto">
                  <div class="mb-3">
                    <label for="" class="form-label">Directorio de la carpeta</label>
                    <input type="text"
                      class="form-control" name="dir" id="dir" aria-describedby="helpId" placeholder="jossecurity">
                    <small id="helpId" class="form-text text-muted">Pon el directorio de la carpeta, solo llenarlo en un entorno de pruebas como localhost. Si llenas este enlace tu resultado podría ser "/jossecurity/public/"</small>
                  </div>
                </div>

              </div>

              <h2 align="center">Felicidades!!</h2>
              <p align="center">Si llenaste todos los datos dale clic en "instalar sitio web" y deja que nosotros nos encarguemos de instalar el sistema.</p>
              <div class="row justify-content-center align-items-center g-2">
                <div class="col text-center">
                  <button name="instalar" type="submit" class="btn btn-primary">Instalar sitio web</button>
                </div>
              </div>

              <br>

        </form>
    </div>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
    integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"
    integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous">
  </script>
</body>

</html>