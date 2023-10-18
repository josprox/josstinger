<?php

    include "./models/routes/home.php";

    $sql = "SELECT usuarios.nombre, usuarios.usuario, usuarios.img, usuarios.num_control, usuarios.discapacidad, gradgrup.grado,gradgrup.grupo, especialidades.especialidad, turnos.turno FROM usuarios INNER JOIN arg_alumno ON usuarios.id = arg_alumno.id_alm INNER JOIN gradgrup ON arg_alumno.id_gg = gradgrup.id INNER JOIN especialidades ON especialidades.id = arg_alumno.id_esp INNER JOIN turnos ON arg_alumno.id_turn = turnos.id WHERE usuarios.id = '$iduser'";

    $resultado = $conexion->query($sql);
    $row = $resultado->fetch_assoc();

    $datauser = "SELECT * FROM arg_alumno WHERE arg_alumno.id_alm = '$iduser'";
    $restdatauser = $conexion->query($datauser);
    $restfull = $restdatauser->fetch_assoc();

    $tugradgrup = $restfull['id_gg'];
    $tuespecialidad = $restfull['id_esp'];
    $tuturno = $restfull['id_turn'];

    $sqlnumcontrols = "SELECT usuarios.id,usuarios.num_control, numcontrols.num, numcontrols.curp, arg_alumno.id_sexo FROM usuarios INNER JOIN numcontrols ON numcontrols.num = usuarios.num_control INNER JOIN arg_alumno ON arg_alumno.id_alm = usuarios.id WHERE usuarios.id = '$iduser'";
    $restsqlnumcontrols = $conexion->query($sqlnumcontrols);
    $control = $restsqlnumcontrols -> fetch_assoc();

    $sexo = $control['id_sexo'];

    $sql_arg_alumno = "SELECT sexo.sexo FROM sexo INNER JOIN arg_alumno ON sexo.id = arg_alumno.id_sexo WHERE arg_alumno.id_alm = '$iduser'";

    $rest_arg_alumno = $conexion->query($sql_arg_alumno);
    $arg_alumno = $rest_arg_alumno -> fetch_assoc();

    $datauser = "SELECT * FROM arg_alumno WHERE arg_alumno.id_alm = '$iduser'";
    $restdatauser = $conexion->query($datauser);
    $restfull = $restdatauser->fetch_assoc();

    $tugradgrup = $restfull['id_gg'];
    $tuespecialidad = $restfull['id_esp'];
    $tuturno = $restfull['id_turn'];

    if (isset($_POST['btn_update'])) {
        $contra = mysqli_real_escape_string($conexion, $_POST['contra_actual']);
        $contra_new = mysqli_real_escape_string($conexion, $_POST['contra_actualizada']);
        $contra_repit = mysqli_real_escape_string($conexion, $_POST['contra_actualizada_2']);

        $sql_password = "SELECT password FROM usuarios WHERE id = '$iduser'";
        $resultado_paswd = $conexion->query($sql_password);
        $check = $resultado_paswd->num_rows;
        if($check > 0){
            $arreglo_pswd = $resultado_paswd->fetch_assoc();
		    $password_encriptada = $arreglo_pswd['password'];
            if(password_verify($contra,$password_encriptada) == TRUE){
                if($contra_new == $contra_repit){
                    $contra_new_encriptada = password_hash($contra_new, PASSWORD_BCRYPT,["cost"=>10]);
                    $sql = "UPDATE usuarios SET password = '$contra_new_encriptada' WHERE id = '$iduser'";
                    $resultado = $conexion->query($sql);
                    if($resultado){
                        echo "<script>alert('Contraseña actualizada correctamente');</script>";
                    }else{
                        echo "<script>alert('Error al actualizar contraseña');</script>";
                    }
                }else{
                    echo "<script>alert('Las contraseñas no coinciden');</script>";
                }
            }else{
                echo "<script>
                alert('Contraseña incorrecta, vuélvelo a intentarlo, escribiste mal la contraseña actual. Error ME-232_alm_password');
                window.location= './';
              </script>";
              }
        }else{
            echo "<script>
            alert('Por el momento estamos teniendo fallas al encontrar tu cuenta. Error ME-232_alm_check');
            window.location= './';
          </script>";
        }
    }

    if(isset($_POST['soporte'])){
        $sql = "SELECT usuarios.usuario, usuarios.nombre, usuarios.num_control FROM usuarios WHERE id = '$iduser'";
        $resultado = $conexion->query($sql);
        $datos = $resultado->fetch_assoc();
        $usuario = $datos['usuario'];
        $nombre = $datos['nombre'];
        $num_control = $datos['num_control'];
        $asunto = mysqli_real_escape_string($conexion, $_POST['motivo']);
        $mensaje = mysqli_real_escape_string($conexion, $_POST['mensaje']);
        $sql_soporte = "INSERT INTO tickets (Usuario, Nombre, num_control, Motivo, Mensaje, created_at) VALUES ('$usuario', '$nombre', '$num_control', '$asunto', '$mensaje', '$fecha')";
        $resultado = $conexion->query($sql_soporte);
        if($resultado){
            echo "<script>alert('Mensaje enviado correctamente');</script>";
        }else{
            echo "<script>alert('Error al enviar mensaje');</script>";
        }
    }

?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <?php include "./models/views/meta.php"; ?>
    <title>Home</title>
</head>
<body>
    
    <?php include "./models/views/nav.php"; ?>

    <div class="contenedor">
        <h2><i class="fa-solid fa-right-from-bracket"></i> Principal</h2>
    </div>

    <div class="media-scroller snaps-inline">

        <div class="media-element">
            <a class="media perfil_open">
                <p><i class="fa-solid fa-user-check"></i> Mi cuenta</p>

            </a>
        </div>

        <div class="media-element">
            <a href="<?php 
                            
                            $descargas = "SELECT descargas.ruta FROM descargas INNER JOIN arg_alumno ON descargas.id_gg = arg_alumno.id_gg && descargas.id_esp = arg_alumno.id_esp && descargas.id_turn = arg_alumno.id_turn WHERE descargas.id_esp = ".$tuespecialidad." && descargas.id_gg = ".$tugradgrup." && descargas.id_turn = ".$tuturno." && descargas.descripcion = 'calificaciones' GROUP BY descargas.ruta;";
                            $restdesc = $conexion->query($descargas);
                            $rowdownload = $restdesc->fetch_assoc();

                            echo "./../../ps-contenido/docs/".$rowdownload['ruta']."";

                            ?>" download="calificaciones.pdf" target="_blank" rel="noopener noreferrer" class="media">
                <p><i class="fa-solid fa-cloud-arrow-down"></i> Mis calificaciones</p>
            </a>
        </div>

        <div class="media-element">
            <a class="media horario_open">
                <p><i class="fa-regular fa-note-sticky"></i> Mi horario</p>
            </a>
        </div>

    </div>
    
    <div class="grid_2">
        
        <div class="two_x_one">

            <div class="grid_2">

                <?php

                    $miconsulta1 = "SELECT maestros.nombre, maestros.img, publicaciones.titulo, publicaciones.vista FROM maestros INNER JOIN arg_public ON maestros.id = arg_public.id_mst INNER JOIN publicaciones ON arg_public.id_pbc = publicaciones.id WHERE arg_public.id_gradgrup = ".$tugradgrup." && arg_public.id_esp = ".$tuespecialidad." && arg_public.id_turno = ".$tuturno." ORDER BY publicaciones.id DESC LIMIT 2;";

                    if ($resultado = mysqli_query($conexion, $miconsulta1)) {
                        while ($registro = mysqli_fetch_array($resultado)) {
                ?>

                    <div class="caja">
                        <?php

                            if ($registro['img'] != "") {

                        ?>
                        <div class="imagen">
                            <img src="./../../ps-contenido/img/maestros/<?php echo $registro['img']; ?>" alt="">
                        </div>
                        <?php
                            }
                        ?>
                        <div class="contenido">
                            <h3><?php echo $registro['titulo']; ?></h3>
                            <p><?php echo $registro['vista']; ?></p>
                        </div>
                        <div class="boton">
                            <a href="post?titulo=<?php echo $registro['titulo']; ?>">Conocer más</a>
                        </div>
                    </div>

                <?php
                    }
                }
                ?>

                <div class="btn_ver_mas">
                    <a href="./publicaciones">Ver mas tareas</a>
                </div>

            </div>

            
        </div>
        
        <div class="two_x_two">


            <div class="grid_3">
        
                <a class="two_x_two" href="proximamente">
                    <p><i class="fa-solid fa-cart-shopping"></i> Tienda</p>
                </a>
        
                <a class="one_x_tree pp2">
                    <p><i class="fa-solid fa-circle-question"></i> Soporte</p>
                </a>
                
                <a class="tree_x_tree pp1">
                    <p><i class="fa-solid fa-unlock"></i> Cambiar Contraseña</p>
                </a>
            </div>
        </div>

    </div>

    <div id="popup">
            <div class="popup_contenido">
                <div class="popup_titulo">
                    <h1>Cambiar la contraseña</h1>
                </div>
                <div class="popup_contenido_texto">
                    <p>Ahora puedes actualizar la contraseña con muy simples pasos.</p>
                    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
                        <label for="contra_actual">Pon la contraseña actual</label>
                        <input type="password" name="contra_actual" id="contra_actual">
                        <label for="contra_actualizada">Pon la nueva contraseña</label>
                        <input type="password" name="contra_actualizada" id="contra_actualizada">
                        <label for="contra_actualizada_2">Repite la nueva contraseña</label>
                        <input type="password" name="contra_actualizada_2" id="contra_actualizada_2">
                        <button name="btn_update" type="submit">Actualizar</button>
                    </form>
                </div>
                <div class="popup_boton pp1_close">
                    <button>Cerrar ventana</button>
                </div>
            </div>
    </div>

    <div id="popupdos">
        <div class="popup_contenido">
            <div class="popup_titulo">
                <h1>Contactanos</h1>
            </div>
            <div class="popup_contenido_texto">
                <p>Hola, entendemos que a veces necesites contactarte con tu escuela, es por eso que, en este formulario podrás mandarnos tus dudas o algunas correcciones que necesitemos hacer, recuerda que se guardará con tu nombre y número de control.</p>
                <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
                    <label for="motivo">Motivo del mensaje</label>
                    <input type="text" name="motivo" id="motivo">
                    <label for="mensaje">Mensaje</label>
                    <textarea name="mensaje" id="mensaje" cols="20" rows="5"></textarea>
                    <button name="soporte" type="submit">Enviar</button>
                </form>
            </div>
            <div class="popup_boton pp2_close">
                <button>Cerrar ventana</button>
            </div>
        </div>
    </div>

    <div id="perfil">
        <div class="popup_contenido">
            <div class="popup_titulo">
                <h1>Mi perfil</h1>
            </div>
            <div class="popup_contenido_texto center_text">
                <p>A continuación te mostramos los datos registrados dentro del sistema.</p>
                <p>Nombre: <?php echo $row['nombre']; ?></p>
                <p>Usuario: <?php echo $row['usuario']; ?></p>
                <p>Tu número de control es: <?php echo $row['num_control']; ?></p>
                <p>Semestre: <?php echo $row['grado']; ?></p>
                <p>Grupo: <?php echo utf8_decode($row['grupo']); ?></p>
                <p>Especialidad: <?php echo $row['especialidad']; ?></p>
                <p>Turno: <?php echo $row['turno']; ?></p>
                <p>Discapacidad: <?php echo $row['discapacidad']; ?></p>
                <p>Curp: <?php echo $control['curp'];?></p>
                <p>Género: <?php echo $arg_alumno['sexo'];?></p>
            </div>
            <div class="popup_boton perfil_close">
                <button>Cerrar ventana</button>
            </div>
        </div>
    </div>

    <div id="horario">
        <div class="popup_contenido">
            <div class="popup_titulo">
                <h1>Mi horario</h1>
            </div>
            <div class="popup_contenido_texto">
                <p>El siguiente archivo es tu horario correspondiente.</p>
                <embed src="<?php   
                        $horario = "SELECT descargas.ruta FROM descargas INNER JOIN arg_alumno ON descargas.id_gg = arg_alumno.id_gg && descargas.id_esp = arg_alumno.id_esp && descargas.id_turn = arg_alumno.id_turn WHERE descargas.id_esp = ".$tuespecialidad." && descargas.id_gg = ".$tugradgrup." && descargas.id_turn = ".$tuturno." && descargas.descripcion = 'horario' GROUP BY descargas.ruta;";
                        $resthorario = $conexion->query($horario);
                        $rowhorario = $resthorario->fetch_assoc();

                        echo "./../../ps-contenido/docs/".$rowhorario['ruta']."";
                        ?>" class="pdf" type="application/pdf">
            </div>
            <div class="popup_boton horario_close">
                <button>Cerrar ventana</button>
            </div>
        </div>
    </div>

    <?php include "./models/views/navbar.php"; include "./models/views/footer.php"; ?>
    
</body>
</html>