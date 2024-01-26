<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/style_nav.css">
    <link rel="stylesheet" href="../../css/style_menu.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../img/logo.png">
    <title>Menu</title>
</head>

<body>
    <div class="barraNavegacionSuperior">
        <a href="homeAdmin.php">
            <img src="../../img/logo.png" alt="Logo" class="logoBarra">
        </a>
        <h2 class="tituloBarra">Inventario DEM</h2>
        <div class="cerrarSesion">
            <form action="../../Controlador/cerrar_sesion.php" method="post">
                <input type="submit" value="Cerrar Sesión" class="botonCerrarSesion">
            </form>
            <h3 class="usuarioBarra">
                <?php
                session_start();

                // Verificar si existe la sesión y tiene un nombre de usuario
                if (isset($_SESSION['nombre'])) {
                    echo "Bienvenido/a, " . $_SESSION['nombre']." 👋";
                }
                ?>
            </h3>
        </div>
    </div>
    <div class="barraNavegacion">
        <nav>
            <a href="../IngresarProductos.php" class="a-nav">Registrar</a>
            <a href="../tablas.php" class="a-nav">Ver Insumos</a>
            <a href="../historialdos.php" class="a-nav">Stock (+)</a>
            <a href="../tablahistorial.php" class="a-nav">Stock (-)</a>
            <a href="registrar.php" class="a-nav">Registrar Usuario</a>
            <a href="../soporte.php" class="a-nav">Soporte</a>
            <a href="../ayuda.php" class="a-nav">Ayuda</a>
        </nav>
    </div>
    <div class="container">
    <div class="hala">
    <form action="">
        <h2>Perfil de usuario 👤</h2>
    <?php
                session_start();

                // Verificar si existe la sesión y tiene un nombre de usuario
                if (isset($_SESSION['nombre'])||($_SESSION['nombredelusuario'])||($_SESSION['rol'])) {
                    echo "Nombre:" . $_SESSION['nombre'] ."</br>"."</br>";
                    echo "Correo:" . $_SESSION['nombredelusuario'] ."</br>"."</br>";
                    echo "Rol:" . $_SESSION['roles'];
                }
                ?>
    </form>
    </div>
    <div class="ubicacion">
        <br><br><br>
        <h3>Ubicacion DEM 📌</h3>
        <a href="https://maps.app.goo.gl/VSL7gib7N1juqGMQ6"><img src="../../img/mapa.png" alt="Mapa" ></a>
    </div>
    <div class="historia" >
        <br><br>
        <h3>¿Que es el DEM? 📚</h3>
        <p>El Departamento de Educación Municipal (DEM) de Ovalle es fundamental en la gestión y mejora del sistema educativo local. Su misión incluye establecer directrices, políticas y acciones para elevar la calidad y equidad de la educación en la comuna. Administra los recursos administrativos, financieros y pedagógicos de las escuelas, colegios y liceos, así como la contratación y gestión del personal conforme a la legislación vigente.

El enfoque principal del DEM es promover una educación de calidad centrada en el desarrollo integral de los estudiantes, enfatizando la equidad, inclusión y participación de la comunidad educativa. Se fomenta la valoración de la diversidad y se crean ambientes seguros y estimulantes para el diálogo y el aprendizaje. Además, se promueven oportunidades en áreas deportivas, artísticas, culturales y medioambientales para fortalecer las habilidades socioemocionales, garantizando una educación sostenible y enriquecedora.</p>
    </div>
</div>
 
 
</body>
</html>
