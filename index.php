<!DOCTYPE HTML>
<html>

<head>
	<title>Inico Sesion</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="css/stylelogin.css" />
	<script type="text/javascript" src="/Controlador/jv.js"></script>
	<link rel="icon" href="/img/logo.png">

</head>
<body class="homepage is-preload">
	<div id="page-wrapper">
		<center>
			<br>
			<br>
			<img src="img/logo1.png" alt="Logo">

		</center>
		<center>
			<!--Formulario para el inicio de sesion -->
			<form id="frmlogin" class="grupo-entradas" method="POST" action="Controlador/validar.php">
			<h1>¡Bienvenido!</h1>	
				<input type="text" class="cajaentradatexto" placeholder="&#129492; Ingrese Nombre de Usuario" name="txtnombre" required>
				<input type="email" class="cajaentradatexto" placeholder="&#128273; Ingrese Correo" name="txtusuario" required>
				<input type="password" class="cajaentradatexto" placeholder="&#128274; Ingresar contraseña" name="txtpassword" id="txtpassword" required><input type="checkbox" onclick="verpassword()"> 
				<p id="mostrarC">Mostrar contraseña.</p>
				<select name="rol" required>
					<option disabled selected value=""><label>Tipo de usuario</label></option>
					<option value="USUARIO">Usuario</option>
					<option value="ADMIN">Administrador</option>
					</option>
					<option value="GESTION">Gestion</option>
					</option>
				</select>
				<button type="submit" class="botonenviar" name="btnloginx">Iniciar sesión</button>
			</form>
		</center>
		<!-- Scripts -->
			<script src="../../assets/js/jquery.min.js"></script>
			<script src="../../assets/js/jquery.dropotron.min.js"></script>
			<script src="../../assets/js/jquery.scrolly.min.js"></script>
			<script src="../../assets/js/browser.min.js"></script>
			<script src="../../assets/js/breakpoints.min.js"></script>
			<script src="../../assets/js/util.js"></script>
			<script src="../../assets/js/main.js"></script>
</body>


</html>
