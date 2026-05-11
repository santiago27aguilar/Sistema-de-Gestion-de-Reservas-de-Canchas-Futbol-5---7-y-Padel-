<?php
error_reporting(0);
ini_set('display_errors', 0);
require('../lib/fpdf/fpdf.php');
include 'conexion.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',18);
        $this->SetTextColor(43, 27, 84); 
        $this->Cell(0,15, mb_convert_encoding('SISTEMA DE GESTIÓN DE CANCHAS', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->SetFont('Arial','B',12);
        $this->Cell(0,10, mb_convert_encoding('REPORTE DE CLIENTES REGISTRADOS', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Ln(5);
        $this->SetFillColor(43, 27, 84); 
        $this->SetTextColor(255);
        $this->SetFont('Arial','B',10);
        // Medidas unificadas (Total 190mm para A4)
        $this->Cell(40, 10, 'Nombre', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Apellido', 1, 0, 'C', true);
        $this->Cell(30, 10, 'DNI', 1, 0, 'C', true);
        $this->Cell(35, 10, mb_convert_encoding('Teléfono', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
        $this->Cell(45, 10, 'Correo', 1, 1, 'C', true);
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0);

$busqueda = isset($_GET['buscar']) ? $_GET['buscar'] : '';
$sql = "SELECT * FROM clientes WHERE dni LIKE :b OR nombre LIKE :b OR apellido LIKE :b";
$stmt = $conexion->prepare($sql);
$stmt->execute([':b' => "%$busqueda%"]);

while($f = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(40, 10, mb_convert_encoding($f['nombre'], 'ISO-8859-1', 'UTF-8'), 1);
    $pdf->Cell(40, 10, mb_convert_encoding($f['apellido'], 'ISO-8859-1', 'UTF-8'), 1);
    $pdf->Cell(30, 10, $f['dni'], 1);
    $pdf->Cell(35, 10, $f['telefono'], 1);
    $pdf->Cell(45, 10, mb_convert_encoding($f['correo'], 'ISO-8859-1', 'UTF-8'), 1);
    $pdf->Ln();
}
ob_end_clean();
$pdf->Output('I', 'Reporte_Clientes.pdf');