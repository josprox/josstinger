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
?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
    <channel>
        <title><?php echo $_ENV['NAME_APP']; ?></title>
        <link>https://<?php echo $_ENV['DOMINIO']; ?></link>
        <description>Este catalogo ha sido generado de manera automática por el sistema de Josstinger, creado por El Diamante Soluciones TI.</description>
        <?php
        //Generador de código por catalogo.
        foreach(arreglo_consulta("SELECT * FROM servicios") as $row){
            ?>
            <item>
                <g:id><?php echo $row['id']; ?></g:id>
                <g:availability>in stock</g:availability>
                <g:condition>New</g:condition>
                <g:description><?php echo $row['descripcion_text']; ?></g:description>
                <g:image_link>https://<?php echo $dir.$salto; ?>resourses/img/josstinger degradado/default.png</g:image_link>
                <g:link>https://<?php echo $dir; ?>hosting#<?php echo $row['nombre']; ?></g:link>
                <g:title>Paquete de hosting: <?php echo $row['nombre']; ?></g:title>
                <g:product_type>Hosting plan</g:product_type>
                <g:price>USD <?php echo $row['precio']; ?></g:price>
                <g:identifier_exists>no</g:identifier_exists>
            </item>
            <?php
        }
        ?>
    </channel>
</rss>
<?php
//Fin de la edicion.
?>