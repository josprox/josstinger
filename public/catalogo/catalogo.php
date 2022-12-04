<?php
//Configuración del sistema.
require_once (__DIR__ .'/../../jossecurity.php');
(string)$dir = $_ENV['DOMINIO'].$_ENV['HOMEDIR'];
if($_ENV['HOMEDIR'] != "/"){
    $salto = "../";
}else{
    $salto = "";
}
header('Content-Type: text/xml');
//Impresión del sistema.
echo ' <rss xmlns:g="http://base.google.com/ns/1.0" version="2.0"> ';
echo '<channel>';
echo '<title>'.$_ENV['NAME_APP'].'</title>';
echo '<link>https://'.$_ENV['DOMINIO'].'</link>';
echo '<description>Este catalogo ha sido generado de manera automática por el sistema de Josstinger, creado por El Diamante Soluciones TI.</description>';
//Generador de código por catalogo.
foreach(arreglo_consulta("SELECT * FROM servicios") as $row){
    echo '<item>';
    echo '<g:id>'.$row['id'].'</g:id>';
    echo '<g:availability>in stock</g:availability>';
    echo '<g:condition>New</g:condition>';
    echo '<g:description>'.$row['descripcion_text'].'</g:description>';
    echo '<g:image_link>https://'.$dir.$salto.'resourses/img/josstinger degradado/default.png</g:image_link>';
    echo '<g:link>https://'.$dir.'hosting#'.$row['nombre'].'</g:link>';
    echo '<g:title>Paquete de hosting: '.$row['nombre'].'</g:title>';
    echo '<g:product_type>Hosting plan</g:product_type>';
    echo '<g:sale_price>USD '.$row['precio'].'</g:sale_price>';
    echo '<g:identifier_exists>no</g:identifier_exists>';
    echo '</item>';
}
echo '</channel>';
echo '</rss>';

?>