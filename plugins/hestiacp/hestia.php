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
    private $comparar = "jpx_hestia_accounts.nameserver";
    private $comparable = "";

    function consulta_db(){
        $consulta = new GranMySQL();
        $consulta -> seleccion = "jpx_hestia_accounts.id,jpx_hestia_accounts.host,jpx_hestia_accounts.port,jpx_hestia_accounts.user,jpx_hestia_accounts.password";
        $consulta -> tabla = "jpx_hestia_accounts";
        return $consulta -> clasic();
    }

    function preparar(){
        $consulta = new GranMySQL();
        $consulta -> seleccion = "jpx_hestia_accounts.id,jpx_hestia_accounts.host,jpx_hestia_accounts.port,jpx_hestia_accounts.user,jpx_hestia_accounts.password";
        $consulta -> tabla = "jpx_hestia_accounts";
        $consulta -> comparar = "jpx_hestia_accounts.nameserver";
        $consulta -> comparable = $this->comparable;
    }
}
?>