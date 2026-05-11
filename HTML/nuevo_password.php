<?php
session_start();
if (!isset($_SESSION['id_recuperar_admin'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña - Gestión de Canchas</title>
    <link rel="stylesheet" href="../css/estilos_nuevo_password.css">
</head>
<body>
    <div class="recover-container">
        <div class="recover-card">

            <div class="logo-container">
                <div class="circular-placeholder">
                    <img src="../img/contrasenia.png" alt="Seguridad">
                </div>
                <div class="circular-placeholder">
                    <img src="../img/nueva-contrasenia.png" alt="Nueva Clave">
                </div>
            </div>

            <h1>ACTUALIZAR NUEVA CONTRASENIA</h1>
            <p>Establece tu nueva clave de acceso</p>

            <form action="../php/actualizar_password.php" method="POST" autocomplete="off">
                <div class="form-group">
                    <label>NUEVA CLAVE</label>
                    <input type="password" name="nueva_pass" placeholder="••••••••" required minlength="6">
                </div>

                <button type="submit" class="btn-primary">CAMBIAR CONTRASENIA</button>
            </form>

            <div class="footer-link">
                <a href="login.php">VOLVER AL INICIO</a>
            </div>

        </div>
    </div>
</body>
</html>