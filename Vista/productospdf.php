<?php
require('../fpdf186/fpdf.php');

class PDF extends FPDF
{
    // Cargar los datos desde la base de datos
    function LoadDataFromDatabase()
    {
        $konexta = mysqli_connect("localhost", "root", "", "imagen");

        $query = "SELECT nombre, codigo, cantidad, categoria FROM productos";
        $result = $konexta->query($query);

        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = array($row['nombre'], $row['codigo'], $row['cantidad'], $row['categoria']);
        }

        return $data;
    }

    // Tabla simple
    function BasicTable($header, $data)
    {
        // Cabecera
        foreach ($header as $col)
            $this->Cell(40, 7, $col, 1);
        $this->Ln();
        // Datos
        foreach ($data as $row) {
            foreach ($row as $col)
                $this->Cell(40, 6, $col, 1);
            $this->Ln();
        }
    }

    // Una tabla más completa
    function ImprovedTable($header, $data)
    {
        // Anchuras de las columnas
        $w = array(40, 35, 45, 40);
        // Cabeceras
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        $this->Ln();
        // Datos
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR');
            $this->Cell($w[1], 6, $row[1], 'LR');
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R');
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'R');
            $this->Ln();
        }
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    // Tabla coloreada
    function FancyTable($header, $data)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('Arial', 'B', 12); // Establecer fuente diferente
        // Cabecera
        $w = array(40, 35, 45, 40);
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 10); // Restaurar a la fuente original
        // Datos
        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

$pdf = new PDF();
// Títulos de las columnas
$header = array('Nombre', 'Codigo', 'Cantidad', 'Categoria');
// Carga de datos desde la base de datos
$data = $pdf->LoadDataFromDatabase();
$pdf->AddPage();
$pdf->FancyTable($header, $data);
$pdf->Output();
?>
