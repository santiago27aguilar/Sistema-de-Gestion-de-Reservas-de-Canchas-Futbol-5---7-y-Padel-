<?php
$reserva = null; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'conexion.php'; 
    $dni = trim($_POST['dni']);
    $correo = trim($_POST['correo']);

    try {
        $sql = "SELECT r.idreservas, r.hora_inicio, r.hora_fin, c.tipo_cancha 
                FROM reservas r
                JOIN clientes cli ON r.clientes_idclientes = cli.idclientes
                JOIN cancha c ON r.cancha_idcancha = c.idcancha
                WHERE cli.dni = :dni AND cli.correo = :correo";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $reserva = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de tu Turno</title>
    <link rel="stylesheet" href="../css/estilos_buscar_reserva.css">
</head>
<body>

<div class="reserva-card">
    <h2>DETALLE DE TU TURNO</h2>
    
    <?php if ($reserva): ?>
        <div class="contenedor-detalle">
            <div class="tarjeta-fila">
                <div class="cuadro-img">
                    <img src="../img/canchaf5f7padel.png" alt="Cancha">
                </div>
                <div class="info-texto">
                    <span class="label">CANCHA:</span>
                    <span class="dato"><?php echo htmlspecialchars($reserva['tipo_cancha']); ?></span>
                </div>
            </div>

            <div class="tarjeta-fila">
                <div class="cuadro-img">
                    <img src="../img/logo-reserva.png" alt="Fecha">
                </div>
                <div class="info-texto">
                    <span class="label">FECHA:</span>
                    <span class="dato"><?php echo date('d/m/Y', strtotime($reserva['hora_inicio'])); ?></span>
                </div>
            </div>

            <div class="tarjeta-fila">
                <div class="cuadro-img">
                    <img src="../img/reloj-hora.png" alt="Horario">
                </div>
                <div class="info-texto">
                    <span class="label">HORARIO:</span>
                    <span class="dato"><?php echo date('H:i', strtotime($reserva['hora_inicio'])) . ' a ' . date('H:i', strtotime($reserva['hora_fin'])); ?>hs</span>
                </div>
            </div>
        </div>

        <div class="footer-acciones">
            <form action="cancelar_turno.php" method="POST" class="form-cancelar" onsubmit="return confirm('¿Seguro quieres cancelar tu turno?');">
                <input type="hidden" name="id_reserva" value="<?php echo $reserva['idreservas']; ?>">
                <button type="submit" class="btn-cancelar">CANCELAR MI TURNO</button>
            </form>
            
            <a href="../html/mis_reservas.php" class="link-volver">VOLVER A BUSCAR</a>
        </div>

    <?php else: ?>
        <div class="contenedor-detalle">
            <div class="tarjeta-fila">
                <div class="cuadro-img-error">
                    <img src="../img/error.png" alt="Error">
                </div>
                <div class="info-texto-error">
                    <span class="label">ESTADO:</span>
                    <span class="dato-error">No encontramos tu RESERVA</span>
                </div>
            </div>
        </div>

        <div class="footer-acciones">
            <p class="error-msg-sub">Por favor, revisá que el DNI y el Correo Electrónico coincidan con los que ingresaste.</p>
            <a href="../html/mis_reservas.php" class="link-volver">VOLVER A BUSCAR</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html> 