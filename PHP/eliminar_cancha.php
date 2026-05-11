<?php
    include 'conexion.php';

    $id = $_GET['id'];

    try{
        $sql = "DELETE FROM cancha WHERE idcancha = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);

        header("Location: ../html/canchas.php?mensaje=eliminado");
        exit();
    }
    catch(PDOException $e){
        echo "Error al eliminarL " . $e->getMessage();
    }
?>