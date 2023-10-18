<?php

require "./../../../ps-conexion/conexion.php";


/* iniciar la sesión */

session_start();
$iduser = $_SESSION['id_usuario'];
$iduser = (int)$iduser;

header('Content-Type: text/css');

$sql_sexo = "SELECT id_sexo FROM arg_alumno WHERE id_alm = $iduser";
$resultado = $conexion->query($sql_sexo);
$row = $resultado->fetch_assoc();
$sexo = $row['id_sexo'];

if ($sexo == 5) {
    echo "body{background-color: #FBDA61;background-image: linear-gradient(45deg, #FBDA61 0%, #FF5ACD 100%);}";
}

if ($sexo == 6) {
    echo "body{background-color: #FAACA8;background-image: linear-gradient(19deg, #FAACA8 0%, #DDD6F3 100%);}";
}

if ($sexo == 7) {
    echo "body{background-color: #3EECAC;background-image: linear-gradient(19deg, #3EECAC 0%, #EE74E1 100%);}";
}

?>