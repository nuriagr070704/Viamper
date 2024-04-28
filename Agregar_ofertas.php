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
        width: 1450px;
        line-height: 200%;
        margin-left: auto;
        margin-right: auto;
      }
      .centrado input:focus{
        background-color: var(--fondos);
      }
    </style>
    <title>Añadir ofertas</title>
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

$query = "select * from ofertes;";
$resultado = mysqli_query($connection, $query);
$ultimo_id_oferta = '';
?>

<div class="centrado registro" style="margin-top: 30px;">
<h2>Insertar datos en ofertas</h2>
<table align="center">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="update" method="post" enctype="multipart/form-data">
  <thead>
    <td>ID</td>
    <td>Nombre</td>
    <td>Código</td>
    <td>Descripción</td>
    <td>Categoría</td>
    <td>Validez</td>
    <td></td>
  </thead>
  <tbody>
    <?php
      $contador = 1;
      while ($result = mysqli_fetch_array($resultado)) {
      ?>
    <tr>
      <td><input type="text" name="id_<?php echo $contador; ?>" value="<?php echo $result[0] ?>" style="width: 30px;" readonly></td>
      <td><input type="text" name="nombre_<?php echo $contador; ?>" value="<?php echo $result[1] ?>" style="width: 100px;" readonly></td>
      <td><input type="text" name="codigo_<?php echo $contador; ?>" value="<?php echo $result[2] ?>" style="width: 100px;"></td>
      <td><input type="text" name="descripcion_<?php echo $contador; ?>" value="<?php echo $result[3] ?>" style="width: 800px;"></td>
      <td><input type="text" name="categoria_<?php echo $contador; ?>" value="<?php echo $result[4] ?>" style="width: 100px;" readonly></td>
      <td><input type="datetime-local" name="validez_<?php echo $contador; ?>" value="<?php echo $result[5] ?>" style="width: 140px;" readonly></td>
      <td><input type="submit" name="update_<?php echo $contador; ?>" class="boton" value="Guardar" style="width: 100%;"/></td>
    </tr>
    <?php
    $ultimo_id_oferta = $result[0];
    $ultimo_id_oferta++;
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
    <td><input type="text" name="id" value="<?php echo $ultimo_id_oferta; ?>" style="width: 30px;" readonly></td>
    <td><input type="text" name="nombre" style="width: 100px;"></td>
    <td><input type="text" name="codigo" min="1" max="5" style="width: 100px;"></td>
    <td><input type="text" name="descripcion" style="width: 800px;"></td>
    <td><input type="text" name="categoria" style="width: 100px;"></td>
    <td><input type="datetime-local" name="validez" style="width: 140px;"></td>
  </tr>
  <tr>
    <td colspan="12"><input type="submit" name="enviar" class="boton" value="Añadir" style="width: 100%;"/></td>
  </tr>
</form>
</table>
</div>
<?php 
if (isset($_POST["enviar"])) {
  $nombre = $_POST["nombre"];
  $codigo = $_POST["codigo"];
  $descripcion = $_POST["descripcion"];
  $descripcion_formateada = str_replace("'", "''", $descripcion);//formatearlo para que se puedan incluer apostrofes
  $categoria = $_POST["categoria"];
  $validez = $_POST["validez"];
  //hacer insert de uno nuevo
  $insert = "INSERT INTO `ofertes`(`idofertes`, `nom`, `codi`, `descripcio`, `categoria`, `validesa`) 
  VALUES ($ultimo_id_oferta,'$nombre','$codigo','$descripcion_formateada','$categoria','$validez')";
  try {
    if (mysqli_query($connection, $insert)) {
        echo "<script>window.location.replace('Agregar_ofertas.php');</script>";
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
    $codigo = $_POST["codigo_$identificador"];
    $descripcion = $_POST["descripcion_$identificador"];
    $descripcion_formateada = str_replace("'", "''", $descripcion);//formatearlo para que se puedan incluer apostrofes
    //hacer update de uno que ya estaba
    $update = "UPDATE `ofertes` 
    SET `codi`='$codigo',`descripcio`='$descripcion_formateada' 
    WHERE idofertes = $id;";
    try {
        if (mysqli_query($connection, $update)) {
            echo "<script>window.location.replace('Agregar_ofertas.php');</script>";
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