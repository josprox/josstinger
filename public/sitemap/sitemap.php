<?php
if (!isset($_POST['syst_nand'])){
    header("Location: $regresar");
}
include (__DIR__ . DIRECTORY_SEPARATOR . "../../vendor/evert/sitemap-php/src/SitemapPHP/Sitemap.php");
use SitemapPHP\Sitemap;
$regresar = $_SERVER['HTTP_REFERER'];
require_once (__DIR__ . DIRECTORY_SEPARATOR .'../../vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. DIRECTORY_SEPARATOR . "/../../");
$dotenv->load();

$sitemap = new Sitemap($_ENV['DOMINIO']);
include (__DIR__ . DIRECTORY_SEPARATOR . "../../plugins/sitemap/rutas.php");
# Genera el sitemap
$sitemap->createSitemapIndex($_ENV['DOMINIO'], "Today");
header("Location: $regresar");
?>