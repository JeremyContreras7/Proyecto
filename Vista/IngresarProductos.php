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
    if (empty($_POST['nombre']) || empty($_POST['cantidad'])) {
        echo "Por favor, llene los campos correctamente";
    } else {
        $nombre = $_POST['nombre'];
        $cantidad = $_POST['cantidad'];
        $categoria = $_POST['categoria'];
        $codigo = $_POST['codigo'];
        $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
        $query = "INSERT INTO productos (nombre, codigo, cantidad, imagen, categoria) VALUES ('$nombre','$codigo','$cantidad','$imagen','$categoria')";
        $resultado = $konexta->query($query);

        if ($resultado) {
            echo "Se ha insertado los datos";
        } else {
            echo "No se ha insertado los datos";
        }
    }
}

$result = $konexta->query("SELECT * FROM productos");
$num_rows = $result->num_rows;

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
        <a href="Admin/homeAdmin.php">
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
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_nav.css">
    <link rel="stylesheet" href="../css/styletable.css">
    <link rel="stylesheet" href="../css/style_gestionar.css">
    <link rel="icon" href="/img/logo.png">
    <title>Ingreso de productos</title>
    <style>
        #imagen-preview {
            max-width: 200px;
            max-height: 200px;
        }
        .bajo-stock::after {
            content: '\26A0';
            color: #d9e320;
            font-size: 30px;
            margin-left: 10px;
        }
        .cero-stock::after {
            content: '\26A0';
            color: #ff0000;
            font-size: 30px;
            margin-left: 10px;
        }
        
    </style>
</head>

<body>
<div class="divRegistrar">

<h1>Registro de productos</h1>
    <form method="POST" enctype="multipart/form-data" action="../Controlador/validar.php">
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        <label for="codigo">Codigo del Producto:</label>
        <input type="text" id="codigo" name="codigo" required><br><br>
        <label for="cantidad">Cantidad:</label><br>
        <input type="number" id="cantidad" name="cantidad" required><br><br>
        <label for="categoria">Categoria:</label><br>
        <select name="categoria" required>
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
                    <option disabled selected value=""><label>Seleccionar Categoria</label></option>

		</select>  <br><br>
        <label for="imagen">Subir Foto:</label><br>
        <input type="file" id="imagen" name="imagen" onchange="mostrarVistaPrevia()"><br><br>

        <img id="imagen-preview" src="#" alt="Vista Previa de la Foto" style="display: none;"><br><br>
        
        <button type="submit">Guardar Datos</button><br><br>
        <button onclick="window.location.href='<?php echo $paginaVolver; ?>'">Volver</button>
        

    </form>
    </div>

    <h2 class="tituloTabla">Productos Registrados</h2>
    <table border="1" class="table-style">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Codigo del Producto</th>
                <th>Nombre del Producto</th>
                <th>Cantidad</th>
                <th>Categoria</th>
                <th>Agregar</th>
                <th>Sacar</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($num_rows > 0) {
                while ($data = $result->fetch_assoc()) {
                    $stockClass = '';
                    if (
            ($data['cantidad'] > 0 && $data['cantidad'] < 100 && $data['categoria'] == "RESMAS")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 100 && $data['categoria'] == "PANTALLAS")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 10 && $data['categoria'] == "COMPUTADORES")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 5 && $data['categoria'] == "IMPRESORAS")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 3 && $data['categoria'] == "ESCANER")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 20 && $data['categoria'] == "PERIFERICOS")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 1000 && $data['categoria'] == "CABLEADO")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 3 && $data['categoria'] == "PROYECTORES")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 10 && $data['categoria'] == "RED")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 100 && $data['categoria'] == "ESCRITURA")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 50 && $data['categoria'] == "LIBROS")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 500 && $data['categoria'] == "SUMINISTROS")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 20 && $data['categoria'] == "MATERIAL")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 5 && $data['categoria'] == "ESCRITORIO")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 10 && $data['categoria'] == "SILLAS")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 200 && $data['categoria'] == "MUEBLES")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 100 && $data['categoria'] == "BOLSAS")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 20 && $data['categoria'] == "TOALLAS")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 20 && $data['categoria'] == "LIMPIEZA")||
            ($data['cantidad'] > 0 && $data['cantidad'] < 5 && $data['categoria'] == "ESCOBA")
          
                    ) {
                        $stockClass = 'bajo-stock';
                    }
            elseif (
             ($data['cantidad'] == 0 && $data['categoria'] == "RESMAS")||
             ($data['cantidad'] == 0  && $data['categoria'] == "PANTALLAS")||
             ($data['cantidad'] == 0  && $data['categoria'] == "COMPUTADORES")||
             ($data['cantidad'] == 0  && $data['categoria'] == "IMPRESORAS")||
             ($data['cantidad'] == 0  && $data['categoria'] == "ESCANER")||
             ($data['cantidad'] == 0  && $data['categoria'] == "PERIFERICOS")||
             ($data['cantidad'] == 0  && $data['categoria'] == "CABLEADO")||
             ($data['cantidad'] == 0  && $data['categoria'] == "PROYECTORES")||
             ($data['cantidad'] == 0  && $data['categoria'] == "RED")||
             ($data['cantidad'] == 0  && $data['categoria'] == "ESCRITURA")||
             ($data['cantidad'] == 0  && $data['categoria'] == "LIBROS")||
             ($data['cantidad'] == 0  && $data['categoria'] == "SUMINISTROS")||
             ($data['cantidad'] == 0  && $data['categoria'] == "MATERIAL")||
             ($data['cantidad'] == 0  && $data['categoria'] == "ESCRITORIO")||
             ($data['cantidad'] == 0  && $data['categoria'] == "SILLAS")||
             ($data['cantidad'] == 0  && $data['categoria'] == "MUEBLES")||
             ($data['cantidad'] == 0  && $data['categoria'] == "BOLSAS")||
             ($data['cantidad'] == 0  && $data['categoria'] == "TOALLAS")||
             ($data['cantidad'] == 0  && $data['categoria'] == "LIMPIEZA")||
             ($data['cantidad'] == 0  && $data['categoria'] == "ESCOBA")
                      
            ) {
                    $stockClass = 'cero-stock';
            }
                    ?>
                    <tr>
                        <td><img height="100px" src="data:image/jpeg;base64,<?php echo base64_encode($data['imagen']); ?>" alt="Producto"></td>
                        <td><?php echo $data['codigo']; ?></td>
                        <td><?php echo $data['nombre']; ?></td>
                        <td class="<?php echo $stockClass; ?>"><?php echo $data['cantidad']; ?></td>
                        <td><?php echo $data['categoria']; ?></td>
                        <td><a   class="a_tabla" href='agregar.php?id=<?php echo $data['id']; ?>'>Agregar Mas Stock &#10133;</a></td>
                        <td><a class="a_tabla" href='Descuento.php?id=<?php echo $data['id']; ?>'>Realizar Entrega ✅</a></td>
                        <td><a class="a_tabla" href='editar.php?id=<?php echo $data['id']; ?>'>Editar ✏️</a></td>
                        <td><a class="a_tabla" onclick="eliminarProducto(<?php echo $data['id']; ?>)" href='#'>Eliminar ❌</a></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
<script>
    function eliminarProducto(id) {
        if(confirm('¿Está seguro que desea eliminar este producto?')) {
            window.location = 'eliminar.php?id=' + id + '&action=confirm';
        } else {
            alert('El producto no ha sido eliminado.');
            window.location = 'IngresarProductos.php';
        }
    }
</script>
    <script>
        function mostrarVistaPrevia() {
            var input = document.getElementById('imagen');
            var vistaPrevia = document.getElementById('imagen-preview');
            if (input.files && input.files[0]) {
                var lector = new FileReader();
                lector.onload = function (e) {
                    vistaPrevia.src = e.target.result;
                    vistaPrevia.style.display = 'block';
                }
                lector.readAsDataURL(input.files[0]);
            } else {
                vistaPrevia.src = '#';
                vistaPrevia.style.display = 'none';
            }
        }
    </script>
</body>
</html>