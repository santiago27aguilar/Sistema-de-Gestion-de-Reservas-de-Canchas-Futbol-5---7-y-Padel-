<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Cuenta - Gestión de Canchas</title>
    <link rel="stylesheet" href="../css/estilos_recuperar_password.css">
</head>
<body>
    <div class="recover-container">
        <div class="recover-card">

            <div class="logo-container">
                <div class="circular-placeholder">
                    <img src="../img/contrasenia.png" alt="Futbol">
                </div>
                <div class="circular-placeholder">
                    <img src="../img/nueva-contrasenia.png" alt="Padel">
                </div>
            </div>

            <h1>RECUPERAR CONTRASENIA</h1>
            <p>Ingresa tu usuario para recuperar tu cuenta</p>

            <?php if(isset($_GET['error'])): ?>
                <div class="error-msg">
                    ⚠️ El nombre de usuario no existe.
                </div>
            <?php endif; ?>

            <form action="../php/validar_recuperacion.php" method="POST" autocomplete="off">
                <div class="form-group">
                    <label>NOMBRE DE USUARIO</label>
                    <input type="text" name="nombre" placeholder="Nombre de Usuario" required>
                </div>

                <button type="submit" class="btn-primary">CONTINUAR</button>
            </form>

            <div class="footer-link">
                <a href="login.php">VOLVER AL INICIO</a>
            </div>

        </div>
    </div>
</body>
</html>