<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Incluir el archivo de conexión
$konexta = mysqli_connect("localhost", "root", "", "imagen");

// Verificar si se proporciona un ID válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Verificar si se envió el formulario de edición
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $codigo = $_POST['codigo'];
        $categoria = $_POST['categoria'];
        $cantidad = $_POST['cantidad'];

        // Actualizar los datos en la base de datos
        $query = "UPDATE productos SET nombre='$nombre', codigo='$codigo', cantidad='$cantidad', categoria='$categoria' WHERE id='$id'";
        $resultado = $konexta->query($query);

        if ($resultado) {
            echo "Se ha actualizado el producto correctamente";
        } else {
            echo "Error al actualizar el producto: " . $konexta->error;
        }
    }

    // Obtener los datos actuales del producto
    $queryProducto = "SELECT * FROM productos WHERE id='$id'";
    $resultadoProducto = $konexta->query($queryProducto);

    if ($resultadoProducto) {
        $data = $resultadoProducto->fetch_assoc();
    } else {
        echo "Error al obtener los datos del producto: " . $konexta->error;
    }
} else {
    echo "ID de producto no válido";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styleform.css">
    <link rel="icon" href="/img/logo.png">
    <title>Editar Producto</title>
</head>

<body>
    <h1>Editar Producto</h1>
    <form method="POST">
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $data['nombre']; ?>" required><br><br>
        <label for="codigo">Codigo del Producto:</label>
        <input type="text" id="codigo" name="codigo" value="<?php echo $data['codigo']; ?>" required><br><br>
        <label for="cantidad">Cantidad:</label><br>
        <input type="number" id="cantidad" name="cantidad" value="<?php echo $data['cantidad']; ?>" required><br><br>
        <select name="categoria" required>
					<option disabled selected value=""><label>Seleccionar Categoria</label></option>
                    <option disabled selected value=""><label>TECNOLOGIA</label></option>
					<option value="COMPUTADORES">COMPUTADORES</option>
					<option value="IMPRESORAS">IMPRESORAS</option>
                    <option value="ESCANER">ESCANER</option>
                    <option value="PANTALLAS">PANTALLAS</option>
					<option value="PERIFERICOS">PERIFERICOS</option>
                    <option value="CABLEADO">CABLEADO</option>
					<option value="PROYECTORES">PROYECTORES</option>
                    <option value="RED">DISPOSITIVO DE RED</option>
                    <option disabled selected value=""><label>MATERIAL DE OFICINA</label></option>
					<option value="ESCRITURA">UTESILLIOS DE ESCRITURA</option>
                    <option value="LIBROS">LIBROS Y CUADERNOS</option>
					<option value="SUMINISTROS">SUMINISTROS DE OFICINA</option>
                    <option value="MATERIAL">MATERIAL DE OFICINA</option>
					<option value="RESMAS">RESMAS</option>
                    <option disabled selected value=""><label>MOBILIARIO DE OFICINA</label></option>
                    <option value="ESCRITORIO">ESCRITORIO</option>
					<option value="SILLAS">SILLAS</option>
                    <option value="MUEBLES">MUEBLES</option>
                    <option disabled selected value=""><label>LIMPIEZA</label></option>
                    <option value="BOLSAS">BOLSAS DE BASURA</option>
					<option value="TOALLAS">TOALLAS DE PAPEL Y PAÑUELOS</option>
                    <option value="LIMPIEZA">PRODUCTO DE LIMPIEZA</option>
                    <option value="ESCOBA">ESCOBA Y PALAS</option>		
		</select>

        <button type="submit">Guardar Cambios</button>
        
    </form>
    <a href="IngresarProductos.php"><button type="button">Volver</button></a>
</body>
</html>
