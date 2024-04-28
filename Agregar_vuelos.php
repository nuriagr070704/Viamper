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
    <title>Añadir vuelos</title>
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

$query = "select * from vol;";
$resultado = mysqli_query($connection, $query);
$ultimo_id_vuelo = '';
?>

<div class="centrado registro" style="margin-top: 30px;">
<h2>Insertar datos en vuelos</h2>
<table align="center">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="update" method="post" enctype="multipart/form-data">
  <thead>
    <td>ID</td>
    <td>Compañía</td>
    <td>Hora</td>
    <td>Número vuelo</td>
    <td>Puerta de embarque</td>
    <td>Aeropuerto</td>
    <td>Origen</td>
    <td>Destino</td>
    <td>Equipaje en bodega</td>
    <td></td>
  </thead>
  <tbody>
    <?php
      $contador = 1;
      while ($result = mysqli_fetch_array($resultado)) {
      ?>
    <tr>
      <td><input type="text" name="id_<?php echo $contador; ?>" value="<?php echo $result[0] ?>" style="width: 30px;" readonly></td>
      <td><input type="text" name="companyia_<?php echo $contador; ?>" value="<?php echo $result[1] ?>" style="width: 100px;" readonly></td>
      <td><input type="time" name="hora_<?php echo $contador; ?>" value="<?php echo $result[2] ?>" style="width: 70px;"></td>
      <td><input type="number" name="numero_<?php echo $contador; ?>" value="<?php echo $result[3] ?>" style="width: 110px;"></td>
      <td><input type="number" name="puerta_<?php echo $contador; ?>" value="<?php echo $result[4] ?>" style="width: 160px;"></td>
      <td><input type="text" name="aeropuerto_<?php echo $contador; ?>" value="<?php echo $result[5] ?>" style="width: 120px;" readonly></td>
      <td><input type="text" name="origen_<?php echo $contador; ?>" value="<?php echo $result[6] ?>" style="width: 110px;" readonly></td>
      <td><input type="text" name="destino_<?php echo $contador; ?>" value="<?php echo $result[7] ?>" style="width: 110px;" readonly></td>
      <td><input type="number" name="equipaje_<?php echo $contador; ?>" value="<?php echo $result[9] ?>" style="width: 150px;" readonly></td>
      <td><input type="submit" name="update_<?php echo $contador; ?>" class="boton" value="Guardar" style="width: 100%;"/></td>
    </tr>
    <?php
    $ultimo_id_vuelo = $result[0];
    $ultimo_id_vuelo++;
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
    <td><input type="text" name="id" value="<?php echo $ultimo_id_vuelo; ?>" style="width: 30px;" readonly></td>
    <td><input type="text" name="companyia" style="width: 100px;"></td>
    <td><input type="time" name="hora" style="width: 70px;"></td>
    <td><input type="number" name="numero" style="width: 110px;"></td>
    <td><input type="number" name="puerta" style="width: 160px;"></td>
    <td><input type="text" name="aeropuerto" style="width: 120px;"></td>
    <td><input type="text" name="origen" style="width: 110px;"></td>
    <td><input type="text" name="destino" style="width: 110px;"></td>
    <td><input type="number" name="equipaje" style="width: 150px;"></td>
  </tr>
  <tr>
    <td colspan="12"><input type="submit" name="enviar" class="boton" value="Añadir" style="width: 100%;"/></td>
  </tr>
</form>
</table>
</div>
<?php 
if (isset($_POST["enviar"])) {
  $companyia = $_POST["companyia"];
  $hora = $_POST["hora"];
  $numero = $_POST["numero"];
  $puerta = $_POST["puerta"];
  $aeropuerto = $_POST["aeropuerto"];
  $origen = $_POST["origen"];
  $destino = $_POST["destino"];
  $equipaje = $_POST["equipaje"];
  //hacer insert de uno nuevo
  $insert = "INSERT INTO `vol`(`IDvol`, `companyia`, `hora`, `numvol`, `porta`, `aeroport`, `origen`, `desti`, `dirrecciovol`, `equipatgebodega`) 
  VALUES ($ultimo_id_vuelo,'$companyia','$hora',$numero,$puerta,'$aeropuerto','$origen','$destino',1,$equipaje)";
  try {
    if (mysqli_query($connection, $insert)) {
        echo "<script>window.location.replace('Agregar_vuelos.php');</script>";
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
for ($identificador=1; $identificador<1000; $identificador++) {
  if (isset($_POST["update_$identificador"])) {
    $id = $_POST["id_$identificador"];
    $hora = $_POST["hora_$identificador"];
    $numero = $_POST["numero_$identificador"];
    $puerta = $_POST["puerta_$identificador"];
    //hacer update de uno que ya estaba
    $update = "UPDATE `vol` 
    SET `hora`='$hora',`numvol`=$numero,`porta`=$puerta 
    WHERE IDvol = $id;";
    try {
        if (mysqli_query($connection, $update)) {
            echo "<script>window.location.replace('Agregar_vuelos.php');</script>";
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
    $_POST["update"] = "";
  }
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