<?php
include('../Modelo/conexion.php');

$nombre = $_POST["txtusuario"];
$pass 	= $_POST["txtpassword"];
$nombre2 = $_POST["txtnombre"];
$miRut = $_POST["run"];
$rol 	= $_POST["rol"];
//Para iniciar sesión
if(isset($_POST["btnloginx"]))
{

$queryusuario = mysqli_query($konexta,"SELECT * FROM login WHERE nombre = '$nombre2' and usu = '$nombre'and rol = '$rol'");
$nr 		= mysqli_num_rows($queryusuario); 
$mostrar	= mysqli_fetch_array($queryusuario); 
	
if (($nr == 1) && (password_verify($pass,$mostrar['pass'])) )
	{ 
		session_start();
		$_SESSION['nombredelusuario']=$nombre;
		$_SESSION['nombre']=$nombre2;
        $_SESSION['roles']=$rol;
		if($rol=="USUARIO")
		{	
			header("Location: ../Vista/Usuario/HomeUsuario.php");
		}
	else if ($rol=="ADMIN")
		{
			header("Location: ../Vista/Admin/HomeAdmin.php");
		}
	 if ($rol=="GESTION")
		{
			header("Location: ../Vista/Gestion/HomeGestion.php");
		}

	}
	
else
	{
	echo "<script> alert('Usuario, contraseña o rol incorrecto.');window.location= '../index.php' </script>";
	}
}

//Para registrar
if(isset($_POST["btnregistrarx"]))
{

$queryusuario 	= mysqli_query($konexta,"SELECT * FROM login WHERE usu = '$nombre'");
$nr 			= mysqli_num_rows($queryusuario); 
$queryrut = mysqli_query($konexta,"SELECT * FROM login WHERE rut = '$miRut'");
$rn= mysqli_num_rows($queryrut); 
if ($nr == 0 && $rn==0)
{

	$pass_fuerte = password_hash($pass, PASSWORD_BCRYPT);
	
	$queryregistrar = "INSERT INTO login(usu, pass, nombre, rut, rol) values ('$nombre','$pass_fuerte','$nombre2','$miRut','$rol')";
	

if(mysqli_query($konexta,$queryregistrar))
{
	echo "<script> alert('Usuario registrado: $nombre2 RUT: $miRut');window.location= '../Vista/registrar.php' </script>";
}

}
else
{
		echo "<script> alert('Este correo está registrado o RUT registrado: $nombre RUT:$miRut');window.location= '../Vista/registrar.php' </script>";
}

} 


$nombre = $_POST["nombre"];
$cantidad = $_POST["cantidad"];
$categoria = $_POST["categoria"];
$codigo = $_POST["codigo"];

// Verificar si se ha subido un archivo
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
    // Obtener información de la imagen
    $imagen = addslashes(file_get_contents($_FILES["imagen"]["tmp_name"]));

    // Conectar a la base de datos
    $konexta = mysqli_connect("localhost", "root", "", "imagen");

    // Verificar la conexión
    if ($konexta->connect_error) {
        die("Error de conexión: " . $konexta->connect_error);
    }

    // Validar si el producto ya existe
    $queryValidarProducto = mysqli_query($konexta, "SELECT * FROM productos WHERE nombre = '$nombre'");
    $filasProducto = mysqli_num_rows($queryValidarProducto);

    if ($filasProducto > 0) {
        // El producto ya existe, mostrar mensaje de error o redireccionar a una página de error
        echo "<script>alert('El producto ya está registrado.'); window.location='/Vista/IngresarProductos.php';</script>";
    } else {
        // El producto no existe, proceder con la inserción
        $queryInsertarProducto = "INSERT INTO productos (nombre,codigo, cantidad, imagen, categoria) VALUES ('$nombre', '$codigo', '$cantidad', '$imagen', '$categoria')";
        if (mysqli_query($konexta, $queryInsertarProducto)) {
            echo "<script>alert('Producto registrado correctamente.'); window.location='/Vista/IngresarProductos.php';</script>";
        } else {
            echo "<script>alert('Error al registrar el producto.'); window.location='/Vista/IngresarProductos.php';</script>";
        }
    }
} else {
    // Si no se subió un archivo, mostrar mensaje de error
    echo "<script>alert('Error: No se ha seleccionado una imagen.'); window.location='/Vista/IngresarProductos.php';</script>";
}



?>
