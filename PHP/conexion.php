<?php
    $servidor= "localhost";
    $usuario = "root";
    $password = "1234";
    $base_de_datos = "mydb";

    try {

        $conexion = new PDO ("mysql:host=$servidor;dbname=$base_de_datos;charset=utf8", $usuario, $password);

        $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }
    catch(PDOException $e){
        echo "Hubo un problema en la conexion: " . $e->getMessage();
    }

?>