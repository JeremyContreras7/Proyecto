<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

$konexta = mysqli_connect("localhost", "root", "", "imagen");

$mensaje = '';
$mensajeClase = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && isset($_POST['cantidadASumar'])) {
        $productoId = $_POST['id'];
        $cantidadASumar = $_POST['cantidadASumar'];

        $updateQuery = "UPDATE productos SET cantidad = cantidad + $cantidadASumar WHERE id = $productoId";
        $konexta->query($updateQuery);

        $insertQuery = "INSERT INTO historial_stock (producto_id, cantidad_agregada ) VALUES ($productoId, $cantidadASumar )";
        $konexta->query($insertQuery);

        $selectQuery = "SELECT * FROM productos WHERE id = $productoId";
        $result = $konexta->query($selectQuery);
        $producto = $result->fetch_assoc();

        $mensaje = "Se ha sumado la cantidad correctamente.";
        $mensajeClase = 'success';
    } else {
        $mensaje = "Error al sumar la cantidad. Por favor, proporcione datos válidos.";
        $mensajeClase = 'error';
    }
}

if (isset($_GET['id'])) {
    $productoId = $_GET['id'];
    $selectQuery = "SELECT * FROM productos WHERE id = $productoId";
    $result = $konexta->query($selectQuery);
    $producto = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styleform.css">
    <link rel="icon" href="/img/logo.png">
    <title>Agregar Stock</title>
    <style>
        .success {
            background-color: white;
            color: green;
        }

        .error {
            color: red;
        }

        #historial-table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }

        #historial-table th, #historial-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Agregar Stock</h2>
    
    <?php if(isset($mensaje) && !empty($mensaje)): ?>
        <p class="<?php echo $mensajeClase; ?>"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <?php if(isset($producto)): ?>
        <form>
            <h3>Información del Producto</h3>
            <p><strong>ID:</strong> <?php echo $producto['id']; ?></p>
            <p><strong>Nombre del Producto:</strong> <?php echo $producto['nombre']; ?></p>
            <p><strong>Cantidad Actual:</strong> <?php echo $producto['cantidad']; ?></p>
        </form>

        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
            <input type="hidden" name="nombre_usuario" value="<?php echo $_SESSION['nombre']; ?>">
            <label for="nombre">Nombre del Producto:</label>
            <input type="text" id="nombre" value="<?php echo $producto['nombre']; ?>" readonly><br><br>

            <label for="cantidadASumar">Cantidad a Sumar:</label>
            <input type="number" id="cantidadASumar" name="cantidadASumar" required><br><br>
            <button type="submit">Sumar Cantidad</button>
        </form>
        <button><a href="IngresarProductos.php">Volver</a></button>
        
        <h3>Historial de Stock Agregado</h3>
        <table id="historial-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha de Agregado</th>
                    <th>Cantidad Agregada</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $historialQuery = "SELECT * FROM historial_stock WHERE producto_id = $productoId";
                $historialResult = $konexta->query($historialQuery);

                if ($historialResult->num_rows > 0) {
                    while ($historial = $historialResult->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $historial['id']; ?></td>
                            <td><?php echo $historial['fecha_agregado']; ?></td>
                            <td><?php echo $historial['cantidad_agregada']; ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='3'>No hay historial de stock agregado para este producto.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se ha seleccionado un producto.</p>
    <?php endif; ?>
</body>
</html>
