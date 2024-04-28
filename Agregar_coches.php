<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="author" content="Nuria y Óscar">
    <meta name="copyright" content="VIAMPER">
    <link rel="stylesheet" href="CSS/EstiloViamper.css" >
    <style>
      .bordes{
        border-top-left-radius: 7px;
        border-top-right-radius: 7px;
        border-bottom-left-radius: 7px;
        border-bottom-right-radius: 7px;
      }
      .centrado{
        width: 1150px;
        line-height: 200%;
        margin-left: auto;
        margin-right: auto;
      }
      .centrado input:focus{
        background-color: var(--fondos);
      }
    </style>
    <title>Añadir vehículos</title>
</head>
<body>
<?php include 'header.php';
if (isset($_SESSION['puesto'])) {
if ($_SESSION['puesto']=="trabajador") {
  
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

function quitarDecimales($numero) {
  return number_format((float)$numero, 2, '.', '');
}

$query = "select * from cotxe;";
$resultado = mysqli_query($connection, $query);
$ultimo_id_coche = '';
?>

<div class="centrado registro" style="margin-top: 30px;">
<h2>Insertar datos en vehículos</h2>
<table align="center">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="update" method="post" enctype="multipart/form-data">
  <thead>
    <td>ID</td>
    <td>Categoría</td>
    <td>Marca</td>
    <td>Modelo</td>
    <td>Matrícula</td>
    <td>Asientos</td>
    <td>Puertas</td>
    <td>Tipo de marcha</td>
    <!-- <td></td> -->
  </thead>
  <tbody>
    <?php
      $contador = 1;
      while ($result = mysqli_fetch_array($resultado)) {
      ?>
    <tr>
      <td><input type="text" name="id_<?php echo $contador; ?>" value="<?php echo $result[0] ?>" style="width: 30px;" readonly></td>
      <td><input type="text" name="categoria_<?php echo $contador; ?>" value="<?php echo $result[1] ?>" style="width: 100px;" readonly></td>
      <td><input type="text" name="marca_<?php echo $contador; ?>" value="<?php echo $result[2] ?>" style="width: 100px;" readonly></td>
      <td><input type="text" name="modelo_<?php echo $contador; ?>" value="<?php echo $result[3] ?>" style="width: 100px;" readonly></td>
      <td><input type="text" name="matricula_<?php echo $contador; ?>" value="<?php echo $result[4] ?>" style="width: 100px;" readonly></td>
      <td><input type="number" name="asientos_<?php echo $contador; ?>" value="<?php echo $result[5] ?>" min="2" max="9" style="width: 80px;" readonly></td>
      <td><input type="number" name="puertas_<?php echo $contador; ?>" value="<?php echo $result[6] ?>" min="3" max="5" style="width: 80px;" readonly></td>
      <td><input type="text" name="marcha_<?php echo $contador; ?>" value="<?php echo $result[7] ?>" style="width: 120px;" readonly></td>
    </tr>
    <?php
    $ultimo_id_coche = $result[0];
    $ultimo_id_coche++;
    $contador++;
    }
    ?>
  </tbody>
  </form>
</table>
</div>
<div class="centrado registro" style="margin-top: 30px;">
<table align="center">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="add " method="post" enctype="multipart/form-data">
  <tr>
    <td><input type="text" name="id" value="<?php echo $ultimo_id_coche; ?>" style="width: 30px;" readonly></td>
		<td><select name="categoria" style="width: 100px;">
      <option value="Automático">Automático</option>
      <option value="Eléctrico">Eléctrico</option>
			<option value="Compacto">Compacto</option>
			<option value="Familiar">Familiar</option>
			<option value="Descapotables">Descapotables</option>
			<option value="Deportivos">Deportivos</option>
			<option value="Todo terrenos">Todo terrenos</option>
			<option value="7 o 9 plazas">7 o 9 plazas</option>
    </select></td>
    <td><input type="text" name="marca" style="width: 100px;"></td>
    <td><input type="text" name="modelo" style="width: 100px;"></td>
    <td><input type="text" name="matricula" style="width: 100px;"></td>
    <td><input type="number" name="asientos" min="2" max="9" style="width: 80px;"></td>
		<td><select name="puertas" style="width: 80px;">
      <option value="3">3</option>
      <option value="5">5</option>
    </select></td>
    <td><select name="marcha" style="width: 120px;">
      <option value="Automático">Automático</option>
      <option value="Manual">Manual</option>
    </select></td>
  </tr>
  <tr>
    <td colspan="12"><input type="submit" name="enviar" class="boton" value="Añadir" style="width: 100%;"/></td>
  </tr>
</form>
</table>
</div>
<?php 
if (isset($_POST["enviar"])) {
  $categoria = $_POST["categoria"];
  $marca = $_POST["marca"];
  $modelo = $_POST["modelo"];
  $matricula = $_POST["matricula"];
  $asientos = $_POST["asientos"];
  $puertas = $_POST["puertas"];
  $marcha = $_POST["marcha"];
  //hacer insert de uno nuevo
  $insert = "INSERT INTO `cotxe`(`ID`, `categoria`, `marca`, `model`, `matricula`, `seients`, `portes`, `tipusmarxa`) 
  VALUES ($ultimo_id_coche,'$categoria','$marca','$modelo','$matricula',$asientos,'$puertas','$marcha');";
  try {
    if (mysqli_query($connection, $insert)) {
        echo "<script>window.location.replace('Agregar_coches.php');</script>";
    }
  } catch (Exception $ex) { ?>
    <div class="wrapper formularios registro buscar" style="margin-top: 30px;">
      <h2 class="titulo">Ups. Parece que algo ha ido mal. Intentalo más tarde.</h2>
      <div style="text-align:center;">
          <form action="index.php" method="post">
          <input type="submit" value="Volver al inicio" name="enviar" class="boton" style="font-weight: bold;">
          </form>
      </div>
    </div>
  <?php }
  $_POST["enviar"] = "";
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
include 'footer.php'; ?>
</body>
</html>