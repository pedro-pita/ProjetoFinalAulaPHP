<?php
    //iniciar a sessão ativa
    session_start();
    /* destroi a sessão, limpando todos os registos em cache */
    session_destroy();
    //redirecionar o user
    header("Location: index.php");
    exit;
  ?>