<?php

include (__DIR__ . "/../../jossecurity.php");

login_cookie('jpx_users');

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ./../panel");
}

$iduser = $_SESSION['id_usuario'];
secure_auth_admin($iduser,"../");

?>

<!doctype html>
<html lang="es-MX">

<head>
  <title><?php echo $nombre_app," versión: ", $version_app; ?></title>
  <?php head_admin(); ?>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

</head>

<body>

  <?php navbar_admin(); ?>

  <br>

  <div class="container">

    <?php
    if (isset($_POST['actualizar'])){
        $conexion = conect_mysqli();
        $id = mysqli_real_escape_string($conexion, (int) $_POST['id']);
        $nombre = mysqli_real_escape_string($conexion, (string) $_POST['nombre']);
        $descripcion = mysqli_real_escape_string($conexion, (string) $_POST['descripcion']);
        $precio = mysqli_real_escape_string($conexion, (float) $_POST['precio']);
        mysqli_close($conexion);
        actualizar_datos_mysqli("jpx_servicios","`nombre` = '$nombre', `descripcion_text` = '$descripcion', `precio` = '$precio', `updated_at` = '$fecha'","id",$id);
        ?>
        <script>
            Swal.fire(
            '¡Buen trabajo!',
            'Se ha actualizado todo de manera correcta',
            'success'
            )
            </script>
        <script>
            timer: 8000,
            window.location.href = "./productos"
        </script>
        <?php
    }elseif(isset($_POST['agregar'])){
        $conexion = conect_mysqli();
        $nombre = mysqli_real_escape_string($conexion, (string) $_POST['nombre']);
        $descripcion = mysqli_real_escape_string($conexion, (string) $_POST['descripcion']);
        $descripcion_text = mysqli_real_escape_string($conexion, (string) $_POST['descripcion_text']);
        $precio = mysqli_real_escape_string($conexion, (float) $_POST['precio']);
        mysqli_close($conexion);
        insertar_datos_clasic_mysqli("jpx_servicios","nombre, descripcion, descripcion_text, precio, created_at","'$nombre', '$descripcion', '$descripcion_text', '$precio', '$fecha'");
        ?>
        <script>
            Swal.fire(
            '¡Buen trabajo!',
            'Se ha agregado todo de manera correcta',
            'success'
            )
            </script>
        <script>
            timer: 8000,
            window.location.href = "./productos"
        </script>
        <?php
    }elseif(isset($_POST['eliminar'])){
        $conexion = conect_mysqli();
        $id = mysqli_real_escape_string($conexion, (int) $_POST['id']);
        mysqli_close($conexion);
        eliminar_datos_con_where("jpx_servicios","id",$id);
        ?>
        <script>
            Swal.fire(
            '¡Buen trabajo!',
            'Se ha eliminado de manera correcta',
            'success'
            )
            </script>
        <script>
            timer: 8000,
            window.location.href = "./productos"
        </script>
        <?php
    }elseif(isset($_POST['actualizar_todo'])){
        $conexion = conect_mysqli();
        $id = mysqli_real_escape_string($conexion, (int) $_POST['id']);
        $nombre = mysqli_real_escape_string($conexion, (string) $_POST['nombre']);
        $descripcion = mysqli_real_escape_string($conexion, (string) $_POST['descripcion']);
        $descripcion_text = mysqli_real_escape_string($conexion, (string) $_POST['descripcion_text']);
        $precio = mysqli_real_escape_string($conexion, (float) $_POST['precio']);
        mysqli_close($conexion);
        actualizar_datos_mysqli("jpx_servicios","`nombre` = '$nombre', `descripcion` = '$descripcion',`descripcion_text` = '$descripcion_text', `precio` = '$precio', `updated_at` = '$fecha'","id",$id);
        ?>
        <script>
            Swal.fire(
            '¡Buen trabajo!',
            'Se ha actualizado todo de manera correcta',
            'success'
            )
            </script>
        <script>
            timer: 8000,
            window.location.href = "./productos"
        </script>
        <?php
    }elseif(isset($_POST['editar'])){
        $conexion = conect_mysqli();
        $id = mysqli_real_escape_string($conexion, (int) $_POST['id']);
        mysqli_close($conexion);
        $consulta = consulta_mysqli_where("*","jpx_servicios","id",$id);
        ?>
        <h1>Datos del paquete.</h1>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text"
                class="form-control" name="nombre" id="nombre" aria-describedby="nombre" placeholder="Pon el nombre del producto." value="<?php echo $consulta['nombre']; ?>">
              <small id="nombre" class="form-text text-muted">Pon el nombre del producto.</small>
            </div>
            <div class="mb-3">
              <label for="descripcion" class="form-label">Descripción html</label>
              <textarea class="form-control" name="descripcion" id="descripcion" rows="4"><?php echo $consulta['descripcion']; ?></textarea>
            </div>
            <div class="mb-3">
              <label for="descripcion_text" class="form-label">Descripcion texto</label>
              <textarea class="form-control" name="descripcion_text" id="descripcion_text" rows="4"><?php echo $consulta['descripcion_text']; ?></textarea>
            </div>
            <div class="mb-3">
              <label for="precio" class="form-label">Precio del producto</label>
              <input type="number"
                class="form-control" step="any" name="precio" id="precio" aria-describedby="precio" placeholder="Pon el precio" value="<?php echo $consulta['precio']; ?>">
              <small id="precio" class="form-text text-muted">Pon el precio del producto.</small>
            </div>
            <div class="flex_center">
                <button type="submit" name="actualizar_todo" class="btn btn-success">Actualizar</button>
            </div>
            <br>
        </form>
        <?php
    }else{
        ?>
    <div id="register">
        <button class="btn btn-primary" onclick="closeForm();">Cancelar</button>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text"
                class="form-control" name="nombre" id="nombre" aria-describedby="nombre" placeholder="Producto">
              <small id="nombre" class="form-text text-muted">Pon el nombre del producto.</small>
            </div>
            <div class="mb-3">
              <label for="descripcion" class="form-label">Pon el código html</label>
              <textarea class="form-control" name="descripcion" id="descripcion" rows="6"></textarea>
            </div>
            <div class="mb-3">
              <label for="descripcion_text" class="form-label">Descripción</label>
              <textarea class="form-control" name="descripcion_text" id="descripcion_text" rows="5"></textarea>
            </div>
            <div class="mb-3">
              <label for="precio" class="form-label">Precio</label>
              <input type="number"
                class="form-control" name="precio" id="precio" aria-describedby="precio" placeholder="Valor">
              <small id="precio" class="form-text text-muted">Pon el precio del producto.</small>
            </div>
            <center>
                <button type="submit" name="agregar" class="btn btn-success">Agregar</button>
            </center>
        </form>
    </div>
    <div id="login">

        <button class="btn btn-primary" onclick="registerForm();">Registrar nuevo producto</button>

        <div class="table-responsive">
          <table class="table table-striped
          table-hover	
          table-borderless
          table-primary
          align-middle">
            <thead class="table-dark">
              <caption>Productos</caption>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción html</th>
                <th>Descripción texto</th>
                <th>Precio</th>
                <th>Creado</th>
                <th>Actualizado</th>
                <th>Acciones</th>
              </tr>
              </thead>
              <tbody class="table-group-divider">
                <?php
                foreach (arreglo_consulta("SELECT * FROM jpx_servicios") as $row){?>
            <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <tr class="table-primary" >
                    <td><input type="number" name="id" class="form-control" value="<?php echo $row['id']; ?>" disabled></td>
                    <td scope="row"><input name="nombre" class="form-control" type="text" value="<?php echo $row['nombre']; ?>"></td>
                    <td align="center"><p>Para poder verlo deberás editarlo</p></td>
                    <td class="">
                        <div class="mb-3">
                        <label for="" class="form-label"></label>
                        <textarea class="form-control" name="descripcion" rows="6"><?php echo $row['descripcion_text']; ?></textarea>
                        </div>
                    </td>
                    <td><input type="number" name="precio" step="any" class="form-control" value="<?php echo $row['precio']; ?>"></td>
                    <?php
                    if($row['created_at'] == NULL){
                        ?>
                    <td>No registrado</td>
                        <?php
                    }else{
                        ?>
                    <td><?php echo $row['created_at']; ?></td>
                        <?php
                    }
                    if($row['updated_at'] == NULL){
                        ?>
                    <td>Nunca se ha actualizado</td>
                        <?php
                    }else{
                        ?>
                    <td><?php echo $row['updated_at']; ?></td>
                        <?php
                    }
                    ?>
                    <td>
                        <center>
                            <div>
                                    <button type="submit" name="actualizar" class="btn btn-success">Actualizar</button>
                            </div>
                            <br>
                            <div>
                                    <button type="submit" name="editar" class="btn btn-primary">Editar</button>
                            </div>
                            <br>
                            <div>
                                <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                            </div>
                        </center>
                    </td>
                </tr>
            </form>
                <?php
                }
                ?>
              </tbody>
              <tfoot>
                
              </tfoot>
          </table>
        </div>
    </div>
        <?php
    }
    ?>


  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <?php footer_admin(); ?>
  <script>
    function registerForm(){
      document.getElementById('login').style.display = 'none';
      document.getElementById('register').style.display = 'block';
    }
    function closeForm(){
      document.getElementById('login').style.display = 'block';
      document.getElementById('register').style.display = 'none';
    }
  </script>
</body>

</html>
