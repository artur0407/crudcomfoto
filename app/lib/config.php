<?php
    header("Content-type: text/html; charset=utf-8");
    session_start();
    date_default_timezone_set('America/Sao_Paulo');

    /* Modo producao ou desenvolvimento: 0-dev / 1-pro */
    define('ENVIRONMENT', 0);

    if (!ENVIRONMENT) {
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        define('ABSPATH',    'http://127.0.0.1/crudcomfoto/');
        define('DB_HOST',    'localhost');
        define('DB_NAME',    'clientes');
        define('DB_USER',    'postgres');
        define('DB_PASS',    'postgre123');
    } else {
        error_reporting(0);
        ini_set("display_errors", 0);
        define('ABSPATH', 'http://www.seudominio.com');
        define('DB_HOST', '');
        define('DB_USER', '');
        define('DB_PASS', '');
        define('DB_NAME', '');
    }
?>