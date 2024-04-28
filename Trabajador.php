<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Núria y Óscar">
	<meta name="copyright" content="VIAMPER">
	<link rel="stylesheet" href="CSS/EstiloViamper.css">
	<title>Trabajador</title>
	<style>
		table { 
			border-spacing: 5px;
			border-collapse: separate;
		}
		td { 
			padding: 5px;
		}
		.fondo{
			background-color: #b5cda5;
			border-radius: 15px;
		}
		.fondo:hover{
			box-shadow: 10px 5px 5px grey;
		}
		.color{
			color: black;
			text-decoration: none;
		}
	</style>
</head>
<body>
	<?php
	include 'header.php';
	if (isset($_SESSION['puesto'])) {
	if ($_SESSION['puesto']=="trabajador") {
	
	$usuario = $_SESSION['usuario'];

	function cambiar_formato_hora($hora) {
		// Dividir la cadena en horas, minutos y segundos
		$partes = explode(":", $hora);
		
		// Tomar solo las horas y los minutos
		$horas = $partes[0];
		$minutos = $partes[1];
		
		// Crear la nueva cadena de hora en el formato hh:mm
		$nueva_hora = $horas . ":" . $minutos;
		
		return $nueva_hora;
	}

	$query_user = "select * from treballadors where login = '$usuario';";
	$query_result = mysqli_query($connection, $query_user);
	$usuario_id = "";
	$old_user = '';
	$old_email = '';

	while ($result_formated = mysqli_fetch_row($query_result)){
	$usuario_id = $result_formated[0];
	$old_user = $result_formated[1];
	$old_email = $result_formated[7];
	?>
	<div class="wrapper">
		<h2 style="text-align: center;">Cambiar datos</h2>
		<form class="formularios registro" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
			<table align="center">
			<tr>
				<td><label for="nombre" id="separacion1">Nombre</label></td>
				<td><label for="apellidos" id="separacion1">Apellidos</label></td>
			</tr>
			<tr>
				<td><input type="text" name="nombre" id="nombre" value="<?php echo $result_formated[4] ?>"></td>
				<td><input type="text" name="apellidos" id="apellidos" value="<?php echo $result_formated[5] ?>"></td>
			</tr>
			<tr>
				<td><label for="movil" id="separacion1">Teléfono móvil</label></td>
				<td><label for="correo" id="separacion1">Correo</label></td>
			</tr>
			<tr>
				<td><input type="text" name="movil" id="movil" value="<?php echo $result_formated[6] ?>"></td>
				<td><input type="text" name="correo" id="correo" value="<?php echo $result_formated[7] ?>"></td>
			</tr>
			<tr>
				<td><label for="login" id="separacion1">Usuario</label></td>
				<td><label for="password" id="separacion1">Nova contrasenya</label></td>
			</tr>
			<tr>
				<td><input type="text" name="login" id="login" value="<?php echo $result_formated[1] ?>"></td>
				<td><input type="password" name="password" id="password" value="<?php echo $result_formated[2] ?>"></td>
			</tr>
			<tr>
				<td><label for="dni" id="separacion1">DNI</label></td>
				<td><label for="banca" id="separacion1">Cuenta bancaria</label></td>
			</tr>
			<tr>
				<td><input type="text" name="dni" id="dni" value="<?php echo $result_formated[3] ?>" readonly></td>
				<td><input type="text" name="banca" id="banca" value="<?php echo $result_formated[8] ?>"></td>
			</tr>
			<tr>
				<td><label for="sitio" id="separacion1">Sitio de trabajo</label></td>
				<td><label for="sueldo" id="separacion1">Sueldo</label></td>
			</tr>
			<tr>
				<td><input type="text" name="sitio" id="sitio" value="<?php echo $result_formated[9] ?>" readonly></td>
				<td><input type="text" name="sueldo" id="sueldo" value="<?php echo $result_formated[10] ?>" readonly></td>
			</tr>
			<?php
			$id_dept = $result_formated[11];
			$query_dept = "SELECT * FROM `departaments` WHERE idDepartaments = $id_dept;";
			$query_result_dept = mysqli_query($connection, $query_dept);
			while ($result_formated_dept = mysqli_fetch_row($query_result_dept)){ ?>
			<tr>
				<td colspan="2"><label for="departamento" id="separacion1">Departamento</label></td>
			</tr>
			<tr>
				<td colspan="2"><input type="text" name="departamento" id="departamento" value="<?php echo $result_formated_dept[1] ?>" readonly></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="2"><input type="submit" name="enviar" id="enviar" value="Guardar" class="boton" style="width: 100%; font-weight: bold;"></td>
			</tr>
			</table>
		</form>
	</div>
	<?php } ?>
	<h2 style="text-align: center;">Gestionar base de datos</h2>
	<div class="formularios registro">
	<table align="center" CELLPADDING=10>
        <tr>
            <td class="fondo"><a href="Agregar_datos_bbdd.php" class="color">Alojamientos</a></td>
            <td class="fondo"><a href="Agregar_seguros.php" class="color">Seguros</a></td>
            <td class="fondo"><a href="Agregar_coches.php" class="color">Vehículos</a></td>
            <td class="fondo"><a href="Agregar_ofertas.php" class="color">Ofertas</a></td>
            <td class="fondo"><a href="Agregar_vuelos.php" class="color">Vuelos</a></td>
        </tr>
    </table>
	</div>
	<?php
	if (isset($_POST['enviar']))
	{
		$login = $_POST['login'];
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$dni = $_POST['dni'];
		$name = $_POST['nombre'];
		$surname = $_POST['apellidos'];
		$phone = $_POST['movil'];
		$email = $_POST['correo'];
		$bank = $_POST['banca'];
		$place = $_POST['sitio'];

		//comprobar que no hay un usuario con los mismos datos
		$posible_user_array = '';
		$posible_worker_array = '';
		if ($old_user != $login || $old_email != $email) {
			$query_check = "select * from clients where login = '$login' or correu = '$email' and UID = $usuario_id;";
			$posible_user = mysqli_query($connection, $query_check);
			$posible_user_array = mysqli_fetch_row($posible_user);

			$query_check_workers = "select * from treballadors where login = '$login' or correu = '$email';";
			$posible_worker = mysqli_query($connection, $query_check_workers);
			$posible_worker_array = mysqli_fetch_row($posible_worker);
		}

		if ($posible_user_array != null || $posible_worker_array != null)
		{
			$repeated_user = true;
		}
		else
		{
			$repeated_user = false;
			$update = "UPDATE `treballadors` 
			SET `login`='$login',`claupas`='$password',`nom`='$name',`cognoms`='$surname',`telefon`=$phone,`correu`='$email',`comptebancari`='$bank' WHERE UID='$usuario_id';";
			// $update = "update treballadors
			// set login = '$login', claupas = '$password', DNINIE = '$dni', nom = '$name', cognoms = '$surname', telefon = $phone, correu = '$email', comptebancari = '$bank'
			// where UID = '$usuario_id';";
			echo $update;
			try
			{
				if (mysqli_query($connection, $update))
				{
					echo "<script>window.location.replace('Trabajador.php');</script>";
				}
			}
			catch (Exception $exception)
			{
				$error_user_creation = true;
			}
	}

		if ($repeated_user) {
			?>
			<div class="formularios registro" style="margin-top: 30px; text-align: center;">
				<p>El usuario o correo electrónico no están disponibles.</p>
				<p>Cámbielos para poder crear un usuario nuevo.</p>
			</div>
			<?php
		}
	}
	?>
	<?php } else { ?>
	<div class="wrapper formularios registro buscar" style="margin-top: 30px;">
		<h2 class="titulo">Ups. Parece que no tienes permisos para acceder a esta página.</h2>
		<div style="text-align:center;">
			<form action="index.php" method="post">
			<input type="submit" value="Volver al inicio" name="enviar" class="boton" style="font-weight: bold;">
			</form>
		</div>
	</div>
	<?php
	}
} else {
	?>
	<div class="wrapper formularios registro buscar" style="margin-top: 30px;">
		<h2 class="titulo">Ups. Parece que no tienes permisos para acceder a esta página.</h2>
		<div style="text-align:center;">
			<form action="index.php" method="post">
			<input type="submit" value="Volver al inicio" name="enviar" class="boton" style="font-weight: bold;">
			</form>
		</div>
	</div>
	<?php
}
	include 'footer.php';
	?>
</body>
</html>