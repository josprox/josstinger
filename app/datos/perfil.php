<?php

    include "./models/routes/home.php";

    $sql = "SELECT usuarios.nombre, usuarios.usuario, usuarios.img, usuarios.num_control, usuarios.discapacidad, usuarios.img, gradgrup.grado,gradgrup.grupo, especialidades.especialidad, turnos.turno FROM usuarios INNER JOIN arg_alumno ON usuarios.id = arg_alumno.id_alm INNER JOIN gradgrup ON arg_alumno.id_gg = gradgrup.id INNER JOIN especialidades ON especialidades.id = arg_alumno.id_esp INNER JOIN turnos ON arg_alumno.id_turn = turnos.id WHERE usuarios.id = '$iduser'";

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

    //Actualizar la imagen de perfil

    if (isset($_POST["btn_enviar"])) {

        $imagen = $_FILES['imagen']['name'];

        if($_FILES['imagen']['error']){
    
            switch($_FILES['imagen']['error']){
                case 1: // Error exceso de tamaño de archivo php.ini
                    echo"Tamaño del Archivo excede lo permitido por el server";
                break;
    
                case 2: //Excede la directiva MAX_FILE
                    echo "EL TAMAÑO DEL ARCHIVO EXCEDE";
                break;
                case 3: //El fichero fue solo parcialmente subido
                    echo "Corrupción de archivo";
                break;
                case 4: //No se subio el fichero
                    echo "No se envió archivo de imagen";
                break;
            }
    
        }else{
            if ((isset($_FILES['imagen']['name'])&&($_FILES['imagen']['error']==UPLOAD_ERR_OK))){
    
                $destino_de_ruta ="./../../ps-contenido/img/alumnos/";
    
                move_uploaded_file($_FILES['imagen']['tmp_name'],$destino_de_ruta . $_FILES['imagen']['name']);
    
            }else{
                echo "El archivo no se ha podido copiar a imagenes";
            }
        }
    
        $img_datos = "SELECT img FROM usuarios WHERE id = '$iduser'";
    
        $consulta_img = $conexion->query($img_datos);
    
        $info_img = $consulta_img->fetch_assoc();
    
        $img_actual = $info_img['img'];
    
    if ($img_actual == "main.webp") {
        
        $myconsulta ="UPDATE usuarios SET img = '$imagen' WHERE usuarios.id = '$iduser'";
    
        $resultado = mysqli_query($conexion, $myconsulta);
    
        /* Cerramos conexion */
    
        /*mysqli_close($conexion);*/
    
        echo "<script>
                alert('La imagen fue actualizada correctamente. Codigo: perfil_img_1');
                window.location= './perfil';
            </script>";
    }else{
    
        if (unlink("./../../ps-contenido/img/alumnos/$img_actual")){
            $myconsulta ="UPDATE usuarios SET img = '$imagen' WHERE usuarios.id = '$iduser'";
        
            $resultado = mysqli_query($conexion, $myconsulta);
        
            /* Cerramos conexion */
        
            /*mysqli_close($conexion);*/
        
            echo "<script>
                    alert('La imagen fue actualizada correctamente. Codigo: perfil_img_2');
                    window.location= './perfil';
                </script>";
        }else{
            echo "<script>
                    alert('La imagen fue subida al servidor pero no se pudo actualizar en la base de datos. Error: perfil_img_221');
                    window.location= './perfil';
                </script>";
        }
    
    }
    
    }

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

        <div class="grid_2">

            <div class="two_x_one">
                <div class="tarjeta_perfil">
                    <div class="tarjeta_perfil_foto">
                        <img src="./../../ps-contenido/img/alumnos/<?php echo $row['img']; ?>" alt="">
                    </div>
                    <div class="tarjeta_perfil_datos">
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
                </div>
            </div>

            <div class="two_x_two">
                <form action="" method="POST" enctype="multipart/form-data" name="form1">
                    <table>
                        <input type="hidden" name="MAX_TAM" value="2097152" />
                        <tr>
                            <td  align="center">Cambiar imagen de perfil</td>
                        </tr>
                        <tr>
                            <td  align="center">Seleccione una imagen con tamaño inferior a 2 MB</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left">
                                <div id="div_file">
                                    <p id="txtimg" >Insertar imagen</p>
                                    <input type="file" name="imagen" id="imagen" />
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" align="center">
                                <input type="submit" name="btn_enviar" id="btn_enviar" value="Enviar" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>

        </div>

    </div>

    <?php include "./models/views/navbar.php"; include "./models/views/footer.php"; ?>
    
</body>
</html>