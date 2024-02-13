<?php
// Configuración para mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Incluir el archivo de conexión a la base de datos
$konexta = mysqli_connect("localhost", "root", "", "imagen");

// Verificar si se proporciona un ID válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Verificar si hay registros relacionados en la tabla historialventa
    $verificarRelacionQuery = "SELECT COUNT(*) as count FROM historialventa WHERE producto_id = $id";
    $result = $konexta->query($verificarRelacionQuery);

    // Verificar si la consulta fue exitosa
    if ($result) {
        $count = $result->fetch_assoc()['count'];

        // Verificar si hay registros relacionados en la tabla historialventa
        if ($count > 0) {
            // Hay registros relacionados en la tabla historialventa
            // Puedes elegir entre eliminar o actualizar los registros dependiendo de tus necesidades
            // Vamos a eliminar los registros relacionados en este ejemplo

            $eliminarHistorialVentaQuery = "DELETE FROM historialventa WHERE producto_id = $id";
            $konexta->query($eliminarHistorialVentaQuery);
        }

        // Ahora, puedes eliminar los registros relacionados en la tabla historial_stock
        $eliminarHistorialStockQuery = "DELETE FROM historial_stock WHERE producto_id = $id";
        $konexta->query($eliminarHistorialStockQuery);

        // Ahora, puedes eliminar el producto
        $eliminarProductoQuery = "DELETE FROM productos WHERE id = $id";
        $resultado = $konexta->query($eliminarProductoQuery);

        // Verificar si se eliminó el producto correctamente
        if ($resultado) {
            // Mostrar un mensaje de éxito y redirigir a la página de ingreso de productos
            echo "<script>alert('Producto eliminado correctamente.'); window.location='IngresarProductos.php';</script>";

        } else {
            // Mostrar un mensaje de error en caso de fallo al eliminar el producto
            echo "Error al eliminar el producto: " . $konexta->error;
        }
    } else {
        // Mostrar un mensaje de error en caso de fallo al verificar la relación
        echo "Error al verificar la relación: " . $konexta->error;
    }
} else {
    // Mostrar un mensaje en caso de que no se proporcione un ID válido en la URL
    echo "ID de producto no válido";
}
?>
