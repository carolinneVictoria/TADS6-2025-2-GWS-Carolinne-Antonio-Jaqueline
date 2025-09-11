<?php

    session_start();

    $inatividade = 600;

    if(!isset($_SESSION['logado']) || $_SESSION['logado'] == false){
        header('location:formLogin.php&erroLogin=naoLogado');
    }
?>