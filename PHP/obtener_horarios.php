<?php
include 'conexion.php';

$id_cancha = $_GET['id_cancha'];
$fecha = $_GET['fecha'];

// 1. Definimos tus horarios de alquiler (ajustalos a tu gusto)
$horarios_posibles = [
    '14:00', '15:00', '16:00','17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'
];

try {
    // 2. Buscamos en la BD qué turnos ya están ocupados para esa cancha y ese día
    // En obtener_horarios.php, modificá la línea del SQL para que sea así:
$sql = "SELECT DISTINCT DATE_FORMAT(hora_inicio, '%H:00') as hora 
        FROM reservas 
        WHERE cancha_idcancha = ? 
        AND DATE(hora_inicio) = ? 
        AND estado != 'Cancelado'"; // Opcional: para que no cuente las canceladas
    
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id_cancha, $fecha]);
    $ocupados = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // 3. Quitamos los ocupados de la lista de posibles
    $disponibles = array_diff($horarios_posibles, $ocupados);

    // 4. Devolvemos la lista al JavaScript
    echo json_encode(array_values($disponibles));

} catch (PDOException $e) {
    echo json_encode([]);
}
?>