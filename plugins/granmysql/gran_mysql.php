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
    function clasic(){
        $conexion = conect_mysqli();
        $sql = "SELECT {$this->seleccion} FROM {$this->tabla};";
        $query = $conexion -> query($sql);
        $conexion -> close();
        return $query;
    }
    function where(){
        $conexion = conect_mysqli();
        $sql = "SELECT {$this->seleccion} FROM {$this->tabla} {$this->personalizacion} WHERE '{$this->comparar}' = {$this->comparable};";
        $query = $conexion -> query($sql);
        $conexion -> close();
        return $query;
    }
    function InnerJoin(){
        $conexion = conect_mysqli();
        $sql = "SELECT {$this->seleccion} FROM {$this->tabla} INNER JOIN {$this->tabla_innerjoin} ON {$this->comparar} = {$this->comparable} {$this->personalizacion};";
        $query = $conexion -> query($sql);
        $conexion -> close();
        return $query;
    }
    function cerrar(){
        return null;
    }
}
?>