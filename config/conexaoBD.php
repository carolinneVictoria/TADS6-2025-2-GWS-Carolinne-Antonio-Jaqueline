<?php

    $servidorBD = "localhost";
    $usuarioBD  = "root";
    $senhaBD    = "";
    $nomeBD     = "bd_setimafilosofia";

    $conn       = mysqli_connect($servidorBD, $usuarioBD, $senhaBD, $nomeBD);

    if(!$conn){
        die ("<p>Erro ao tentar conectar à base de dados $nomeBD</p>" . mysqli_error($conn));
    }

?>