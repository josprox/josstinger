<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie("users");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../panel");
}

$iduser = $_SESSION['id_usuario'];
secure_auth_admin($iduser,"../");

if($_ENV['CONECT_POSTGRESQL'] != 1){
  header("location: ./");
}

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

  <?php navbar_admin(); ?>

  <br>

  <div class="container">

    <h1 align="Center">Sistema de PostgreSQL</h1>
    <p align="justify">Aquí podrás hacer todo lo que requieras con PostgreSQL.</p>

    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
      <div class="col-auto">
        <div class="mb-3">
          <label for="usos" class="form-label">Usos</label>
          <select multiple class="form-select form-select-lg" name="usos" id="usos">
            <option selected>Selecciona alguna acción</option>
            <option value="1">Crear una Tabla</option>
            <option value="2">Insertar datos</option>
            <option value="3">Actualizar datos</option>
            <option value="4">Eliminar tabla</option>
          </select>
        </div>
      </div>
      <div class="col-auto">
        <button name="ejecutar" type="submit" class="btn btn-primary">Ejecutar</button>
      </div>
    </form>

    <?php
    if(isset($_POST['nuevo'])){
      $tabla = $_POST['tabla'];
      $contenido = $_POST['contenido'];
      echo crear_tabla_psg($tabla,$contenido);
    }
    if(isset($_POST['eliminar_tabla'])){
      $tabla = $_POST['tabla'];
      echo eliminar_tabla_psg($tabla);
    }
    if(isset($_POST['insertar'])){
      $tabla = $_POST['tabla'];
      $valores = $_POST['valores'];
      $contenido = $_POST['contenido'];
      echo insertar_datos_psg($tabla,$valores,$contenido);
    }

    if(isset($_POST['actualizar'])){
      $tabla = $_POST['tabla'];
      $contenido = $_POST['contenido'];
      $comparar = $_POST['comparar'];
      $datos = $_POST['datos'];
      echo actualizar_datos_psg($tabla,$contenido,$comparar,$datos);
    }

    if (isset($_POST['ejecutar'])){
      $opcion = $_POST['usos'];
      if($opcion == 1){
        ?>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">

          <div class="row justify-content-center">

            <div class="col-5">
              <div class="mb-3">
                <label for="tabla" class="form-label">Nombre de la tabla</label>
                <input type="text"
                  class="form-control" name="tabla" id="tabla" aria-describedby="tabla" placeholder="Escribe el nombre de la tabla">
                <small id="tabla" class="form-text text-muted">Pon el nombre de la tabla a crear</small>
              </div>
            </div>

            <div class="col-5">
              <div class="mb-3">
                <label for="contenido" class="form-label">Inserta los valores que contendrá la tabla.</label>
                <textarea class="form-control" name="contenido" id="contenido" rows="4"></textarea>
              </div>
            </div>

            <div class="col-auto">
              <button name ="nuevo" type="submit" class="btn btn-primary">Añadir</button>
            </div>

          </div>

        </form>
        <?php
      }elseif($opcion == 2){
        ?>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">

          <div class="row justify-content-center">

            <div class="col-5">
              <div class="mb-3">
                <label for="tabla" class="form-label">Tabla</label>
                <input type="text"
                  class="form-control" name="tabla" id="tabla" aria-describedby="tabla" placeholder="Pon el nombre de la tabla">
                <small id="tabla" class="form-text text-muted">Pon la tabla donde se actualizará la información.</small>
              </div>
            </div>

            <div class="col-5">
              <div class="mb-3">
                <label for="valores" class="form-label">Valores</label>
                <input type="text"
                  class="form-control" name="valores" id="valores" aria-describedby="valores" placeholder="Pon los valores que se agregarán">
                <small id="valores" class="form-text text-muted">Pon los valores que se actualizarán.</small>
              </div>
            </div>

            <div class="col-10">
              <div class="mb-3">
                <label for="contenido" class="form-label">Inserta el contenido a ingresar</label>
                <textarea class="form-control" name="contenido" id="contenido" rows="4"></textarea>
              </div>
            </div>

            <div class="col-auto">
              <button name ="insertar" type="submit" class="btn btn-primary">Añadir</button>
            </div>

          </div>

        </form>
      <?php
      }elseif($opcion == 3){
        ?>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">

          <div class="row justify-content-center">

            <div class="col-10">
              <div class="mb-3">
                <label for="tabla" class="form-label">Tabla</label>
                <input type="text"
                  class="form-control" name="tabla" id="tabla" aria-describedby="tabla" placeholder="Pon el nombre de la tabla">
                <small id="tabla" class="form-text text-muted">Pon la tabla donde se insertará la información.</small>
              </div>
            </div>

            <div class="col-10">
              <div class="mb-3">
                <label for="contenido" class="form-label">Inserta el contenido a modificar</label>
                <textarea class="form-control" name="contenido" id="contenido" rows="3"></textarea>
              </div>
            </div>

            <div class="col-5">
              <div class="mb-3">
                <label for="comparar" class="form-label">Comparar</label>
                <input type="text"
                  class="form-control" name="comparar" id="comparar" aria-describedby="comparar" placeholder="Por favor dime que vamos a comparar">
                <small id="comparar" class="form-text text-muted">Dinos con que datos compararemos para modificar. Ejemplo ID.</small>
              </div>
            </div>

            <div class="col-5">
              <div class="mb-3">
                <label for="datos" class="form-label">Datos</label>
                <input type="text"
                  class="form-control" name="datos" id="datos" aria-describedby="datos" placeholder="Pon los datos que compararemos">
                <small id="datos" class="form-text text-muted">Dinos que datos se compararán. Ejemplo 1.</small>
              </div>
            </div>

            <div class="col-auto">
              <button name ="actualizar" type="submit" class="btn btn-primary">Añadir</button>
            </div>

          </div>

        </form>
      <?php
      }elseif($opcion == 4){
        ?>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">

          <div class="row justify-content-center">

            <div class="col-10">
              <div class="mb-3">
                <label for="tabla" class="form-label">Tabla</label>
                <input type="text"
                  class="form-control" name="tabla" id="tabla" aria-describedby="tabla" placeholder="Pon el nombre de la tabla">
                <small id="tabla" class="form-text text-muted">Pon la tabla que eliminaremos</small>
              </div>
            </div>

            <div class="col-auto">
              <button name ="eliminar_tabla" type="submit" class="btn btn-primary">Eliminar</button>
            </div>

          </div>

        </form>
      <?php
      }
    }
    ?>

  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
</body>

</html>