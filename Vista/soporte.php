<?php
session_start();
class Soporte {
    // Propiedades
    private $id;
    private $nombre;
    private $descripcion;

    // Constructor
    public function __construct($id, $nombre, $descripcion) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }

    // Métodos
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
}

// Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];

    // Crear una instancia de la clase Soporte
    $soporte = new Soporte(null, $nombre, $descripcion);

    // Aquí podrías hacer algo con el objeto $soporte, como guardarlo en una base de datos, etc.

    // Redirigir a otra página o mostrar un mensaje de éxito
    echo "<script>alert('Se ha enviado su mensaje'); window.location='Soporte.php';</script>";
    exit();
}

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
            <a href="Vista/IngresarProductos.php" class="a-nav">Registrar</a>
            <a href="Vista/tablas.php" class="a-nav">Ver Insumos</a>
            <a href="Vista/historialdos.php" class="a-nav">Stock (+)</a>
            <a href="Vista/tablahistorial.php" class="a-nav">Stock (-)</a>
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
            <a href="Vista/tablas.php" class="a-nav">Ver Insumos</a>
            <a href="Vista/historialdos.php" class="a-nav">Stock (+)</a>
            <a href="Vista/tablahistorial.php" class="a-nav">Stock (-)</a>
            <a href="soporte.php" class="a-nav">Soporte</a>
            <a href="ayuda.php" class="a-nav">Ayuda</a>
        </nav>
    </div> 
    <?php       
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/style_nav.css">
    <link rel="stylesheet" href="/css/style_soporte.css">
    <link rel="icon" href="/img/logo.png">
    <title>Soporte</title>
</head>
<body>

    <h2>Formulario de Soporte</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <img src="../img/logo_soporte.png" alt="logo">
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        <div>
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
        </div>
        <button type="submit">Enviar</button>
    </form>

</body>
</html>
