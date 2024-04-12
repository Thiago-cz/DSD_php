<?php
    $hostname = 'localhost';
    $database = 'upload';
    $usuario = 'root';
    $senha = "";

    $mysqli = new mysqli($hostname, $usuario, $senha, $database);

    if($mysqli->connect_error){
        echo'Erro ao conectar Erro -> '. $mysqli->connect_error;
        exit();
    }else{
        //echo'Banco de dados conectado com sucesso';
    }

    

?>