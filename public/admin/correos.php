<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../panel");
}
$iduser = $_SESSION['id_usuario'];
secure_auth_admin($iduser,"../");

// Trae nombre.
$row = new GranMySQL();
$row -> seleccion = "name";
$row -> tabla = "users";
$row -> comparar = "id";
$row -> comparable = $iduser;
$consulta = $row -> where();

?>

<!doctype html>
<html lang="es-MX">

<head>
  <title><?php echo $nombre_app," versión: ", $version_app; ?></title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php head_admin(); ?>

</head>

<body>

  <?php navbar_admin(); 
    if(!isset($_ENV['SMTP_ACTIVE']) || $_ENV['SMTP_ACTIVE'] != 1){
      ?>
      <div class="alert alert-warning" role="alert">
        <strong>Advertencia:</strong> El sistema para enviar correos se encuentra desactivado, favor de activarlo en el archivo de configuración env.
      </div>
      <?php
    }
    if(isset($_POST['ejecutar'])){
      $conexion = conect_mysqli();
      $ejecutar = mysqli_real_escape_string($conexion, $_POST['opcion']);
      switch ($ejecutar){
        case "cb":
          $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
          if(mail_smtp_v1_3_check($correo) == TRUE){
            ?>
            <script>
              Swal.fire(
                'Enviado',
                'El mensaje ha sido enviado con éxito',
                'success'
              )
            </script>
            <?php
          }
          break;
 
        case "cp":
          $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
          $asunto = mysqli_real_escape_string($conexion, $_POST['asunto']);
          $contenido = mysqli_real_escape_string($conexion, $_POST['contenido']);
          $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
          if(mail_smtp_v1_3($nombre,$asunto,$contenido,$correo) == TRUE){
            ?>
            <script>
              Swal.fire(
                'Enviado',
                'El mensaje ha sido enviado con éxito',
                'success'
              )
            </script>
            <?php
          }
          break;
        case "rc":
          $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
          $asunto = mysqli_real_escape_string($conexion, $_POST['asunto']);
          $contenido = mysqli_real_escape_string($conexion, $_POST['contenido']);
          $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
          if(mail_smtp_v1_3_recibir($nombre,$asunto,$contenido,$correo) == TRUE){
            ?>
            <script>
              Swal.fire(
                'Enviado',
                'El mensaje ha sido enviado con éxito',
                'success'
              )
            </script>
            <?php
          }
          break;
      }
      $conexion -> close();
    }
  ?>

  <div class="container">
    <h1 class="text-center">Prueba de correo</h1>
    <p class="text-justify">
      Hola <?php echo $consulta['name']; ?>, aquí podrás poner a prueba tu configuración SMTP, a continuación, podrás seleccionar una forma de comprobar su configuración.
    </p>
    <div class="blog">
      <div class="sinopsis">
        <ul class="grid_1_auto text-center">
          <li class="list-group-item"><button onclick="correo_sencillo();">Correo sencillo</button></li>
          <li class="list-group-item"><button onclick="correo_personalizado();">Correo personalizado</button></li>
          <li class="list-group-item"><button onclick="recibir_correo();">Recibir correo</button></li>
        </ul>
      </div>
      <div class="contenido">
        <form id="cb" style="display: block;" action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
          <div class="grid_1" id="">
            <div class="mb-3">
              <label for="correo" class="form-label">Correo</label>
              <input
                type="email"
                class="form-control"
                name="correo"
                id="correo"
                aria-describedby="correo"
                placeholder="Pon el correo donde se enviará el mensaje."
              />
              <input type="hidden" name="opcion" value="cb">
              <small id="correo" class="form-text text-muted">Aquí va el correo.</small>
            </div>

            <button
              type="submit"
              class="btn btn-primary"
              name="ejecutar"
            >
              Enviar correo
            </button>
            
            
          </div>
        </form>

        <form id="cp" style="display: none;" action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
          <div class="grid_1">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input
                  type="email"
                  class="form-control"
                  name="correo"
                  id="correo"
                  aria-describedby="correo"
                  placeholder="Pon el correo donde se enviará el mensaje."
                />
                <small id="correo" class="form-text text-muted">Aquí va el correo.</small>
              </div>

              <div class="mb-3">
                <label for="asunto" class="form-label">Asunto</label>
                <input
                  type="text"
                  class="form-control"
                  name="asunto"
                  id="asunto"
                  aria-describedby="asunto"
                  placeholder="Pon el asunto del correo"
                />
                <small id="asunto" class="form-text text-muted">Pon el asunto del correo</small>
              </div>

              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input
                  type="text"
                  class="form-control"
                  name="nombre"
                  id="nombre"
                  aria-describedby="nombre"
                  placeholder="Pon el nombre de quien envía el correo"
                />
                <small id="nombre" class="form-text text-muted">Aquí va el nombre a mostrar de tu correo.</small>
              </div>
              
              <div class="mb-3">
                <label for="contenido" class="form-label">Cuerpo</label>
                <textarea class="form-control textarea" name="contenido" id="contenido" rows="3"></textarea>
              </div>

              <input type="hidden" name="opcion" value="cp">
              <button
                type="submit"
                class="btn btn-primary"
                name="ejecutar"
              >
                Enviar correo
              </button>
          </div>
        </form>

        <form id="rc" style="display: none;" action="<?php echo htmlentities((string) $_SERVER['PHP_SELF']); ?>" method="post">
        <div class="grid_1">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input
                  type="email"
                  class="form-control"
                  name="correo"
                  id="correo"
                  aria-describedby="correo"
                  placeholder="Pon el correo donde se recibirá el mensaje."
                />
                <small id="correo" class="form-text text-muted">Aquí va el correo.</small>
              </div>

              <div class="mb-3">
                <label for="asunto" class="form-label">Asunto</label>
                <input
                  type="text"
                  class="form-control"
                  name="asunto"
                  id="asunto"
                  aria-describedby="asunto"
                  placeholder="Pon el asunto del correo"
                />
                <small id="asunto" class="form-text text-muted">Pon el asunto del correo</small>
              </div>

              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input
                  type="text"
                  class="form-control"
                  name="nombre"
                  id="nombre"
                  aria-describedby="nombre"
                  placeholder="Pon el nombre de quien envía el correo"
                />
                <small id="nombre" class="form-text text-muted">Aquí va el nombre a mostrar de tu correo.</small>
              </div>

              <div class="mb-3">
                <label for="contenido" class="form-label">Contenido</label>
                <input
                  type="text"
                  class="form-control"
                  name="contenido"
                  id="contenido"
                  aria-describedby="contenido"
                  placeholder="Pon el contenido en el mensaje"
                />
                <small id="contenido" class="form-text text-muted">Aquí va el conteenido.</small>
              </div>
              

              <input type="hidden" name="opcion" value="rc">
              
              <button
                type="submit"
                class="btn btn-primary"
                name="ejecutar"
              >
                Enviar correo
              </button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
  <script>
        function correo_sencillo(){
            document.getElementById('cb').style.display = 'block';
            document.getElementById('cp').style.display = 'none';
            document.getElementById('rc').style.display = 'none';
        }
        function correo_personalizado(){
          document.getElementById('cb').style.display = 'none';
            document.getElementById('cp').style.display = 'block';
            document.getElementById('rc').style.display = 'none';
        }
        function recibir_correo(){
          document.getElementById('cb').style.display = 'none';
            document.getElementById('cp').style.display = 'none';
            document.getElementById('rc').style.display = 'block';
        }
    </script>
</body>

</html>