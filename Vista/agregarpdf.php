<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../fpdf186/fpdf.php');

class PDF extends FPDF
{
    // Cargar los datos desde la base de datos
    function LoadDataFromDatabase()
    {
        $konexta = mysqli_connect("localhost", "root", "", "imagen");

        if ($konexta->connect_error) {
            die("Error de conexión: " . $konexta->connect_error);
        }

        $query = "SELECT id, producto_id, cantidad_agregada, fecha_agregado FROM historial_stock";
        $result = $konexta->query($query);

        // Verificar si la consulta SQL tuvo éxito
        if ($result === false) {
            die("Error en la consulta SQL: " . $konexta->error);
        }

        $data = array();

        // Verificar si hay datos en la tabla
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = array($row['id'], $row['producto_id'], $row['cantidad_agregada'], $row['fecha_agregado']);
            }
        }

        return $data;
    }

    // Tabla coloreada
    function FancyTable($header, $data)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.5);
        $this->SetFont('Arial', 'B');

        // Cabecera
        $w = array(20, 30, 40, 80); // Anchos de las columnas
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();

        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        // Datos
        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'R', $fill);
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
$header = array('ID', 'ID Producto', 'Cant. Agregada', 'Fecha Agregado');
// Carga de datos desde la base de datos
$data = $pdf->LoadDataFromDatabase();

$pdf->SetFont('Arial', '', 14);
$pdf->AddPage();
$pdf->FancyTable($header, $data);
$pdf->Output();
?>
