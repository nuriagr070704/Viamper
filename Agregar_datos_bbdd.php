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
    <title>Añadir alojamiento</title>
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

$query = "select * from allotjament;";
$resultado = mysqli_query($connection, $query);
$ultimo_id_allotjament = '';
?>

<div class="centrado registro" style="margin-top: 30px;">
<h2>Insertar datos en alojamiento</h2>
<table>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="update" method="post" enctype="multipart/form-data">
  <thead>
    <td>ID</td>
    <td>Hotel</td>
    <td>Estrellas</td>
    <td>País</td>
    <td>Ciudad</td>
    <td>Pensió</td>
    <td>Check-in</td>
    <td>Check-out</td>
    <td>Nº habitaciones</td>
    <td>Nº plazas de parquing</td>
    <td>Precio noche</td>
    <td></td>
  </thead>
  <tbody>
    <?php
      $contador = 1;
      while ($result = mysqli_fetch_array($resultado)) {
      ?>
    <tr>
      <td><input type="text" name="id_<?php echo $contador; ?>" value="<?php echo $result[0] ?>" style="width: 30px;" readonly></td>
      <td><input type="text" name="hotel_<?php echo $contador; ?>" value="<?php echo $result[1] ?>" style="width: 100px;" readonly></td>
      <td><input type="number" name="calitat_<?php echo $contador; ?>" min="1" max="5" value="<?php echo $result[2] ?>" style="width: 70px;"></td>
      <td><input type="text" name="pais_<?php echo $contador; ?>" value="<?php echo $result[3] ?>" style="width: 100px;" readonly></td>
      <td><input type="text" name="ciudad_<?php echo $contador; ?>" value="<?php echo $result[4] ?>" style="width: 100px;" readonly></td>
      <td><input type="text" name="pension_<?php echo $contador; ?>" value="<?php echo $result[5] ?>" style="width: 80px;"></td>
      <td><input type="time" name="checkin_<?php echo $contador; ?>" value="<?php echo cambiar_formato_hora($result[6]) ?>" style="width: 80px;"></td>
      <td><input type="time" name="checkout_<?php echo $contador; ?>" value="<?php echo cambiar_formato_hora($result[7]) ?>" style="width: 80px;"></td>
      <td><input type="number" name="habitacion_<?php echo $contador; ?>" value="<?php echo $result[8] ?>" style="width: 120px;"></td>
      <td><input type="number" name="parking_<?php echo $contador; ?>" value="<?php echo $result[9] ?>" style="width: 160px;"></td>
      <td><input type="number" name="precio_<?php echo $contador; ?>" value="<?php echo quitarDecimales($result[10]) ?>" style="width: 100px;"></td>
      <td><input type="submit" name="update_<?php echo $contador; ?>" class="boton" value="Guardar" style="width: 100%;"/></td>
    </tr>
    <?php
    $ultimo_id_allotjament = $result[0];
    $ultimo_id_allotjament++;
    $contador++;
    }
    ?>
  </tbody>
  </form>
</table>
</div>
<div class="centrado registro" style="margin-top: 30px;">
<table>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="add " method="post" enctype="multipart/form-data">
  <tr>
    <td><input type="text" name="id" value="<?php echo $ultimo_id_allotjament; ?>" style="width: 30px;" readonly></td>
    <td><input type="text" name="hotel" style="width: 100px;"></td>
    <td><input type="number" name="calitat" min="1" max="5" style="width: 70px;"></td>
    <td><input type="text" name="pais" style="width: 100px;"></td>
    <td><input type="text" name="ciudad" style="width: 100px;"></td>
    <td><input type="text" name="pension" style="width: 80px;"></td>
    <td><input type="time" name="checkin" style="width: 80px;"></td>
    <td><input type="time" name="checkout" style="width: 80px;"></td>
    <td><input type="number" name="habitacion" style="width: 120px;"></td>
    <td><input type="number" name="parking" style="width: 160px;"></td>
    <td><input type="number" name="precio" style="width: 100px;"></td>
  </tr>
  <tr>
    <td colspan="12"><input type="submit" name="enviar" class="boton" value="Añadir" style="width: 100%;"/></td>
  </tr>
</form>
</table>
</div>
<?php 
if (isset($_POST["enviar"])) {
  $hotel = $_POST["hotel"];
  $calidad = $_POST["calitat"];
  $pais = $_POST["pais"];
  $ciudad = $_POST["ciudad"];
  $pension = $_POST["pension"];
  $checkin = $_POST["checkin"];
  $checkout = $_POST["checkout"];
  $numhab = $_POST["habitacion"];
  $numparking = $_POST["parking"];
  $precio = $_POST["precio"];
  //hacer insert de uno nuevo
  $insert = "INSERT INTO 
  `allotjament`(`ID`, `hotel`, `calitat`, `pais`, `ciutat`, `pensio`, `checkin`, `checkout`, `numhab`, `numparking`, `preu`) 
  VALUES ($ultimo_id_allotjament,'$hotel','$calidad','$pais','$ciudad','$pension','$checkin','$checkout',$numhab,$numparking,$precio)";
  try {
    if (mysqli_query($connection, $insert)) {
        echo "<script>window.location.replace('Agregar_datos_bbdd.php');</script>";
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
for ($identificador=1; $identificador<100; $identificador++) {
  if (isset($_POST["update_$identificador"])) {
    $id = $_POST["id_$identificador"];
    $hotel = $_POST["hotel_$identificador"];
    $calidad = $_POST["calitat_$identificador"];
    $pais = $_POST["pais_$identificador"];
    $ciudad = $_POST["ciudad_$identificador"];
    $pension = $_POST["pension_$identificador"];
    $checkin = $_POST["checkin_$identificador"];
    $checkout = $_POST["checkout_$identificador"];
    $numhab = $_POST["habitacion_$identificador"];
    $numparking = $_POST["parking_$identificador"];
    $precio = $_POST["precio_$identificador"];
    //hacer update de uno que ya estaba
    $update = "UPDATE `allotjament` 
    SET `calitat`='$calidad',`pensio`='$pension',`checkin`='$checkin',`checkout`='$checkout',`numhab`=$numhab,`numparking`=$numparking,`preu`=$precio 
    WHERE ID = $id;";
    try {
      if (mysqli_query($connection, $update)) {
          echo "<script>window.location.replace('Agregar_datos_bbdd.php');</script>";
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