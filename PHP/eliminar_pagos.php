<?php
    include 'conexion.php';
    $id = $_GET['id'];

    try{
        $sql = "DELETE FROM pagos WHERE idpagos = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);

        header("Location: ../html/pagos.php"); 
        exit();
    }
    catch (PDOException $e){
        echo "Error al eliminar: ". $e->getMessage();
    }
?>