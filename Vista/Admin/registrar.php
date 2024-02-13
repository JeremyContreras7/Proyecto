<!DOCTYPE HTML>
<html>
	<head>
		<title>Registro</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../../css/style_nav.css" />
		<link rel="stylesheet" href="../../css/style_registro.css" />
		<link rel="icon" href="../../img/logo.png">
		<script type="text/javascript" src="../../Controlador/validarut.js"></script>
		<script type="text/javascript" src="../../Controlador/jv.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	</head>
	<body class="homepage is-preload">
	<div class="barraNavegacionSuperior">
        <a href="homeAdmin.php">
            <img src="../../img/logo.png" alt="Logo" class="logoBarra">
        </a>
        <h2 class="tituloBarra">Inventario DEM</h2>
        <div class="cerrarSesion">
            <form  class="cerrarSesion" action="../../Controlador/cerrar_sesion.php" method="post">
                <input type="submit" value="Cerrar Sesión" class="botonCerrarSesion">
            </form>
            <h3 class="usuarioBarra">
                <?php
                session_start();

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
            <a href="../IngresarProductos.php" class="a-nav">Registrar</a>
            <a href="../tablas.php" class="a-nav">Ver Insumos</a>
            <a href="../historialdos.php" class="a-nav">Stock (+)</a>
            <a href="../tablahistorial.php" class="a-nav">Stock (-)</a>
            <a href="registrar.php" class="a-nav">Registrar Usuario</a>
            <a href="../soporte.php" class="a-nav">Soporte</a>
            <a href="../ayuda.php" class="a-nav">Ayuda</a>
        </nav>
    </div>
		<div id="page-wrapper">
			<!-- Head -->
			<center>
				<br>
				<br>
				<img src="../../img/logo1.png" alt="Logo" style="width: 150px; height: auto;">
				
			</center>
				
                <center>
           
            <!--Formulario para registrar -->
        <form id="frmregistrar" class="grupo-entradas" method="POST" action="../../Controlador/validar.php">
			
                <input type="text" class="usuario" placeholder="&#129492 &#128105 Nombre de usuario" required name="txtnombre">
                <input type="email" class="cajaentradatexto" placeholder="&#128273 Ingrese Correo" required name="txtusuario">
                <input type="password" placeholder="&#128274 Ingresar contraseña" required name="txtpassword" id="txtpassword"><input type="checkbox" onclick="verpassword()"> Mostrar contraseña
          		<input type="text" id="run" name="run" required oninput="checkRut(this)" placeholder="&#128100 Ingrese RUT sin puntos" required maxlength="10">
				<select name="rol">
				<option value="0" style="display:none;"><label>Tipo de usuario</label></option>
				<option value="USUARIO">Usuario
				</option>
				<option value="ADMIN">Administrador</option>
				</option>
				<option value="GESTION">Gestion</option>
				</option>
				</select>
				<input type="checkbox" class="checkboxvai" required><a href="../terminos.php">He leído y acepto los términos y condiciones de uso.</a>
                <button type="submit" type="button" name="btnregistrarx">Registrar Usuario</button><br>
				<button onclick="window.location.href='tablausuario.php'">Lista de usuarios</button>

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

