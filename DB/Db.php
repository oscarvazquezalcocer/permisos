<?php
    // Cargar variables de entorno desde .env
    if (file_exists(__DIR__ . '/../.env')) {
      $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = array_map('trim', explode('=', $line, 2));
        putenv("$name=$value");
      }
    }

    // Obtener variables de entorno
    define('_HOST_NAME', getenv('DB_HOST') ?: 'localhost');
    define('_DATABASE_USER_NAME', getenv('DB_USER') ?: 'root');
    define('_DATABASE_PASSWORD', getenv('DB_PASS') ?: '');
    define('_DATABASE_NAME', getenv('DB_NAME') ?: 'permisos');

    $MySQLiconn = new MySQLi(_HOST_NAME, _DATABASE_USER_NAME, _DATABASE_PASSWORD, _DATABASE_NAME);

    if ($MySQLiconn->connect_errno) {
      die("ERROR := " . $MySQLiconn->connect_error);
    }