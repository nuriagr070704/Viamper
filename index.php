<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="author" content="Nuria y Oscar">
    <meta name="copyright" content="VIAMPER">
    <link rel="stylesheet" href="CSS/EstiloViamper.css" >
    <style>
      .bordes{
          border-top-left-radius: 7px;
          border-top-right-radius: 7px;
          border-bottom-left-radius: 7px;
          border-bottom-right-radius: 7px;
      }
      /*Para menu perfil*/ 
.menu>li>ul {
    display: none;
    /* position: absolute; */
    list-style: none;
    position: absolute;
    justify-content: center;
    padding: 0px;
    /* z-index: 1; */
    /* border-radius: 0 0 5px 5px;  */
}

.menu li:hover > ul {
    display:block;
    position: absolute; 
    padding: 0px;
}

.menu li ul li {
    display:block;  
   /* padding: 10px 15px;*/

} 
    </style>
    <title>Home</title>
</head>
<body>
<?php include 'header.php';
$accomodation_query="select * from allotjament;";
$query_result = mysqli_query($connection, $accomodation_query);
?>
    <div class="wrapper">
        <h2 class="titulo">Busca tu destino</h2>
        <div style="text-align:center;">
          <form action="escoger_alojamiento.php" class="formularios registro buscar" method="post" enctype="multipart/form-data">
            <table align="center" style="width:100%;">
              <tr>
                <td><label for="origen">De donde vienes?</label></td>
                <td><label for="destino">A dónde vas?</label></td>
                <td><label for="inicio">Cuando empiezas?</label></td>
                <td><label for="final">Cuando acabas?</label></td>
                <td><label for="personas">Personas: </label></td>
              </tr>
              <tr>
                <td><select name="origen" id="origen">
                  <?php while ($result_formated = mysqli_fetch_row($query_result)){ ?>
                      <option value="<?php echo $result_formated[4]; ?>"><?php echo $result_formated[4]; ?></option>
                  <?php } ?>
                  </select></td>
                <td><select name="destino" id="destino">
                  <?php $query_result3 = mysqli_query($connection, $accomodation_query);
                  while ($result_formated3 = mysqli_fetch_row($query_result3)){ ?>
                      <option value="<?php echo $result_formated3[4]; ?>"><?php echo $result_formated3[4]; ?></option>
                  <?php } ?>
                  </select></td>
                <td><input type="date" name="inicio" id="inicio"></td>
                <td><input type="date" name="final" id="final"></td>
                <td><input type="number" name="personas" id="personas" min="0" max="20" value="0"></td>
              </tr>
              <tr><td colspan="5"><input type="submit" value="ENCUENTRA TU DESTINO PERFECTO" name="enviar" class="boton" style="width: 100%; font-weight: bold;"></td></tr>
            </table>
          </form>
        </div>
    </div>
    <div class="wrapper1">
        <div class="slider" id="slider">
          <ul class="slides">
            <?php
            $query_result2 = mysqli_query($connection, $accomodation_query);
            while ($result_formated2 = mysqli_fetch_row($query_result2)){
            ?>
            <li class="slide">
              <a href="destino_seleccionado.php?id=<?php echo $result_formated2[0]; ?>">
                <p class="caption"><?php echo $result_formated2[1]; ?></p>
                <img class="foto bordes" src="img/Destinos/<?php echo $result_formated2[4]; ?>.jpg">
              </a>
            </li>
            <?php }?>
          </ul>
        </div>
      </div>
      <?php include 'footer.php' ?>
</body>
</html>