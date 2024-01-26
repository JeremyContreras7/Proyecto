<?php
include('conexion.php');

if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];
    $selected_query = mysqli_query($conn, "SELECT * FROM productos WHERE id = $producto_id");
    $selected_data = mysqli_fetch_array($selected_query);

    // Mostrar los datos seleccionados
    echo "<h2>Datos del Producto Seleccionado</h2>";
    echo "Nombre: " . $selected_data['nombre'] . "<br>";
    echo "Cantidad: " . $selected_data['cantidad'] . "<br>";
    echo "Imagen: <br><img height='100px' src='data:image/jpeg;base64," . base64_encode($selected_data['imagen']) . "' alt='Producto'>";
}

?>
