<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Canchas</title>
    <link rel="stylesheet" href="../css/estilos_login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            
            <!-- COLUMNA IZQUIERDA: IMÁGENES -->
            <div class="left-side">
                <div class="img-wrapper">
                    <img src="../img/padel.png" alt="Futbol">
                </div>
                <div class="img-wrapper">
                    <img src="../img/futbol.png" alt="Padel">
                </div>
            </div>

            <!-- COLUMNA DERECHA: FORMULARIO -->
            <div class="right-side">
                <h1>CONTROL DE ACCESO</h1>
                <p>INGRESA TUS DATOS PARA CONTINUAR</p>

                <?php if (isset($_GET['error'])): ?>
                    <div class="error-msg">Usuario o contraseña incorrectos</div>
                <?php endif; ?>
                
                <form action="../php/validar_login.php" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label>USUARIO</label>
                        <input type="text" name="user" autocomplete="off" placeholder="Nombre de usuario" required>
                    </div>
                    
                    <div class="form-group">
                        <label>CONTRASENIA</label>
                        <input type="password" name="pass" autocomplete="new-password" placeholder="••••••••" required>
                    </div>
                    
                    <button type="submit" class="btn-login">ACCEDER AL INICIO</button>
                    
                    <div class="forgot-link">
                        <a href="recuperar_password.php" class="link-forgot">¿OLVIDASTE TU CONTRASENIA?</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</body>
</html>