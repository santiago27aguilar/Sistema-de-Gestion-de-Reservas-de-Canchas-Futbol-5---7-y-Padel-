<?php
// 1. SIEMPRE iniciar sesión primero
session_start();

// 2. VERIFICAR si el usuario está logueado
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: ../html/login.php");
    exit();
}

// 3. VERIFICAR si es ADMIN (El Recepcionista no puede borrar)
//if ($_SESSION['usuario_rol'] !== 'admin') {
    // Si no es admin, lo mandamos de vuelta con un aviso de error
    //header("Location: ../html/inicio.php?error=sin_permisos");
    //exit();
//}

$rol_actual = isset($_SESSION['usuario_rol']) ? strtolower(trim($_SESSION['usuario_rol'])) : '';

// 3. Modificamos el IF para que acepte "admin" o "administrador"
if ($rol_actual !== 'admin' && $rol_actual !== 'administrador') {
    header("Location: ../html/inicio.php?error=sin_permisos");
    exit();
}

include 'conexion.php';

// 4. VERIFICAR que el ID llegue por la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM clientes WHERE idclientes = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);

        // Redirigir con mensaje de éxito
        header("Location: ../html/inicio.php?mensaje=eliminado");
        exit(); 
    } 
    catch (PDOException $e) {
        // En producción es mejor no mostrar el mensaje de error real ($e)
        die("Error crítico: No se pudo eliminar el registro.");
    }
} else {
    // Si no hay ID, simplemente volvemos al inicio
    header("Location: ../html/inicio.php");
    exit();
}
?>