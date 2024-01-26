<?php
// Incluir el archivo de conexión
$konexta = mysqli_connect("localhost", "root", "", "imagen");

if ($konexta->connect_errno) {
    echo "No hay conexión: (" . $konexta->connect_errno . ") " . $konexta->connect_error;
}

// Verificar la conexión
if ($konexta->connect_error) {
    die("Error de conexión: " . $konexta->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $productoId = $_POST['id'];
    $cantidadVendida = $_POST['cantidad_vendida'];
    $usuarionombre = $_POST['nombre_usuario'];
    $cliente = $_POST['cliente'];

    // Validar que la cantidad no sea cero
    if ($cantidadVendida <= 0) {
        echo "<script>alert('Debe ingresar un numero mayor a 0'); window.location='../Vista/IngresarProductos.php';</script>";
        exit();
    }

    // Consultar la cantidad actual del producto
    $consultaCantidad = "SELECT cantidad FROM productos WHERE id = $productoId";
    $resultadoConsulta = $konexta->query($consultaCantidad);

    if ($resultadoConsulta->num_rows > 0) {
        $producto = $resultadoConsulta->fetch_assoc();
        $cantidadActual = $producto['cantidad'];

        // Verificar si hay suficiente cantidad para la venta
        if ($cantidadActual >= $cantidadVendida) {
            // Restar la cantidad vendida a la cantidad actual
            $nuevaCantidad = $cantidadActual - $cantidadVendida;

            // Actualizar la cantidad en la base de datos
            $actualizarCantidadQuery = "UPDATE productos SET cantidad = $nuevaCantidad WHERE id = $productoId";
            $konexta->query($actualizarCantidadQuery);

            // Registrar la venta en el historial de ventas
            $fechaVenta = date('Y-m-d H:i:s');
            $registrarVentaQuery = "INSERT INTO historialventa (producto_id, cantidad_vendida, fecha_venta, nombre_usuario, cliente) VALUES ($productoId, $cantidadVendida, '$fechaVenta', '$usuarionombre', '$cliente')";

            if ($konexta->query($registrarVentaQuery)) {
                echo "<script>alert('Se ha descontado correctamente. Cantidad actualizada: $nuevaCantidad'); window.location='/Vista/IngresarProductos.php';</script>";
            } else {
                echo "Error al registrar la venta: " . $konexta->error;
            }

        } else {
            echo "No hay suficiente cantidad disponible para la venta.";
        }
    } else {
        echo "Producto no encontrado.";
    }

} else {
    echo "Acceso no válido.";
}
?>
