<?php
include (__DIR__ . "/../../jossecurity.php");

$arr = ["name" => $_ENV['NAME_APP'] . " App", "short_name" => $_ENV['NAME_APP'], "description"=> "Aloja tu sitio web o aplicación web de manera segura, Mi Hosting Tech es el mejor proveedor de hosting de México, consulta nuestros precios.", "background_color"=> "#fff", "theme_color"=> "#99eb91", "orientation"=> "portrait", "display" => "standalone", "start_url" => "./../panel?utm_source=web_app_manifest", "scope" => "./../panel", "lang" => "es-MX", "icons" => [
    [
        "src" => "../../resourses/img/app_hestia/default_1000.png",
        "sizes" => "1000x1000",
        "type" => "image/png"],
    [
        "src" => "../../resourses/img/app_hestia/default_512.png",
        "sizes" => "512x512",
        "type" => "image/png"],
    [
        "src" => "../../resourses/img/app_hestia/default_384.png",
        "sizes" => "384x384",
        "type" => "image/png"
    ],
    [
        "src" => "../../resourses/img/app_hestia/default_256.png",
        "sizes" => "256x256",
        "type" => "image/png"
    ],
    [
        "src" => "../../resourses/img/app_hestia/default_128.png",
        "sizes" => "128x128",
        "type" => "image/png"
    ],
    [
        "src" => "../../resourses/img/app_hestia/default_64.png",
    "sizes" => "64x64",
    "type" => "image/png"
    ],
    [
        "src" => "../../resourses/img/app_hestia/default_32.png",
    "sizes" => "32x32",
    "type" => "image/png"
    ]
]];
print_r(json_encode($arr, JSON_THROW_ON_ERROR));
?>
