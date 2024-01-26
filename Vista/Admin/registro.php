<!DOCTYPE HTML>
<html>
	<head>
		<title>Registro</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../css/stylelogin.css" />
		<script src="funciones.js"></script>
	</head>
	<body class="homepage is-preload">
		<div id="page-wrapper">
			<!-- Head -->
			<center>
            <img src="img/logo1.png" alt="Logo" style="width: 150px; height: auto;">
			</center>

			
                <center>
                <form action="registrar.php" method="post">

			    <p>Correo <input type="email" name="xapel" id="xapel" placeholder="Ingrese correo" required></p>
			    <p>Password <input type="password" name="xclv" id="xclv" placeholder="Ingrese su clave" required maxlength="8" minlength="7"></p>

			    <input type="submit" value="registrar">	
				

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