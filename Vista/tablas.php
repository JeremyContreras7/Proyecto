<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Incluir el archivo de conexión
$konexta = mysqli_connect("localhost", "root", "", "imagen");

if ($konexta->connect_errno) {
    echo "No hay conexión: (" . $konexta->connect_errno . ") " . $konexta->connect_error;
}

// Verificar la conexión
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
$resultHistorial = $konexta->query("SELECT historialventa.id, historialventa.producto_id, productos.nombre AS nombre_producto, historialventa.cantidad_vendida, historialventa.nombre_usuario, historialventa.fecha_venta, productos.codigo FROM historialventa LEFT JOIN productos ON historialventa.producto_id = productos.id");
$num_rows_historial = $resultHistorial->num_rows;

// Consultar información de la tabla 'productos'
$resultProductos = $konexta->query("SELECT * FROM productos");
$num_rows_productos = $resultProductos->num_rows;

if (isset($_SESSION['roles'])) {
    if ($_SESSION['roles'] == 'ADMIN') {
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
               

                // Verificar si existe la sesión y tiene un nombre de usuario
                if (isset($_SESSION['nombre'])) {
                    echo "Bienvenido/a, " . $_SESSION['nombre'];
                }
                ?>
            </h3>
        </div>
    </div>
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
                

                // Verificar si existe la sesión y tiene un nombre de usuario
                if (isset($_SESSION['nombre'])) {
                    echo "Bienvenido/a, " . $_SESSION['nombre'];
                }
                ?>
            </h3>
        </div>
    </div>
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

                // Verificar si existe la sesión y tiene un nombre de usuario
                if (isset($_SESSION['nombre'])) {
                    echo "Bienvenido/a, " . $_SESSION['nombre'];
                }
                ?>
            </h3>
        </div>
    </div>
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

    <link rel="stylesheet" href="/css/style_nav.css">
    <link rel="stylesheet" href="../css/styletable.css">
    <link rel="icon" href="/img/logo.png">
    <title>Tabla de insumos</title>
    <style>
        #imagen-preview {
            max-width: 200px;
            max-height: 200px;
        }
    </style>
</head>

<body>
<h2 class="tituloTabla">Productos Registrados</h2>
    <button onclick="window.location.href='productospdf.php'">Descargar en PDF</button>
<button onclick="window.location.href='<?php echo $paginaVolver; ?>'">Volver</button>
<div class="container" id="ejemplo">

    <table border="1" class="table-style">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Codigo Del Producto</th>
                <th>Nombre Del Producto</th>
                <th>Cantidad</th>
                <th>Categoria</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            if ($num_rows_productos > 0) {
                while ($data = $resultProductos->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><img height="100px" src="data:image/jpeg;base64,<?php echo base64_encode($data['imagen']); ?>" alt="Producto"></td>
                        <td><?php echo $data['codigo']; ?></td>
                        <td><?php echo $data['nombre']; ?></td>
                        <td><?php echo $data['cantidad']; ?></td>
                        <td><?php echo $data['categoria']; ?></td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='3'>No hay productos registrados.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>
</body>
</html>
