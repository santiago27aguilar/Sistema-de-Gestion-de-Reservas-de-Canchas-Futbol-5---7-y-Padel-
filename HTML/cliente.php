<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Cancha</title>
    <link rel="stylesheet" href="../css/estilos_cliente.css">
</head>
<body>
 
<div class="reserva-card">

    <?php if (isset($_GET['reserva']) && $_GET['reserva'] == 'ok'): ?>
        <?php 
            $num = "5493814152422"; 
            $nom = isset($_GET['nom']) ? $_GET['nom'] : 'Cliente';
            $texto = rawurlencode("¡Hola! Soy $nom. Solicité un turno en Pampa Fútbol y quiero confirmar el pago.");
        ?>
        <div class="mensaje-exito">
            <h3>Turno Reservado con Exito!</h3>
            <p class="estado-pago">ESTADO: PAGO PENDIENTE</p>
            <div>
                <a href="https://api.whatsapp.com/send?phone=<?php echo $num; ?>&text=<?php echo $texto; ?>" target="_blank" class="btn-whatsapp">Contactar por WhatsApp</a>
            </div>
            <p>Si pagás por transferencia, Alias: <span class="alias-destacado">planeta.futbol.padel</span></p>
        </div>
    <?php endif; ?>

    <h2>RESERVA TU TURNO</h2>
    <img src="../img/icono-turno.png" alt="Icono" class="icono-usuario">

    <form action="../php/procesar_reserva.php" method="POST">
        <div class="form-main-grid">
            <div class="columna-izq">
                <div class="form-row-2">
                    <div class="form-group"><label>Nombre</label><input type="text" name="nombre" required></div>
                    <div class="form-group"><label>Documento</label><input type="text" name="dni"></div>
                </div>
                <div class="form-row-2">
                    <div class="form-group"><label>Apellido</label><input type="text" name="apellido" required></div>
                    <div class="form-group"><label>WhatsApp</label><input type="tel" name="telefono" required></div>
                </div>
                <div class="form-group"><label>Correo Electrónico</label><input type="email" name="correo" required></div>
            </div>

            <div class="columna-der">
                <div class="form-row-2">
                    <div class="form-group">
                        <label>Cancha</label>
                        <select name="idcancha" id="id_cancha" required onchange="actualizarPrecio()">
                            <option value="">Seleccionar</option>
                            <?php
                                include '../php/conexion.php';
                                $q = $conexion->query("SELECT idcancha, tipo_cancha, precio_hora FROM cancha");
                                while($r = $q->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='".$r['idcancha']."' data-precio='".$r['precio_hora']."'>".$r['tipo_cancha']."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group"><label>Fecha</label><input type="date" name="fecha_reserva" required></div>
                </div>
                <div class="form-row-2">
                    <div class="form-group">
                        <label>Duración</label>
                        <select name="duracion" id="duracion_turno" onchange="actualizarPrecio()">
                            <option value="1">1 Hora</option>
                            <option value="2">2 Horas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Hora Inicio</label>
                        <select name="hora_inicio" id="hora_reserva" required><option value="">Elegir...</option></select>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-formulario">
            <div class="gestion-container">
                <a href="../html/mis_reservas.php" class="link-gestion">VER RESERVA o CANCELAR RESERVA</a>
            </div>
            <button type="submit" class="btn-enviar">CONFIRMAR TURNO</button>
        </div>
    </form>
</div>

<script src="../js/logica_reserva.js"></script>
</body>
</html>