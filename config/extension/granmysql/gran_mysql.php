<?php
/*
    Nombre: Gran MySQL
    Tipo: Plugin
    Función: Este plugin es el sucesor del Jossito "consulta_mysqli", aquí tratamos de mejorar la sintaxis donde no obligamos a llenar cada celda y aprovechamos lo mejor de la POO.
    Creador: Melchor Estrada José Luis (JOSPROX MX | Internacional).
    Web: https://josprox.com
*/

class GranMySQL{
    public $seleccion = "*";
    public $tabla = "users";
    public $tabla_innerjoin;
    public $comparar = "id";
    public $comparable;
    public $personalizacion = "";
    public $respuesta = "fetch_assoc";
    private $conexion;

    public function __construct(){
        $this->conexion = conect_mysqli();
    }

    function clasic(){
        try {
            $sql = "SELECT {$this->seleccion} FROM {$this->tabla} {$this->personalizacion};";
            $query = $this->conexion->query($sql);
            $ejecucion = $this -> respuesta;
            if($ejecucion != "num_rows"){
                $resultado = $query -> $ejecucion();
            }else{
                $resultado = $query -> num_rows;
            }
            return $resultado;
        } catch (mysqli_sql_exception $e) {
            // manejar excepción
            throw $e;
        }
    }

    function where(){
        try {
            $sql = "SELECT {$this->seleccion} FROM {$this->tabla} {$this->personalizacion} WHERE {$this->comparar} = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("s", $this->comparable);
            $stmt->execute();
            $result = $stmt->get_result();
            $ejecucion = $this -> respuesta;
            if($ejecucion != "num_rows"){
                $resultado = $result -> $ejecucion();
            }else{
                $resultado = $result -> num_rows;
            }
            $stmt->close();
            return $resultado;
        } catch (mysqli_sql_exception $e) {
            // manejar excepción
            throw $e;
        }
    }

    function InnerJoin(){
        try {
            $sql = "SELECT {$this->seleccion} FROM {$this->tabla} INNER JOIN {$this->tabla_innerjoin} ON {$this->tabla}.{$this->comparar} = {$this->tabla_innerjoin}.{$this->comparable} {$this->personalizacion};";
            $query = $this->conexion->query($sql);
            $ejecucion = $this -> respuesta;
            if($ejecucion != "num_rows"){
                $resultado = $query -> $ejecucion();
            }else{
                $resultado = $query -> num_rows;
            }
            return $resultado;
        } catch (mysqli_sql_exception $e) {
            // manejar excepción
            throw $e;
        }
    }
    
    function json(){
        try {
            $sql = "{$this->personalizacion}";
            $query = $this->conexion->query($sql);
            $json = [];
            while($row = mysqli_fetch_assoc($query)){
                $json[] = $row;
            }
            $json_resultado = json_encode($json, JSON_UNESCAPED_UNICODE);
            if($json_resultado){
                return $json_resultado;
            }else{
                throw new Exception("Error al convertir los datos a formato JSON");
            }
        } catch (mysqli_sql_exception $e) {
            // manejar excepción
            throw $e;
        }
    }
    function __destruct(){
        $this->seleccion = "*";
        $this->tabla = "users";
        $this->tabla_innerjoin = null;
        $this->comparar = "id";
        $this->comparable = null;
        $this->personalizacion = "";
        $this->respuesta = "fetch_assoc";
        $this->conexion->close();
    }
}
?>