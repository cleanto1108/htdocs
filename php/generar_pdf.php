<?php
ob_start();

require('fpdf.php');
include 'conexion.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,'Listado de Computadoras de la Empresa',0,1,'C');
        $this->Ln(5);

        $this->SetFont('Arial','B',7);
         $this->Cell(5,10,'Id',1,0,'C');
        $this->Cell(30,10,'Tipo',1,0,'C');
        $this->Cell(20,10,'Año Fabricacion',1,0,'C');
        $this->Cell(30,10,'Ultimo Mantenimiento',1,0,'C');
        $this->Cell(50,10,'Observaciones',1,0,'C');
        $this->Cell(30,10,'Proximo Mantenimiento',1,0,'C');
        $this->Cell(30,10,'Gerencia',1,1,'C');
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',7);

$sql = "SELECT * FROM computadorasdelaempresa ORDER BY id_computadora DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $pdf->Cell(5,10,($row['id_computadora']),1);
        $pdf->Cell(30,10,utf8_decode($row['tipo_computadora']),1);
        $pdf->Cell(20,10,$row['anio_fabricacion'],1);
        $pdf->Cell(30,10,$row['ultimo_mantenimiento'],1);
        $pdf->Cell(50,10,utf8_decode($row['observaciones']),1);
        $pdf->Cell(30,10,$row['fecha_proximo_mantenimiento'],1);
        $pdf->Cell(30,10,utf8_decode($row['gerencia']),1,1);
    }
} else {
    $pdf->Cell(0,10,'No hay datos para mostrar',1,1,'C');
}

$conn->close();

$pdf->Output('D', 'computadoras_empresa.pdf');



ob_end_flush();
