<?php
    //iniciar a sess�o ativa
    session_start();
    /* destroi a sess�o, limpando todos os registos em cache */
    session_destroy();
    //redirecionar o user
    header("Location: index.php");
    exit;
  ?>