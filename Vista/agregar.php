<?php
// Inicio de la sesión para manejar variables de sesión
session_start();
// Configuración para mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Conexión a la base de datos
$konexta = mysqli_connect("localhost", "root", "", "imagen");

// Variables para mensajes de éxito/error
$mensaje = '';
$mensajeClase = '';

// Verificación de la solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificación de existencia de datos necesarios en el formulario
    if (isset($_POST['id']) && isset($_POST['cantidadASumar'])) {
        // Obtención de datos del formulario
        $productoId = $_POST['id'];
        $cantidadASumar = $_POST['cantidadASumar'];

        // Actualización de la cantidad del producto en la base de datos
        $updateQuery = "UPDATE productos SET cantidad = cantidad + $cantidadASumar WHERE id = $productoId";
        $konexta->query($updateQuery);

        // Registro del cambio en el historial de stock
        $insertQuery = "INSERT INTO historial_stock (producto_id, cantidad_agregada ) VALUES ($productoId, $cantidadASumar )";
        $konexta->query($insertQuery);

        // Consulta para obtener información actualizada del producto
        $selectQuery = "SELECT * FROM productos WHERE id = $productoId";
        $result = $konexta->query($selectQuery);
        $producto = $result->fetch_assoc();

        // Mensaje de éxito
        $mensaje = "Se ha sumado la cantidad correctamente.";
        $mensajeClase = 'success';
    } else {
        // Mensaje de error en caso de datos inválidos
        $mensaje = "Error al sumar la cantidad. Por favor, proporcione datos válidos.";
        $mensajeClase = 'error';
    }
}

// Verificación de existencia de un parámetro 'id' en la URL
if (isset($_GET['id'])) {
    // Obtención del ID del producto desde la URL
    $productoId = $_GET['id'];
    // Consulta para obtener información del producto seleccionado
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
    <link rel="stylesheet" href="/css/style2.css">
    <link rel="icon" href="/img/logo.png">
    <title>Agregar Stock</title>
    <style>
        /* Estilos CSS adicionales */
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
    
    <!-- Mensaje de éxito/error -->
    <?php if(isset($mensaje) && !empty($mensaje)): ?>
        <p class="<?php echo $mensajeClase; ?>"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <!-- Verificación de existencia de información del producto -->
    <?php if(isset($producto)): ?>
        <!-- Formulario para mostrar información del producto -->
        <form>
            <h3>Información del Producto</h3>
            <p><strong>ID:</strong> <?php echo $producto['id']; ?></p>
            <p><strong>Nombre del Producto:</strong> <?php echo $producto['nombre']; ?></p>
            <p><strong>Cantidad Actual:</strong> <?php echo $producto['cantidad']; ?></p>
        </form>

        <!-- Formulario para agregar cantidad al stock -->
        <form method="POST">
            <!-- Campos ocultos con información necesaria -->
            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
            <input type="hidden" name="nombre_usuario" value="<?php echo $_SESSION['nombre']; ?>">
            <!-- Campos de solo lectura con información del producto -->
            <label for="nombre">Nombre del Producto:</label>
            <input type="text" id="nombre" value="<?php echo $producto['nombre']; ?>" readonly><br><br>

            <label for="cantidadASumar">Cantidad a Sumar:</label>
            <input type="number" id="cantidadASumar" name="cantidadASumar" required><br><br>
            <!-- Botón para enviar el formulario -->
            <button type="submit">Sumar Cantidad</button>
            <div class="back-button-container">
            <a href="IngresarProductos.php">Volver</a> <!-- Botón para volver atrás -->
            </div> 
        </form>
        
    
        
        <!-- Historial de stock agregado -->
        <h3>Historial de Stock Agregado</h3>
        <!-- Tabla para mostrar el historial -->
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
                // Consulta para obtener el historial de stock del producto
                $historialQuery = "SELECT * FROM historial_stock WHERE producto_id = $productoId";
                $historialResult = $konexta->query($historialQuery);

                // Verificación de existencia de registros en el historial
                if ($historialResult->num_rows > 0) {
                    // Iteración sobre los registros del historial
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
                    // Mensaje en caso de no haber historial para el producto
                    echo "<tr><td colspan='3'>No hay historial de stock agregado para este producto.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    <?php else: ?>
        <!-- Mensaje en caso de no haber seleccionado un producto -->
        <p>No se ha seleccionado un producto.</p>
    <?php endif; ?>
</body>
</html>
