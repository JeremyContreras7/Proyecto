<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/styletable.css">    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Usuarios</title>
</head>

<body>
    <h2 class="tituloTabla">Tabla de Usuarios</h2>
    <button onclick="window.location.href='registrar.php'">Volver</button>

    <table border="1" class="table-style">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rut</th>
            <th>Rol</th>
            <th>Acciones</th> <!-- Columna para las acciones -->
        </tr>
        <?php
        // Conexión a la base de datos
        $conexion = mysqli_connect("localhost", "root", "", "imagen");

        // Verificar conexión
        if ($conexion === false) {
            die("ERROR: No se pudo conectar. " . mysqli_connect_error());
        }

        // Consulta SQL para obtener los datos de la tabla login
        $sql = "SELECT id, nombre, usu, rut, rol FROM login";
        $result = mysqli_query($conexion, $sql);

        // Mostrar datos en la tabla
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td>" . $row['usu'] . "</td>";
                echo "<td>" . $row['rut'] . "</td>";
                echo "<td>" . $row['rol'] . "</td>";
                echo "<td><a href='?eliminar=" . $row['id'] . "'>Eliminar❌</a></td>"; // Enlace para eliminar
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No se encontraron registros.</td></tr>";
        }

        // Procesamiento de la eliminación
        if (isset($_GET['eliminar'])) {
            $id_eliminar = $_GET['eliminar'];
            $sql_eliminar = "DELETE FROM login WHERE id='$id_eliminar'";
            if (mysqli_query($conexion, $sql_eliminar)) {
                echo "<script>alert('Usuario eliminado exitosamente');</script>";
                echo "<script>window.location.href='tablausuario.php';</script>"; // Redireccionar para actualizar la tabla
            } else {
                echo "ERROR: No se pudo eliminar el usuario. " . mysqli_error($conexion);
            }
        }

        // Cerrar conexión
        mysqli_close($conexion);
        ?>
    </table>
</body>

</html>
