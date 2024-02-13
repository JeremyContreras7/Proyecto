<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

$konexta = mysqli_connect("localhost", "root", "", "imagen");

if ($konexta->connect_errno) {
    echo "No hay conexión: (" . $konexta->connect_errno . ") " . $konexta->connect_error;
}

if ($konexta->connect_error) {
    die("Error de conexión: " . $konexta->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['nombre']) || empty($_POST['descripcion'])|| empty($_POST['minimo'])) {
        echo "Por favor, llene los campos correctamente";
    } else {
        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        $minimo = $_POST["minimo"];
        $query = "INSERT INTO categoria (nombre, descripcion, minimo) VALUES ('$nombre', '$descripcion', $minimo)";
        $resultado = $konexta->query($query);

        if ($resultado) {
            echo "Se ha insertado los datos";
        } else {
            echo "No se ha insertado los datos";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_nav.css">
    <link rel="stylesheet" href="../css/styletable.css">
    <link rel="stylesheet" href="../css/style_gestionar.css">
    <title>Formulario</title>
</head>
<body>
    <h2>Ingresa los datos del producto:</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre"><br>
        
        <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion" rows="4" cols="50"></textarea><br>
        
        <label for="minimo">Mínimo:</label><br>
        <input type="number" id="minimo" name="minimo"><br><br>
        
        <input type="submit" value="Enviar">
        <a href="IngresarProductos.php">Volver</a> <!-- Botón para volver atrás -->

    </form>
</body>
</html>
