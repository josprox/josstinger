<?php

namespace hestia;

use GranMySQL;

class hestiaconect{
    private $host = "";
    private $port = "";
    private $user_root = "";
    private $contra_root = "";
    public $returncode = "yes";
    public $comando = "";
    private $comparar = "hestia_accounts.nameserver";
    private $comparable = "";

    function consulta_db(){
        $consulta = new GranMySQL();
        $consulta -> seleccion = "hestia_accounts.id,hestia_accounts.host,hestia_accounts.port,hestia_accounts.user,hestia_accounts.password";
        $consulta -> tabla = "hestia_accounts";
        return $consulta -> clasic();
    }

    function preparar(){
        $consulta = new GranMySQL();
        $consulta -> seleccion = "hestia_accounts.id,hestia_accounts.host,hestia_accounts.port,hestia_accounts.user,hestia_accounts.password";
        $consulta -> tabla = "hestia_accounts";
        $consulta -> comparar = "hestia_accounts.nameserver";
        $consulta -> comparable = $this->comparable;
    }
}
?>