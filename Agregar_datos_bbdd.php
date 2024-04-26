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
    </style>
    <title>Treball</title>
</head>
<body>
<?php include 'header.php';

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
      $contador = 0;
      while ($result = mysqli_fetch_array($resultado)) {
      ?>
    <tr>
      <td><input type="text" name="id" value="<?php echo $result[0] ?>" style="width: 25px;" readonly></td>
      <td><input type="text" name="hotel" value="<?php echo $result[1] ?>" style="width: 100px;"></td>
      <td><input type="number" name="calitat" min="1" max="5" value="<?php echo $result[2] ?>" style="width: 70px;"></td>
      <td><input type="text" name="pais" value="<?php echo $result[3] ?>" style="width: 100px;"></td>
      <td><input type="text" name="ciudad" value="<?php echo $result[4] ?>" style="width: 100px;"></td>
      <td><input type="text" name="pension" value="<?php echo $result[5] ?>" style="width: 80px;"></td>
      <td><input type="time" name="checkin" value="<?php echo cambiar_formato_hora($result[6]) ?>" style="width: 80px;"></td>
      <td><input type="time" name="checkout" value="<?php echo cambiar_formato_hora($result[7]) ?>" style="width: 80px;"></td>
      <td><input type="number" name="habitacion" value="<?php echo $result[8] ?>" style="width: 120px;"></td>
      <td><input type="number" name="parking" value="<?php echo $result[9] ?>" style="width: 160px;"></td>
      <td><input type="number" name="precio" value="<?php echo quitarDecimales($result[10]) ?>" style="width: 100px;"></td>
      <td><input type="submit" name="update" value="Guardar" style="width: 100%;"/></td>
    </tr>
    <?php
    $ultimo_id_allotjament = $result[0];
    $ultimo_id_allotjament++;
    }
    ?>
  </tbody>
  </form>
</table>

<table style="margin-top: 30px;">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="add " method="post" enctype="multipart/form-data">
  <tr>
    <td><input type="text" name="id" value="<?php echo $ultimo_id_allotjament; ?>" style="width: 25px;" readonly></td>
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
    <td colspan="12"><input type="submit" name="enviar" value="Añadir" style="width: 100%;"/></td>
  </tr>
</form>
</table>
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
  $result = mysqli_query($connection, $insert);
  $_POST["enviar"] = "";
}

if (isset($_POST["update"])) {
  //hacer update de uno que ya estaba
  var_dump($_POST);
}


include 'footer.php'; ?>
</body>
</html>