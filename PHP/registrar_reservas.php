<?php
    session_start();
    include 'conexion.php';

    if(!isset($_SESSION['id_usuario'])) {
        die("Error: No hay un usuario logueado.");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_cliente = $_POST["id_cliente"];
        $id_cancha = $_POST["idcancha"];
        $fecha = $_POST["fecha_reserva"]; 
        $hora_inicio = $_POST["hora_inicio"];
        $hora_fin = $_POST["hora_fin"];

        // Unimos fecha y hora para el formato de la base de datos
        $inicio_datetime = $fecha . ' ' . $hora_inicio . ':00';
        $fin_datetime = $fecha . ' ' . $hora_fin . ':00';
        $id_usuario = $_SESSION['id_usuario'];

        try {
            $sql = "INSERT INTO reservas (hora_inicio, hora_fin, estado, clientes_idclientes, cancha_idcancha, usuario_idusuario) VALUES (:ini, :fin, 'Confirmado', :cli, :can, :usu)"; 
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':ini' => $inicio_datetime, 
                ':fin' => $fin_datetime, 
                ':cli' => $id_cliente, 
                ':can' => $id_cancha, 
                ':usu' => $id_usuario
            ]);

            $conexion->prepare("UPDATE cancha SET estado = 'Ocupada' WHERE idcancha = ?")->execute([$id_cancha]);

            header("Location: ../html/reservas.php?exito=1");
            exit();
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>