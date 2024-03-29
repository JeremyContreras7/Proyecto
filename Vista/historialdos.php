<?php
// Iniciar sesión para manejar variables de sesión
session_start();

// Configuración para mostrar todos los errores
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
$resultHistorial = $konexta->query("SELECT historial_stock.id,  historial_stock.producto_id, productos.nombre AS nombre_producto, historial_stock.cantidad_agregada,  historial_stock.fecha_agregado, productos.codigo FROM historial_stock LEFT JOIN productos ON historial_stock.producto_id = productos.id");
$num_rows_historial = $resultHistorial->num_rows;

// Consultar información de la tabla 'productos'
$resultProductos = $konexta->query("SELECT * FROM productos");
$num_rows_productos = $resultProductos->num_rows;

// Verificar si hay sesión iniciada y el rol del usuario
if (isset($_SESSION['roles'])) {
    if ($_SESSION['roles'] == 'ADMIN') {
        // Mostrar barra de navegación para usuario con rol ADMIN
        ?>
        <div class="barraNavegacionSuperior">
        <a href="Admin/HomeAdmin.php">
            <img src="../../img/logo.png" alt="Logo" class="logoBarra">
        </a>
        <h2 class="tituloBarra">Inventario DEM</h2>
        <div class="cerrarSesion">
            <form action="../Controlador/cerrar_sesion.php" method="post">
                <input type="submit" value="Cerrar Sesión" class="botonCerrarSesion">
            </form>
            <h3 class="usuarioBarra">
                <?php
                // Mostrar nombre del usuario si hay sesión iniciada
                if (isset($_SESSION['nombre'])) {
                    echo "Bienvenido/a, " . $_SESSION['nombre'];
                }
                ?>
            </h3>
        </div>
    </div>
    <div class="barraNavegacion">
        <nav>
            <!-- Enlaces de navegación para usuario con rol ADMIN -->
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
        // Mostrar barra de navegación para usuario con rol GESTION
        ?>
        <div class="barraNavegacionSuperior">
        <a href="Gestion/HomeGestion.php">
            <img src="../../img/logo.png" alt="Logo" class="logoBarra">
        </a>
        <h2 class="tituloBarra">Inventario DEM</h2>
        <div class="cerrarSesion">
            <form action="../Controlador/cerrar_sesion.php" method="post">
                <input type="submit" value="Cerrar Sesión" class="botonCerrarSesion">
            </form>
            <h3 class="usuarioBarra">
                <?php
                // Mostrar nombre del usuario si hay sesión iniciada
                if (isset($_SESSION['nombre'])) {
                    echo "Bienvenido/a, " . $_SESSION['nombre'];
                }
                ?>
            </h3>
        </div>
    </div>
    <div class="barraNavegacion">
        <nav>
            <!-- Enlaces de navegación para usuario con rol GESTION -->
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
        // Mostrar barra de navegación para usuario con otro rol
        ?>
        <div class="barraNavegacionSuperior">
        <a href="Usuario/HomeUsuario.php">
            <img src="../../img/logo.png" alt="Logo" class="logoBarra">
        </a>
        <h2 class="tituloBarra">Inventario DEM</h2>
        <div class="cerrarSesion">
            <form action="../Controlador/cerrar_sesion.php" method="post">
                <input type="submit" value="Cerrar Sesión" class="botonCerrarSesion">
            </form>
            <h3 class="usuarioBarra">
                <?php
                // Mostrar nombre del usuario si hay sesión iniciada
                if (isset($_SESSION['nombre'])) {
                    echo "Bienvenido/a, " . $_SESSION['nombre'];
                }
                ?>
            </h3>
        </div>
    </div>
    <div class="barraNavegacion">
        <nav>
            <!-- Enlaces de navegación para usuario con otro rol -->
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
    <link rel="stylesheet" href="../css/styletable.css">    
    <link rel="stylesheet" href="/css/style_nav.css">
    <link rel="icon" href="/img/logo.png">
    <title>Historial </title>
    <style>
        #imagen-preview {
            max-width: 200px;
            max-height: 200px;
        }
    </style>
</head>

<body>
    <h2 class="tituloTabla" >Historial de Cantidad agregada de Stock</h2>
    <!-- Botón para descargar en PDF y para volver atrás -->
    <button onclick="window.location.href='agregarpdf.php'">Descargar en PDF</button>
    <button onclick="window.location.href='<?php echo $paginaVolver; ?>'">Volver</button>
    
    <!-- Tabla para mostrar el historial de cantidad agregada de stock -->
    <table border="1" class="table-style">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Producto</th>
                <th>Nombre del Producto</th>
                <th>Cantidad Agregada</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Verificar si hay registros en el historial
            if ($num_rows_historial > 0) {
                // Iterar sobre los registros y mostrar en la tabla
                while ($venta = $resultHistorial->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $venta['id']; ?></td>
                        <td><?php echo $venta['producto_id']; ?></td>
                        <td><?php echo $venta['nombre_producto']; ?></td>
                        <td><?php echo $venta['cantidad_agregada']; ?></td>
                        <td><?php echo $venta['fecha_agregado']; ?></td>
                    </tr>
                    <?php
                }
            } else {
                // Mostrar mensaje en caso de no haber registros en el historial
                echo "<tr><td colspan='4'>No hay historial de ventas registrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <!-- Botón para volver atrás -->
    <button onclick="window.location.href='<?php echo $paginaVolver; ?>'">Volver</button>
</body>
</html>
