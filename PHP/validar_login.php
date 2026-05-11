<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include 'conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = trim($_POST['user']);
    $password = trim($_POST['pass']);

    try {
        
        $sql = "SELECT idusuario, nombre, password, rol FROM usuario WHERE nombre = :u";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':u', $usuario);
        $stmt->execute();

        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($datos && $password === $datos['password']) {
            
        
            session_regenerate_id(true);

            $_SESSION['id_usuario'] = $datos['idusuario'];
            $_SESSION['usuario_nombre'] = $datos['nombre'];
            $_SESSION['usuario_rol'] = $datos['rol'];

            header("Location: ../html/inicio.php");
            exit(); 
        } 
        else {
            header("Location: ../html/login.php?error=incorrecto");
            exit();
        }
    } 
    catch (PDOException $e) {
        die("ERROR TÉCNICO: " . $e->getMessage());
    }
} else {
    header("Location: ../html/login.php");
    exit();
}
?>