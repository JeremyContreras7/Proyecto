<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Incluir el archivo de conexión
$konexta = mysqli_connect("localhost", "root", "", "imagen");

// Verificar si se proporciona un ID válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Verificar si hay registros relacionados en la tabla historialventa
    $verificarRelacionQuery = "SELECT COUNT(*) as count FROM historialventa WHERE producto_id = $id";
    $result = $konexta->query($verificarRelacionQuery);

    if ($result) {
        $count = $result->fetch_assoc()['count'];

        if ($count > 0) {
            // Hay registros relacionados en la tabla historialventa
            // Puedes elegir entre eliminar o actualizar los registros dependiendo de tus necesidades
            // Vamos a eliminar los registros relacionados en este ejemplo

            $eliminarHistorialQuery = "DELETE FROM historialventa WHERE producto_id = $id";
            $konexta->query($eliminarHistorialQuery);
        }

        // Ahora, puedes eliminar el producto
        $eliminarProductoQuery = "DELETE FROM productos WHERE id = $id";
        $resultado = $konexta->query($eliminarProductoQuery);

        if ($resultado) {
            echo "<script>alert('Producto eliminado correctamente'); window.location='IngresarProductos.php';</script>";

        } else {
            echo "Error al eliminar el producto: " . $konexta->error;
        }
    } else {
        echo "Error al verificar la relación: " . $konexta->error;
    }
} else {
    echo "ID de producto no válido";
}
?>
