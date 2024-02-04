<?php
// Iniciar sesión
session_start();
// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Incluir el archivo de conexión a la base de datos
$konexta = mysqli_connect("localhost", "root", "", "imagen");

// Verificar si hay error de conexión
if ($konexta->connect_errno) {
    echo "No hay conexión: (" . $konexta->connect_errno . ") " . $konexta->connect_error;
}

// Verificar la conexión y mostrar mensaje de error en caso de fallo
if ($konexta->connect_error) {
    die("Error de conexión: " . $konexta->connect_error);
}

// Definir la página de retorno según el rol del usuario
if ($_SESSION['roles'] == 'ADMIN') {
    $paginaVolver = 'Admin/HomeAdmin.php';
} elseif ($_SESSION['roles'] == 'GESTION') {
    $paginaVolver = 'Gestion/HomeGestion.php';
} else {
    // Página por defecto en caso de que el rol no sea ni ADMIN ni GESTION
    $paginaVolver = 'Usuario/HomeUsuario.php';
}

// Consultar el historial de ventas con información de las tablas 'historialventa' y 'productos'
$resultHistorial = $konexta->query("SELECT historialventa.id, historialventa.producto_id, productos.nombre AS nombre_producto, historialventa.cantidad_vendida, historialventa.nombre_usuario, historialventa.cliente, historialventa.fecha_venta, productos.codigo FROM historialventa LEFT JOIN productos ON historialventa.producto_id = productos.id");
$num_rows_historial = $resultHistorial->num_rows;

// Consultar información de la tabla 'productos'
$resultProductos = $konexta->query("SELECT * FROM productos");
$num_rows_productos = $resultProductos->num_rows;

// Verificar si el usuario está logueado y mostrar la barra de navegación correspondiente
if (isset($_SESSION['roles'])) {
    if ($_SESSION['roles'] == 'ADMIN') {
        ?>
        <!-- Barra de navegación para el rol de ADMIN -->
        <div class="barraNavegacionSuperior">
            <!-- Logo y título -->
            <a href="Admin/HomeAdmin.php">
                <img src="../../img/logo.png" alt="Logo" class="logoBarra">
            </a>
            <h2 class="tituloBarra">Inventario DEM</h2>
            <!-- Botón de cierre de sesión y mensaje de bienvenida -->
            <div class="cerrarSesion">
                <form action="../Controlador/cerrar_sesion.php" method="post">
                    <input type="submit" value="Cerrar Sesión" class="botonCerrarSesion">
                </form>
                <h3 class="usuarioBarra">
                    <?php
                    // Mostrar mensaje de bienvenida si existe la sesión y tiene un nombre de usuario
                    if (isset($_SESSION['nombre'])) {
                        echo "Bienvenido/a, " . $_SESSION['nombre'];
                    }
                    ?>
                </h3>
            </div>
        </div>
        <!-- Menú de navegación -->
        <div class="barraNavegacion">
            <nav>
                <a href="IngresarProductos.php" class="a-nav">Registrar</a>
                <a href="tablas.php" class="a-nav">Ver Insumos</a>
                <a href="historialdos.php" class="a-nav">Stock (+)</a>
                <a href="tablahistorial.php" class="a-nav">Stock (-)</a>
                <a href="Admin/registrar.php" class="a-nav">Registrar Usuario</a>
                <a href="soporte.php" class="a-nav">Soporte</a>
                <a href="ayuda.php" class="a-nav">Ayuda</a>
            </nav>
        </div>
        <?php
    } elseif ($_SESSION['roles'] == 'GESTION') {
        ?>
        <!-- Barra de navegación para el rol de GESTION -->
        <div class="barraNavegacionSuperior">
            <!-- Logo y título -->
            <a href="Gestion/HomeGestion.php">
                <img src="../../img/logo.png" alt="Logo" class="logoBarra">
            </a>
            <h2 class="tituloBarra">Inventario DEM</h2>
            <!-- Botón de cierre de sesión y mensaje de bienvenida -->
            <div class="cerrarSesion">
                <form action="../cerrar_sesion.php" method="post">
                    <input type="submit" value="Cerrar Sesión" class="botonCerrarSesion">
                </form>
                <h3 class="usuarioBarra">
                    <?php
                    // Mostrar mensaje de bienvenida si existe la sesión y tiene un nombre de usuario
                    if (isset($_SESSION['nombre'])) {
                        echo "Bienvenido/a, " . $_SESSION['nombre'];
                    }
                    ?>
                </h3>
            </div>
        </div>
        <!-- Menú de navegación -->
        <div class="barraNavegacion">
            <nav>
                <a href="IngresarProductos.php" class="a-nav">Registrar</a>
                <a href="tablas.php" class="a-nav">Ver Insumos</a>
                <a href="historialdos.php" class="a-nav">Stock (+)</a>
                <a href="tablahistorial.php" class="a-nav">Stock (-)</a>
                <a href="soporte.php" class="a-nav">Soporte</a>
                <a href="ayuda.php" class="a-nav">Ayuda</a>
            </nav>
        </div>
        <?php
    } else {
        ?>
        <!-- Barra de navegación para usuarios con otro rol -->
        <div class="barraNavegacionSuperior">
            <!-- Logo y título -->
            <a href="Usuario/HomeUsuario.php">
                <img src="../../img/logo.png" alt="Logo" class="logoBarra">
            </a>
            <h2 class="tituloBarra">Inventario DEM</h2>
            <!-- Botón de cierre de sesión y mensaje de bienvenida -->
            <div class="cerrarSesion">
                <form action="../Controlador/cerrar_sesion.php" method="post">
                    <input type="submit" value="Cerrar Sesión" class="botonCerrarSesion">
                </form>
                <h3 class="usuarioBarra">
                    <?php
                    // Mostrar mensaje de bienvenida si existe la sesión y tiene un nombre de usuario
                    if (isset($_SESSION['nombre'])) {
                        echo "Bienvenido/a, " . $_SESSION['nombre'];
                    }
                    ?>
                </h3>
            </div>
        </div>
        <!-- Menú de navegación -->
        <div class="barraNavegacion">
            <nav>
                <a href="tablas.php" class="a-nav">Ver Insumos</a>
                <a href="historialdos.php" class="a-nav">Stock (+)</a>
                <a href="tablahistorial.php" class="a-nav">Stock (-)</a>
                <a href="soporte.php" class="a-nav">Soporte</a>
                <a href="ayuda.php" class="a-nav">Ayuda</a>
            </nav>
        </div> 
        <?php       
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Enlaces a archivos CSS y favicon -->
    <link rel="stylesheet" href="../css/styletable.css">
    <link rel="stylesheet" href="/css/style_nav.css">
    <link rel="icon" href="/img/logo.png">
    <title>Historial de Descuento</title>
    <!-- Estilos adicionales -->
    <style>
        #imagen-preview {
            max-width: 200px;
            max-height: 200px;
        }
    </style>
</head>

<body>
    <!-- Título de la tabla y botones -->
    <h2 class="tituloTabla">Historial de Descuento de Stock</h2>
    <button onclick="window.location.href='descuentopdf.php'">Descargar en PDF</button>
    <button onclick="window.location.href='<?php echo $paginaVolver; ?>'">Volver</button>
    <!-- Tabla de historial de descuentos -->
    <table border="1" class="table-style">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Producto</th>
                <th>Nombre Producto</th>
                <th>Cantidad Vendida</th>
                <th>Remitente</th>
                <th>Destinatario</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mostrar los registros del historial de descuentos
            if ($num_rows_historial > 0) {
                while ($venta = $resultHistorial->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $venta['id']; ?></td>
                        <td><?php echo $venta['producto_id']; ?></td>
                        <td><?php echo $venta['nombre_producto']; ?></td>
                        <td><?php echo $venta['cantidad_vendida']; ?></td>
                        <td><?php echo $venta['nombre_usuario']; ?></td>
                        <td><?php echo $venta['cliente']; ?></td>
                        <td><?php echo $venta['fecha_venta']; ?></td>
                    </tr>
                    <?php
                }
            } else {
                // Mostrar un mensaje si no hay registros en el historial de ventas
                echo "<tr><td colspan='4'>No hay historial de ventas registrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>
   
</body>
</html>
