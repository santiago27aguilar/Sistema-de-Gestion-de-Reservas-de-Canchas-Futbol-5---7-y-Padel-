<?php
    include 'conexion.php';

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $tipo = $_POST['tipo_cancha'];
        $precio = (int)$_POST['precio_hora'];

        try {
            $sql = "INSERT INTO cancha (tipo_cancha, precio_hora) VALUES (:tipo, :precio)";
            $stmt = $conexion->prepare($sql);
            $stmt -> bindParam(':tipo', $tipo);
            $stmt -> bindParam(':precio', $precio);

            if($stmt->execute()){
                header("Location: ../html/canchas.php");
            }
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>