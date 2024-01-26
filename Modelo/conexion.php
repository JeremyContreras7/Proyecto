<?php $konexta =mysqli_connect("localhost", "root", "", "imagen"); 

if($konexta->connect_errno)
	{
		echo "No hay conexión: (" . $konexta->connect_errno . ") " . $konexta->connect_error;
	}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "imagen";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>
