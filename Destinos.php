<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Núria y Óscar">
    <meta name="copyright" content="VIAMPER">
    <link rel="stylesheet" href="CSS/EstiloViamper.css">
    <style>
        .bordes{
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            border-bottom-left-radius: 7px;
            border-bottom-right-radius: 7px;
        }
        .margen{
            margin-left: auto;
            margin-right: auto;
            margin-top: 30px;
            background-color: rgb(172, 204, 150);
        }
        a {
            text-decoration: none;
            color: black;
        }
    </style>
    <title>Destinos</title>
</head>

<body>
<?php include 'header.php'; 
function quitarDecimales($numero) {
    return number_format((float)$numero, 2, '.', '');
  }
?>
<div class="wrapper">
        <div style="text-align:center;">
          <form action="" class="formularios registro buscar" method="post" enctype="multipart/form-data">
            <table align="center" style="width:100%;">
              <tr>
                <td><label for="precio">Precio</label></td>
                <td><label for="estrellas">Estrellas</label></td>
                <td><label for="pension">Pensión</label></td>
                <td><label for="ubicacion">Ubicación</label></td>
                <td><label for="cantidad">Cantidad</label></td>
              </tr>
              <tr>
                <td><select name="precio" id="precio">
                <option>-</option>
                    <option value="precio1"<?php if(isset($_POST['precio']) && $_POST['precio'] == 'precio1') echo ' selected'; ?>>100€-200€</option>
                    <option value="precio2"<?php if(isset($_POST['precio']) && $_POST['precio'] == 'precio2') echo ' selected'; ?>>200€-400€</option>
                    <option value="precio3"<?php if(isset($_POST['precio']) && $_POST['precio'] == 'precio3') echo ' selected'; ?>>400€-700€</option>
                    <option value="precio4"<?php if(isset($_POST['precio']) && $_POST['precio'] == 'precio4') echo ' selected'; ?>>700€-900€</option>
                    </select></td>

                <td><select name="estrellas" id="estrellas">
                <option>-</option>
                    <option value="5"<?php if(isset($_POST['estrellas']) && $_POST['estrellas'] == '5') echo ' selected'; ?>>5</option>
                    <option value="4"<?php if(isset($_POST['estrellas']) && $_POST['estrellas'] == '4') echo ' selected'; ?>>4</option>
                    <option value="3"<?php if(isset($_POST['estrellas']) && $_POST['estrellas'] == '3') echo ' selected'; ?>>3</option>
                    <option value="2"<?php if(isset($_POST['estrellas']) && $_POST['estrellas'] == '2') echo ' selected'; ?>>2</option>
                    <option value="1"<?php if(isset($_POST['estrellas']) && $_POST['estrellas'] == '1') echo ' selected'; ?>>1</option>
                  </select></td>
                
                <td><select name="pension" id="pension">
                <option>-</option>
                    <option value="Completa"<?php if(isset($_POST['pension']) && $_POST['pension'] == 'Completa') echo ' selected'; ?>>Completa</option>
                    <option value="Mitjana"<?php if(isset($_POST['pension']) && $_POST['pension'] == 'Mitjana') echo ' selected'; ?>>Media</option>
                    <option value="NULL"<?php if(isset($_POST['pension']) && $_POST['pension'] == 'NULL') echo ' selected'; ?>>Sin pension</option>
                  </select></td>
                
                <td><select name="ubicacion" id="ubicacion">
                <option>-</option>
                <?php
                    $ubicacion_query="select pais, ciutat from allotjament;";
                    $query_result = mysqli_query($connection, $ubicacion_query);
                    while ($result_formated = mysqli_fetch_row($query_result)){ ?>
                        <option value="<?php echo $result_formated[0]; ?>, <?php echo $result_formated[1]; ?>"<?php 
                        if(isset($_POST['ubicacion']) && $_POST['ubicacion'] == $result_formated[0] . ', ' . $result_formated[1]) 
                        echo ' selected'; ?>><?php echo $result_formated[1]; ?>, <?php echo $result_formated[0]; ?></option>
                    <?php } ?>
                    </select></td>    
                <td><select name="cantidad" id="cantidad">
                <option>-</option>
                    <option value="ASC"<?php if(isset($_POST['cantidad']) && $_POST['cantidad'] == 'ASC') echo ' selected'; ?>>Ascendente</option>
                    <option value="DESC"<?php if(isset($_POST['cantidad']) && $_POST['cantidad'] == 'DESC') echo ' selected'; ?>>Descendente</option>
                  </select></td>
              </tr>
              <tr><td colspan="5"><input type="submit" value="Filtrar" name="enviar" class="boton" style="width: 100%; font-weight: bold;"></td></tr>
            </table>
          </form>
        </div>
</div>
<?php
if(isset($_POST['enviar'])){
    $precio = $_POST['precio'];
    $max=0;
    $min=1000;
    $estrellas = $_POST['estrellas'];
    $pension = $_POST['pension'];
    $ubicacion = $_POST['ubicacion'];
    $cantidad = $_POST['cantidad'];
    if($precio!="-" || $estrellas!="-"  || $pension!="-"  || $ubicacion!="-"  || $cantidad!="-"){
        switch($precio){
            case "precio1":
                $max=200;
                $min=100;
            break;
            case "precio2":
                $max=400;
                $min=200;
            break;
            case "precio3":    
                $max=700;
                $min=400;
            break;
            case "precio4":
                $max=900;
                $min=700;
            break;
        }
        if($precio!="-" || $estrellas!="-"  || $pension!="-"  || $ubicacion!="-"){
            $accomodation_query = "SELECT * FROM allotjament WHERE";
            $AND=false;
            // Comprobación de rango de precios
            if ($precio != "-") {
                $accomodation_query .= " preu <= $max AND preu >= $min";
                // se utiliza el .= para concatenar
                $AND=true;
            }
            
            // Comprobación de calidad
            if ($estrellas != "-") {
                if ($AND==true) {
                    $accomodation_query .= " AND calitat = '$estrellas'";
                } else {
                    $accomodation_query .= " calitat = '$estrellas'";
                    $AND=true;
                }
            }
            // Comprobación de pension
            if ($pension != "-") {
                if ($AND==true) {
                    if($pension =='NULL'){
                        $accomodation_query .= " AND pensio is null'";
                    }else{
                        $accomodation_query .= " AND pensio = '$pension'";
                    }
                } else {
                    $AND=true;
                    if($pension =='NULL'){
                        $accomodation_query .= " pensio is null";
                    }else{
                        $accomodation_query .= " pensio = '$pension'";
                    }
                }
            }
            // Comprobación de ubicacion
            if ($ubicacion != "-") {
                list($pais, $ciudad) = explode(", ", $ubicacion); // Divide la cadena y asigna los valores a $pais y $ciudad para poder hacer la consulta
                if ($AND==true) {
                    $accomodation_query .= " AND pais = '$pais' AND ciutat = '$ciudad'";
                } else {
                    $accomodation_query .= " pais = '$pais' AND ciutat = '$ciudad'";
                    $AND=true;
                }
            }
            // Comprobación de cantidad
            if ($cantidad != "-") {
                    $accomodation_query .= " ORDER BY preu $cantidad, calitat $cantidad";
            }
            $accomodation_query .= ";";

        }else{
            // sin el else da error porque hay un where vacio
            $accomodation_query = "SELECT * FROM allotjament ORDER BY preu $cantidad, calitat $cantidad;";
        }
        
    }else{
        ?><p style="text-align: center">Debes rellenar los filtros</p><?php
        $accomodation_query="select * from allotjament;";
    }
}else{
    $accomodation_query="select * from allotjament;";
}
$query_result = mysqli_query($connection, $accomodation_query);
?>
<?php
if(empty($query_result)){
    // empty para mirar si el array esta vacio
?>
    <div class="wrapper formularios registro buscar" style="margin-top: 30px;">
        <h2 class="titulo">Uy, no tenemos destinos disponibles con los filtros que has puesto.</h2>
        <div style="text-align:center;">
            <form action="Coches.php" method="post">
            <input type="submit" value="¡Haz que eso cambie!" name="example" class="boton" style="font-weight: bold;">
            </form>
        </div>
    </div>
<?php
}else{
        // Mostrar el mensaje acción
        if(isset($_GET['mensaje'])){
            if($_GET['mensaje'] === 'true') {
                echo "<p style='text-align: center'>Añadido a tu lista de deseos.</p>";
            } else {
                echo "<p style='text-align: center'>Retirado de tu lista de deseos.</p>";
            }
        }      
    while ($result_formated = mysqli_fetch_row($query_result)){
        ?>
        <div class="margen bordes" style="width: 35%;">
        <a href="destino_seleccionado.php?id=<?php echo $result_formated[0];?>">
        <table class="bordes" style="padding: 10px; margin-left: 10%;">
                <tbody>
                    <tr>
                        <td rowspan="2"><img class="bordes" src="img/Destinos/<?php echo $result_formated[4]; ?>.jpg" style="max-width: 200px; margin-right: 40px"></td>
                        <?php
                        if(isset($_SESSION['usuario'])&& $_SESSION['puesto']=="cliente") {
                            $query="select ID, clients_UID from llista_desitjos where allotjament_ID = " . $result_formated[0] . "  AND clients_UID= (select UID from clients where login = '" . $_SESSION['usuario'] . "');";
                            $query_result2 = mysqli_query($connection, $query); 
                            if(mysqli_num_rows($query_result2) == 0){
                                ?>
                                <td style="text-align: left;"><a href="Destinos.php?consulta=true&destinos=<?php echo $result_formated[0]; ?>"><img class="bordes" src="img/no_guardado.png" style="max-width: 30px;"></a></td>
                                <?php
                            }else{
                                ?>
                                <td style="text-align: left;"><a href="Destinos.php?consulta=false&destinos=<?php echo $result_formated[0]; ?>"><img class="bordes" src="img/si_guardado.png" style="max-width: 30px;"></a></td>
                                <?php
                            }  
                        }  
                        ?>
                    </tr>
                    <tr>
                        <td><p><?php echo $result_formated[1]; ?><br><br>
                            Estrellas: <?php echo $result_formated[2]; ?><br>
                            Ubicación: <?php echo $result_formated[4]; ?>, <?php echo $result_formated[3]; ?><br>
                            Pensión: <?php if ($result_formated[5]) {echo $result_formated[5];} else {echo "Sin pensión";} ?><br></p>
                            Precio: <?php echo quitarDecimales($result_formated[10])?><br>
                        </td>
                    </tr>
                </tbody>
        </table>
        </a>
        </div>
        <?php } ?>  
<?php
 // consulta al clicar en el corazón
 if (isset($_GET['consulta'])) {
    if($_GET['consulta']==="true"){
        $mensaje_corazon = true;
        $query3="select UID from clients where login = '" . $_SESSION['usuario'] . "';";
        $query_result3 = mysqli_query($connection, $query3);            
        while ($result_formated3 = mysqli_fetch_row($query_result3)){
            $id_cliente = $result_formated3[0];
        }
        $insert = "INSERT INTO `llista_desitjos` (`allotjament_ID`, `clients_UID`) 
        VALUES (" . $_GET['destinos'] . ", '" . $id_cliente . "')"; 
        mysqli_query($connection, $insert);
    }else{
        $mensaje_corazon = false;
        // eliminar
        $delete_query = "DELETE FROM `llista_desitjos` WHERE allotjament_ID = " . $_GET['destinos'];
        mysqli_query($connection, $delete_query);
        // el valor del ID de deseos se autoincrementa sin parar pero no afecta al rendimiento, afectaria si esto se ajustará
    }
    }
}
?>
<script>
    <?php if (isset($_GET['consulta'])): ?>
        window.location.href = 'Destinos.php?mensaje=<?php echo $mensaje_corazon ? "true" : "false"; ?>';
        //redirecciona para que se efectuen los cambios
    <?php endif; ?>
    </script>
<?php include 'footer.php' ?>
</body>
</html>