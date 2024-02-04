<?php
// Incluye el archivo de conexión a la base de datos
include('../Modelo/conexion.php');

// Obtiene los datos del formulario de inicio de sesión
$nombre = $_POST["txtusuario"];
$pass   = $_POST["txtpassword"];
$nombre2 = $_POST["txtnombre"];
$miRut = $_POST["run"];
$rol    = $_POST["rol"];

// Para iniciar sesión
if(isset($_POST["btnloginx"]))
{
    // Consulta a la base de datos para verificar las credenciales del usuario
    $queryusuario = mysqli_query($konexta,"SELECT * FROM login WHERE nombre = '$nombre2' and usu = '$nombre'and rol = '$rol'");
    $nr         = mysqli_num_rows($queryusuario); 
    $mostrar    = mysqli_fetch_array($queryusuario); 
    
    // Verifica si se encontró un usuario con las credenciales proporcionadas
    if (($nr == 1) && (password_verify($pass,$mostrar['pass'])) )
    { 
        // Inicia sesión y establece variables de sesión
        session_start();
        $_SESSION['nombredelusuario']=$nombre;
        $_SESSION['nombre']=$nombre2;
        $_SESSION['roles']=$rol;
        // Redirecciona según el rol del usuario
        if($rol=="USUARIO")
        {   
            header("Location: ../Vista/Usuario/HomeUsuario.php");
        }
        else if ($rol=="ADMIN")
        {
            header("Location: ../Vista/Admin/HomeAdmin.php");
        }
        else if ($rol=="GESTION")
        {
            header("Location: ../Vista/Gestion/HomeGestion.php");
        }
    }
    else
    {
        // Si las credenciales son incorrectas, muestra un mensaje de error
        echo "<script> alert('Usuario, contraseña o rol incorrecto.');window.location= '../index.php' </script>";
    }
}

// Para registrar usuarios
if(isset($_POST["btnregistrarx"]))
{
    // Consulta para verificar si el usuario ya existe
    $queryusuario   = mysqli_query($konexta,"SELECT * FROM login WHERE usu = '$nombre'");
    $nr             = mysqli_num_rows($queryusuario); 
    $queryrut       = mysqli_query($konexta,"SELECT * FROM login WHERE rut = '$miRut'");
    $rn             = mysqli_num_rows($queryrut); 

    // Verifica si el usuario y el RUT no están registrados previamente
    if ($nr == 0 && $rn == 0)
    {
        // Hashea la contraseña antes de almacenarla en la base de datos
        $pass_fuerte = password_hash($pass, PASSWORD_BCRYPT);
        
        // Inserta el nuevo usuario en la base de datos
        $queryregistrar = "INSERT INTO login(usu, pass, nombre, rut, rol) values ('$nombre','$pass_fuerte','$nombre2','$miRut','$rol')";
        
        // Ejecuta la consulta de inserción
        if(mysqli_query($konexta,$queryregistrar))
        {
            echo "<script> alert('Usuario registrado: $nombre2 RUT: $miRut');window.location= '../Vista/Admin/registrar.php' </script>";
        }
    }
    else
    {
        // Si el usuario o el RUT ya están registrados, muestra un mensaje de error
        echo "<script> alert('Este correo está registrado o RUT registrado: $nombre RUT:$miRut');window.location= '../Vista/Admin/registrar.php' </script>";
    }
} 

// Obtiene los datos del formulario para ingresar productos
$nombre = $_POST["nombre"];
$cantidad = $_POST["cantidad"];
$categoria = $_POST["categoria"];
$codigo = $_POST["codigo"];

// Verifica si se ha subido un archivo de imagen
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
    // Obtiene información de la imagen y la convierte en binario
    $imagen = addslashes(file_get_contents($_FILES["imagen"]["tmp_name"]));

    // Conecta a la base de datos
    $konexta = mysqli_connect("localhost", "root", "", "imagen");

    // Verifica la conexión
    if ($konexta->connect_error) {
        die("Error de conexión: " . $konexta->connect_error);
    }

    // Valida si el producto ya existe en la base de datos
    $queryValidarProducto = mysqli_query($konexta, "SELECT * FROM productos WHERE nombre = '$nombre'");
    $filasProducto = mysqli_num_rows($queryValidarProducto);

    if ($filasProducto > 0) {
        // Muestra un mensaje de error si el producto ya existe
        echo "<script>alert('El producto ya está registrado.'); window.location='/Vista/IngresarProductos.php';</script>";
    } else {
        // Inserta el nuevo producto en la base de datos
        $queryInsertarProducto = "INSERT INTO productos (nombre,codigo, cantidad, imagen, categoria) VALUES ('$nombre', '$codigo', '$cantidad', '$imagen', '$categoria')";
        if (mysqli_query($konexta, $queryInsertarProducto)) {
            echo "<script>alert('Producto registrado correctamente.'); window.location='/Vista/IngresarProductos.php';</script>";
        } else {
            echo "<script>alert('Error al registrar el producto.'); window.location='/Vista/IngresarProductos.php';</script>";
        }
    }
} else {
    // Muestra un mensaje de error si no se seleccionó un archivo de imagen
    echo "<script>alert('Error: No se ha seleccionado una imagen.'); window.location='/Vista/IngresarProductos.php';</script>";
}
?>
