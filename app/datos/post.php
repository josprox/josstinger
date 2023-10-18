<?php 

    include "./models/routes/home.php";

    $sql = "SELECT usuarios.nombre, usuarios.img, usuarios.num_control, gradgrup.grado,gradgrup.grupo, especialidades.especialidad, turnos.turno FROM usuarios
    INNER JOIN arg_alumno ON usuarios.id = arg_alumno.id_alm INNER JOIN gradgrup
    ON arg_alumno.id_gg = gradgrup.id INNER JOIN especialidades
    ON especialidades.id = arg_alumno.id_esp INNER JOIN turnos
    ON arg_alumno.id_turn = turnos.id WHERE usuarios.id = '$iduser'";

    $resultado = $conexion->query($sql);
    $row = $resultado->fetch_assoc();

    $datauser = "SELECT * FROM arg_alumno WHERE arg_alumno.id_alm = '$iduser'";
    $restdatauser = $conexion->query($datauser);
    $restfull = $restdatauser->fetch_assoc();

    $tugradgrup = $restfull['id_gg'];
    $tuespecialidad = $restfull['id_esp'];
    $tuturno = $restfull['id_turn'];

?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <?php include "./models/views/meta.php"; ?>
    <title>Perfil</title>
</head>
<body>
    
    <?php include "./models/views/nav.php"; ?>

    <div class="contenedor_sin_fondo">

        <div class="grid_3">

            <div class="publicaciones">
                <?php
                $id =$_GET["titulo"];

                $miconsulta = "SELECT maestros.nombre, maestros.img, publicaciones.titulo, publicaciones.descripcion FROM maestros
                INNER JOIN arg_public ON maestros.id = arg_public.id_mst INNER JOIN publicaciones
                ON arg_public.id_pbc = publicaciones.id WHERE titulo='$id'";

                if($resultado=mysqli_query($conexion,$miconsulta)){
                    while($registro = mysqli_fetch_array($resultado)){
                ?>
                <div class="principal">
                    <div class="img">
                        <img src="./../../ps-contenido/img/maestros/<?php echo $registro["img"]; ?>" alt="">
                    </div>
                    <div class="presentacion">
                        <h1><?php echo $registro["titulo"]; ?></h1>
                        <p>Maestro(a): <?php echo $registro["nombre"]; ?></p>
                    </div>
                </div>
                <div class="contenido">
                    <?php echo $registro["descripcion"]; ?>
                </div>
                <?php
                }
            }
                ?>
            </div>

            <div class="post">

            <?php
                    $miconsulta1 = "SELECT maestros.nombre, maestros.img, publicaciones.titulo, publicaciones.vista FROM maestros INNER JOIN arg_public ON maestros.id = arg_public.id_mst INNER JOIN publicaciones ON arg_public.id_pbc = publicaciones.id WHERE arg_public.id_gradgrup = ".$tugradgrup." && arg_public.id_esp = ".$tuespecialidad." && arg_public.id_turno = ".$tuturno." ORDER BY publicaciones.id DESC LIMIT 4;";

                    if ($resultado = mysqli_query($conexion, $miconsulta1)) {
                        while ($registro = mysqli_fetch_array($resultado)) {
                    ?>

                <div class="tarjetas">

                    <div class="contenido">
                        <h3><?php echo $registro["titulo"]; ?></h3>
                        <p><?php echo $registro["vista"]; ?></p>
                        <a href="post?titulo=<?php echo $registro['titulo']; ?>">Vamos allá</a>
                    </div>

                    <?php
                        if ($registro['img'] != "") {
                    ?>
                    <div class="img">
                        <img src="./../../ps-contenido/img/maestros/<?php echo $registro["img"]; ?>" alt="">
                    </div>

                    <?php } ?>

                </div>

                <?php
                
                    }
                }

                ?>

                <div class="btn_ver_mas">
                    <a href="publicaciones">Ver más</a>
                </div>

            </div>

        </div>

    </div>

    <?php include "./models/views/navbar.php"; include "./models/views/footer.php"; ?>
    
</body>
</html>