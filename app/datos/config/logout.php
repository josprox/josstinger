<?php

require __DIR__ . './../../../vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, './../../../.env');
    $dotenv->load();

    //eliminar cookies creadas por el sistema
    if (isset($_COOKIE['COOKIE_INDEFINED_SESSION'])) {
		setcookie("COOKIE_INDEFINED_SESSION", FALSE, time()-$_ENV['COOKIE_SESSION'], "/");
        setcookie("COOKIE_DATA_INDEFINED_SESSION[user]", $usuario, time()-$_ENV['COOKIE_SESSION'], "/");
		setcookie("COOKIE_DATA_INDEFINED_SESSION[pass]", $password, time()-$_ENV['COOKIE_SESSION'], "/");
    }

session_start();
session_destroy();
header('Location: ../../');

?>