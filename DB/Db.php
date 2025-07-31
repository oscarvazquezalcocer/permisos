<?php
     define('_HOST_NAME','localhost');         // nombre del host
     define('_DATABASE_USER_NAME','permisos');     // nombre de usuario de la base de datos
     define('_DATABASE_PASSWORD','permisos$$');          // contraseña de la base de datos
     define('_DATABASE_NAME','permisos');// nombre de la base de datos
      
     $MySQLiconn = new MySQLi(_HOST_NAME,_DATABASE_USER_NAME,_DATABASE_PASSWORD,_DATABASE_NAME);
  
     if($MySQLiconn->connect_errno)
     {
       die("ERROR := ".$MySQLiconn->connect_error);
     }

