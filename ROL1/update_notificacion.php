<?php
      //Este fragmento de codigo ACTUALIZA EL VALOR DE LA NOTIFICACION
      //A traves de un procedimiento almacenado llamado updateNotificacion
      
      include_once '../DB/Db.php';

      function CambiarValorNot($solicitudID)
      {
        global $MySQLiconn;

        // Llamada al procedimiento almacenado
        $query = "CALL updateNotificacion($solicitudID)";
        $result = $MySQLiconn->query($query);
      }

      if (isset($_GET['solicitudID'])) {
        $solicitudID = intval($_GET['solicitudID']);
        CambiarValorNot($solicitudID);
        echo 'Notificación actualizada para solicitudID: ' . $solicitudID;
      } else {
        echo 'Parámetro solicitudID no recibido';
      }
      ?>