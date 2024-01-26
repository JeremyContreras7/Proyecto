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

        $query = "SELECT hv.id, hv.producto_id, p.nombre AS nombre_producto, hv.cantidad_vendida, hv.fecha_venta, hv.nombre_usuario, hv.cliente FROM historialventa hv
                  LEFT JOIN productos p ON hv.producto_id = p.id";
        $result = $konexta->query($query);

        // Verificar si la consulta SQL tuvo éxito
        if ($result === false) {
            die("Error en la consulta SQL: " . $konexta->error);
        }

        $data = array();

        // Verificar si hay datos en la tabla
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = array($row['id'], $row['producto_id'], $row['nombre_producto'], $row['cantidad_vendida'], $row['fecha_venta'], $row['nombre_usuario'], $row['cliente']);
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
        $this->SetLineWidth(.3);
        $this->SetFont('Arial', 'B'); // Cambiar a 'Arial' como fuente
        // Cabecera
        $w = array(10, 25, 35, 30, 42, 25, 25);
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
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'L', $fill);
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'L', $fill);
            $this->Cell($w[4], 6, $row[4], 'LR', 0, 'R', $fill);
            $this->Cell($w[5], 6, $row[5], 'LR', 0, 'R', $fill);
            $this->Cell($w[6], 6, $row[6], 'LR', 0, 'R', $fill);

            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

$pdf = new PDF();
// Títulos de las columnas
$header = array('ID', 'ID Producto', 'Producto', 'Cant. Vendida', 'Fecha Venta', 'Remitente','Destinatario');
// Carga de datos desde la base de datos
$data = $pdf->LoadDataFromDatabase();

// Verificar si hay datos para evitar generar el PDF vacío
if (!empty($data)) {
    $pdf->AddPage();
    $pdf->FancyTable($header, $data);
    $pdf->Output();
} else {
    echo "No hay datos para mostrar.";
}
?>
