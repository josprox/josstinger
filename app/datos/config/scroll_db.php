<?php

class Database{

    private $charset  = 'utf8mb4';

    
    function connect(){
        require "../../../ps-conexion/base_db.php";
        try {
            $conexion = "mysql:host=" . $host . ";dbname=" . $database . ";charset=" . $this->charset;

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $pdo = new PDO($conexion, $usuario, $contra, $options);
            return $pdo;
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
?>