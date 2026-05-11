<?php
session_start();
if (!isset($_SESSION['id_recuperar_admin'])) {
    header("Location: ../html/login.php");
    exit();
}
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nueva_pass = $_POST['nueva_pass'];
    $id = $_SESSION['id_recuperar_admin'];

    try {
        // Actualización exacta según nombres de tu diagrama MER
        $sql = "UPDATE usuario SET password = :pass WHERE idusuario = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':pass', $nueva_pass);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Limpieza de sesión y aviso de éxito
        unset($_SESSION['id_recuperar_admin']);
        header("Location: ../html/login.php?cambio=exito");
        exit();
    } catch (Exception $e) {
        die("Error al actualizar la contraseña: " . $e->getMessage());
    }
}