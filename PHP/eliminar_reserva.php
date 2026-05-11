<?php
    include 'conexion.php';

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        try{
            $sql = "DELETE FROM reservas WHERE idreservas = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id);

            if($stmt->execute()){
                header("Location:../html/reservas.php");
                exit();
            }
        } 
        catch(PDOException $e){
            echo "Error al eliminar: ". $e->getMessage();
        }
    }

    
?>