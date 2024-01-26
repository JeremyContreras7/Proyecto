<?php
session_start();
if (isset($_SESSION['roles'])) {
    if ($_SESSION['roles'] == 'ADMIN') {
        $paginaVolver = 'Admin/HomeAdmin.php';
    } elseif ($_SESSION['roles'] == 'GESTION') {
        $paginaVolver = 'Gestion/HomeGestion.php';
    }
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
    <a href="Usuario/homeUsuario.php">
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style_nav.css">
    <link rel="stylesheet" href="css/style_help.css">

    <title>Ayuda</title>
</head>
<body>
    <section>
        <h2>Preguntas Frecuentes</h2><br>

        <article>
            <h3>¿Cómo ingresar un nuevo producto?</h3>
            <p>Para ingresar un nuevo producto, ve a la sección de 'Registrar' . Completa los campos requeridos, como nombre,codigo y cantidad, categoria y haz clic en el botón 'Guardar Datos'.</p>
        </article>

        <article>
            <h3>¿Cómo Agregar mas cantidad a los insumos?</h3>
            <p>Para agregar mas cantidad debe dirigirse a la seccion 'Registrar', luego seleccionar la accion de agregar sobre el insumo que tu deseas agregarle mas cantidad ,complete el formulario agregando la cantidad y presione el boton para que se actualice la cantidad</p>
        </article>

        <article>
            <h3>¿Cómo Sacar Insumos del inventario?</h3>
            <p>Para poder Saacar o descontar cantidad de insumos debe dirigirse a 'Registrar', luego seleccionar la accion de descontar sobre el insumo que usted desea descontar o scar ,complete el formulario ,con la cantidad a sacar y para quien va dirigido,y presione el boton para que se actualize la base de datos.</p>
        </article>

        <article>
            <h3>¿Cómo generar un informe de inventario?</h3>
            <p>Dirigase a 'Ver Insumos','Stock (+)',Stock(-),ahi podra ver el informe de las tablas del inventario y podra descaragarlas en archivo pdf </p>
        </article>

        <article>
            <h3>¿Cómo solicitar soporte técnico?</h3>
            <p>Si necesitas ayuda o encuentras algún problema, ve a la sección de 'Soporte' y completa el formulario de contacto. Describe detalladamente tu problema y nuestro equipo se pondrá en contacto contigo lo antes posible.</p>
        </article>
    </section>

    <footer>
        <p>&copy; 2024 Jeremy Contreras Nicolas Cisternas</p>
    </footer>

</body>
</html>
