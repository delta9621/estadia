<?php 

    $servidor = "localhost";
    $usuario = "root";
    $password = "delta9621";
    $base_datos = "alivio";

    $conexion = new mysqli($servidor, $usuario, $password, $base_datos);

            if($conexion->connect_error){
                die("Error de conexion: " . $conexion->connect_error);
            }else{
               
            }

    $conexion->set_charset("utf8")
?>
