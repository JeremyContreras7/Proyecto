<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style2.css"> 
    <link rel="icon" href="/img/logo.png"> 
    <title>Descuento de Stock</title> 
</head>
<body>
    <h2>Descuento de Stock</h2>
 

    <?php
    session_start(); // Iniciar sesión para usar $_SESSION
    $konexta = mysqli_connect("localhost", "root", "", "imagen"); // Conexión a la base de datos

    // Verificar si se recibió una ID válida a través de GET
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $productoId = $_GET['id']; // Obtener la ID del producto

        // Realizar la consulta para obtener la información del producto
        $consultaProducto = "SELECT * FROM productos WHERE id = $productoId";
        $resultadoConsulta = $konexta->query($consultaProducto);

        if ($resultadoConsulta->num_rows > 0) {
            $producto = $resultadoConsulta->fetch_assoc(); // Obtener los datos del producto

            // Validación de bajo stock y formulario de descuento
            if (($producto['cantidad'] > 0 && $producto['cantidad'] < 100 && $producto['categoria'] == "RESMAS") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 10 && $producto['categoria'] == "COMPUTADORES") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 10 && $producto['categoria'] == "PANTALLAS") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 5 && $producto['categoria'] == "IMPRESORAS") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 3 && $producto['categoria'] == "ESCANER") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 20 && $producto['categoria'] == "PERIFERICOS") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 1000 && $producto['categoria'] == "CABLEADO") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 3 && $producto['categoria'] == "PROYECTORES") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 10 && $producto['categoria'] == "RED") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 100 && $producto['categoria'] == "ESCRITURA") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 50 && $producto['categoria'] == "LIBROS") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 500 && $producto['categoria'] == "SUMINISTROS") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 20 && $producto['categoria'] == "MATERIAL") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 5 && $producto['categoria'] == "ESCRITORIO") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 10 && $producto['categoria'] == "SILLAS") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 200 && $producto['categoria'] == "MUEBLES") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 100 && $producto['categoria'] == "BOLSAS") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 20 && $producto['categoria'] == "TOALLAS") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 20 && $producto['categoria'] == "LIMPIEZA") ||
            ($producto['cantidad'] > 0 && $producto['cantidad'] < 5 && $producto['categoria'] == "ESCOBA"))
            {
                echo "<script>alert('Advertencia: Hay bajo Stock.');</script>"; // Mostrar alerta
                ?>
                <!-- Formulario para procesar el descuento -->
                <form method="POST" action="../Controlador/procesar_venta.php" >
                    <input type="hidden" name="id" value="<?php echo $productoId; ?>">
                    <input type="hidden" name="nombre_usuario" value="<?php echo $_SESSION['nombre']; ?>">
                    <br><br>
                    <label for="cantidad_vendida">Cantidad a sacar:</label>
                    <input type="number" id="cantidad_vendida" name="cantidad_vendida" required>
                    <label for="cliente">Destinatario:</label>
                    <input type="text" id="cliente" name="cliente" required>
                    <br><br>
                    <button type="submit">Registrar </button>
                    <div class="back-button-container">
                    <a href="IngresarProductos.php">Volver</a> <!-- Botón para volver atrás -->
                    </div>                
                </form>
                <?php
            } elseif (($producto['cantidad'] == 0 && $producto['categoria'] == "RESMAS") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "COMPUTADORES") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "PANTALLAS") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "IMPRESORAS") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "ESCANER") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "PERIFERICOS") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "CABLEADO") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "PROYECTORES") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "RED") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "ESCRITURA") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "LIBROS") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "SUMINISTROS") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "MATERIAL") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "ESCRITORIO") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "SILLAS") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "MUEBLES") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "BOLSAS") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "TOALLAS") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "LIMPIEZA") ||
            ($producto['cantidad'] == 0 && $producto['categoria'] == "ESCOBA"))
            {
                echo "<script>alert('Advertencia: No hay Stock'); window.location='/Vista/IngresarProductos.php';</script>"; // Mostrar alerta y redireccionar
            } else {
                ?> 
                <!-- Formulario para procesar el descuento -->
                <form method="POST" action="../Controlador/procesar_venta.php" >
                    <input type="hidden" name="id" value="<?php echo $productoId; ?>">
                    <input type="hidden" name="nombre_usuario" value="<?php echo $_SESSION['nombre']; ?>">
                    <br><br>
                    <label for="cantidad_vendida">Cantidad a sacar:</label>
                    <input type="number" id="cantidad_vendida" name="cantidad_vendida" required>
                    <label for="cliente">Destinatario:</label>
                    <input type="text" id="cliente" name="cliente" required>
                    <br><br>
                    <button type="submit">Registrar</button>
                    <div class="back-button-container">
                    <a href="IngresarProductos.php">Volver</a> <!-- Botón para volver atrás -->
                    </div> 
                </form>
                <?php
            }
        } else {
            echo "Producto no encontrado.";
        }
    } else {
        echo "Acceso no válido.";
    }
    ?>


    <h2>Historial de Ventas</h2> <!-- Título para el historial de ventas -->

    <?php
    // Consultar el historial de ventas
    $consultaHistorial = "SELECT * FROM historialventa WHERE producto_id = $productoId";
    $resultadoHistorial = $konexta->query($consultaHistorial);

    if ($resultadoHistorial->num_rows > 0) {
        // Mostrar la tabla de historial de ventas si hay registros
        echo "<table border='1'>";
        echo "<thead><tr><th>ID</th><th>ID Producto</th><th>Nombre Producto</th><th>Cantidad Descontada</th><th>Remitente</th><th>Fecha</th><th>Destinatario</th></tr></thead>";
        echo "<tbody>";
        while ($venta = $resultadoHistorial->fetch_assoc()) {
            // Mostrar cada registro de venta
            echo "<tr>";
            echo "<td>" . $venta['id'] . "</td>";
            echo "<td>" . $venta['producto_id'] . "</td>";
            echo "<td>" . $producto['nombre'] . "</td>";
            echo "<td>" . $venta['cantidad_vendida'] . "</td>";
            echo "<td>" . $venta['nombre_usuario'] . "</td>";
            echo "<td>" . $venta['fecha_venta'] . "</td>";
            echo "<td>" . $venta['cliente'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "No hay historial de ventas para este producto.";
    }
    ?>
</body>
</html>
