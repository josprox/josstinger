<?php

if($_ENV['CONECT_POSTGRESQL'] == 1){
    function conect_pg(){
        $host_psg = (string)$_ENV['HOST_PSG'];
        $user_psg = (string)$_ENV['USUARIO_PSG'];
        $pass_psg = (string)$_ENV['CONTRA_PSG'];
        $DB_psg = (string)$_ENV['BASE_DE_DATOS_PSG'];
        $puerto_psg = (string)$_ENV['PUERTO_PSG'];
        $conexion = pg_connect("host=$host_psg port=$puerto_psg dbname=$DB_psg user=$user_psg password=$pass_psg");

        if($conexion == TRUE){
            if ($_ENV['DEBUG'] == 1){
                echo "<script>console.log('La conexión PostgreSQL ha funcionado.');</script>";
            }
        }else{
            if ($_ENV['DEBUG'] == 1){
                echo "<script>console.log('La conexión PostgreSQL ha fallado.');</script>";
            }
        }
        return $conexion;
    }
}
if($_ENV['CONECT_POSTGRESQL'] != 1){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('La conexión PostgreSQL está desactivada.');</script>";
    }
}
if($_ENV['CONECT_POSTGRESQL_PDO'] == 1){
    function conect_pg_PDO(){
        $host_psg = (string)$_ENV['HOST_PSG'];
        $user_psg = (string)$_ENV['USUARIO_PSG'];
        $pass_psg = (string)$_ENV['CONTRA_PSG'];
        $DB_psg = (string)$_ENV['BASE_DE_DATOS_PSG'];
        $puerto_psg = (string)$_ENV['PUERTO_PSG'];
        $conexion = new PDO("pgsql:host=$host_psg;port=$puerto_psg;dbname=$DB_psg", $user_psg, $pass_psg);

        if($conexion == TRUE){
            if ($_ENV['DEBUG'] == 1){
                echo "<script>console.log('La conexión PostgreSQL PDO ha funcionado.');</script>";
            }
        }else{
            if ($_ENV['DEBUG'] == 1){
                echo "<script>console.log('La conexión PostgreSQL PDO ha fallado.');</script>";
            }
        }
        return $conexion;
    }
}
if($_ENV['CONECT_POSTGRESQL_PDO'] != 1){
    if ($_ENV['DEBUG'] == 1){
        echo "<script>console.log('La conexión PostgreSQL PDO está desactivada.');</script>";
    }
}

function crear_tabla_psg($tabla,$contenido){
    $conexion = conect_pg();
    $sql = "CREATE TABLE $tabla (
        id bigint NOT NULL GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
        $contenido,
        created_at timestamp NULL DEFAULT NULL,
        updated_at timestamp NULL DEFAULT NULL
    );";
    if(pg_query($conexion,$sql)){
        $success = "
        <script>
            Swal.fire(
            'Completado',
            'Se ha creado la tabla de manera correcta.',
            'success'
            )
        </script>";
        pg_close($conexion);
        return $success;   
    }else{
        $error = "
        <script>
            Swal.fire(
            'Falló',
            'No se ha podido crear la tabla de manera correcta.',
            'error'
            )
        </script>";
        pg_close($conexion);
        return $error;
    }
}

function insertar_datos_psg($tabla,$valor,$contenido){
    global $fecha;
    $conexion = conect_pg();
    $sql = "INSERT INTO $tabla ($valor,created_at) VALUES ($contenido, '$fecha');";
    if(pg_query($conexion,$sql)){
        $success = "
        <script>
            Swal.fire(
            'Completado',
            'Se han insertado los datos de manera correcta.',
            'success'
            )
        </script>";
        pg_close($conexion);
        return $success;   
    }else{
        $error = "
        <script>
            Swal.fire(
            'Falló',
            'No se han insertado los datos de manera correcta.',
            'error'
            )
        </script>";
        pg_close($conexion);
        return $error;
    }
}

function consulta_psg_clasic($datos,$tabla){
    $conexion = conect_pg();
    $sql = "SELECT $datos FROM $tabla";
    $consulta = pg_query($conexion,$sql);
    return pg_fetch_object($consulta);
    pg_close($conexion);
}

function consulta_psg_where($select_db,$table_db,$data,$compare){
    $conexion = conect_pg();
    $sql = "SELECT $select_db FROM $table_db WHERE $data = $compare";
    $consulta = pg_query($conexion,$sql);
    return pg_fetch_object($consulta);
    pg_close($conexion);
}

function consulta_psg_custom($sql){
    $conexion = conect_pg();
    $sql = "$sql";
    $consulta = pg_query($conexion,$sql);
    return pg_fetch_object($consulta);
    pg_close($conexion);
}

function leer_tablas_psg_custom($sql){
    $conexion = conect_pg();
    $sql = "$sql";
    $consulta = pg_query($conexion,$sql);
    return pg_num_rows($consulta);
    pg_close($conexion);
}

function actualizar_datos_psg($tabla,$edicion,$data,$comparate){
    global $fecha;
    $conexion = conect_pg();
    $sql = "UPDATE $tabla SET $edicion, updated_at = '$fecha' WHERE $data = $comparate;";
    if(pg_query($conexion,$sql)){
        $success = "
        <script>
            Swal.fire(
            'Completado',
            'Se han actualizado los datos de manera correcta.',
            'success'
            )
        </script>";
        pg_close($conexion);
        return $success;   
    }else{
        $error = "
        <script>
            Swal.fire(
            'Falló',
            'No se han actualizado los datos de manera correcta.',
            'error'
            )
        </script>";
        pg_close($conexion);
        return $error;
    }
}

function eliminar_datos_con_where_psg($tabla,$where,$dato){
    $conexion = conect_pg();
    $sql = "DELETE FROM $tabla WHERE $where = $dato;";
    if (pg_query($conexion,$sql)) {
        $success = "
        <script>
            Swal.fire(
            'Completado',
            'Se ha eliminado todo de manera correcta.',
            'success'
            )
        </script>";
        return $success;    
        pg_close($conexion);
       }else {
        $error = "
        <script>
            Swal.fire(
            'Falló',
            'No se ha podido eliminar de manera correcta.',
            'error'
            )
        </script>";
        pg_close($conexion);
        return $error;
       }
}

function eliminar_tabla_psg($tabla){
    $conexion = conect_pg();
    $sql = "DROP TABLE $tabla;";
    if(pg_query($conexion,$sql)){
        $success = "
        <script>
            Swal.fire(
            'Completado',
            'Se ha eliminado la tabla de manera correcta.',
            'success'
            )
        </script>";
        pg_close($conexion);
        return $success;   
    }else{
        $error = "
        <script>
            Swal.fire(
            'Falló',
            'No se ha podido eliminar la tabla de manera correcta.',
            'error'
            )
        </script>";
        pg_close($conexion);
        return $error;
    }
}

?>