<?php
// Aquí pon los jossitos que desees crear.
function consulta_MySQL_externa($host, $usuario, $contra, $DB, $sql, $puerto = 3306){
    $conexion = new mysqli("$host","$usuario","$contra","$DB",$puerto);
    $conexion->set_charset("utf8");
    $query = $conexion->query($sql);
    $conexion = null;
    return $query;
}

function consulta_MySQL_externa_json($host, $usuario, $contra, $DB, $sql, $puerto = 3306){
    $conexion = new mysqli("$host","$usuario","$contra","$DB",$puerto);
    $conexion->set_charset("utf8");
    $resultado = $conexion->query($sql);
    $conexion -> close();
    $json = [];
    while($row = mysqli_fetch_assoc($resultado)){
        $json[] = $row;
    }
    $json_resultado = json_encode($json, JSON_UNESCAPED_UNICODE);
    // Codifica la cadena de texto JSON en UTF-8
    return $json_resultado;
}

?>