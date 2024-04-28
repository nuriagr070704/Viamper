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
        <title>Coches de alquiler</title>
    </head>
    <body>
    <?php include 'header.php';?>
    <div class="wrapper">
            <div style="text-align:center;">
            <form action="" class="formularios registro buscar" method="post" enctype="multipart/form-data">
                <table align="center" style="width:100%;">
                <tr>
                    <td><label for="marca">Marca</label></td>
                    <td><label for="modelo">Modelo</label></td>
                    <td><label for="asientos">Asientos</label></td>
                    <td><label for="puertas">Puertas</label></td>
                    <td><label for="t_marcha">Tipo de marcha</label></td>
                </tr>
                <tr>
                    <td><select name="marca" id="marca">
                    <option>-</option>
                    <?php
                        $coche_query="select marca from cotxe;";
                        $query_result = mysqli_query($connection, $coche_query);
                        while ($result_formated = mysqli_fetch_row($query_result)){ ?>
                            <option value="<?php echo $result_formated[0]; ?>"<?php 
                            if(isset($_POST['marca']) && $_POST['marca'] == $result_formated[0]) 
                            echo ' selected'; ?>><?php echo $result_formated[0] ?></option>
                    <?php } ?>    
                        </select></td>

                    <td><select name="modelo" id="modelo">
                    <option>-</option>
                    <?php
                        $coche_query="select model from cotxe;";
                        $query_result = mysqli_query($connection, $coche_query);
                        while ($result_formated1 = mysqli_fetch_row($query_result)){ ?>
                            <option value="<?php echo $result_formated1[0]; ?>"<?php 
                            if(isset($_POST['modelo']) && $_POST['modelo'] == $result_formated1[0]) 
                            echo ' selected'; ?>><?php echo $result_formated1[0] ?></option>
                    <?php } ?>    
                    </select></td>
                    
                    <td><select name="asientos" id="asientos">
                    <option>-</option>
                        <option value="2-4"<?php if(isset($_POST['asientos']) && $_POST['asientos'] == '2-4') echo ' selected'; ?>>2-4</option>
                        <option value="5-6"<?php if(isset($_POST['asientos']) && $_POST['asientos'] == '5-6') echo ' selected'; ?>>5-6</option>
                        <option value="7-9"<?php if(isset($_POST['asientos']) && $_POST['asientos'] == '7-9') echo ' selected'; ?>>7-9</option>
                    </select></td>
                    
                    <td><select name="puertas" id="puertas">
                    <option>-</option>
                        <option value="3"<?php if(isset($_POST['puertas']) && $_POST['puertas'] == '3') echo ' selected'; ?>>3</option>
                        <option value="5"<?php if(isset($_POST['puertas']) && $_POST['puertas'] == '5') echo ' selected'; ?>>5</option>
                        </select></td>    

                    <td><select name="t_marcha" id="t_marcha">
                    <option>-</option>
                        <option value="manual"<?php if(isset($_POST['t_marcha']) && $_POST['t_marcha'] == 'manual') echo ' selected'; ?>>Manual</option>
                        <option value="automatica"<?php if(isset($_POST['t_marcha']) && $_POST['t_marcha'] == 'automatica') echo ' automática'; ?>>Automática</option>
                    </select></td>
                </tr>
                <tr><td colspan="5"><input type="submit" value="Filtrar" name="enviar" class="boton" style="width: 100%; font-weight: bold;"></td></tr>
                </table>
            </form>
            </div>
    </div>
    <?php
    if(isset($_POST['enviar'])){
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $asientos = $_POST['asientos'];
        $puertas = $_POST['puertas'];
        $t_marcha = $_POST['t_marcha'];
        if($marca!="-" || $modelo!="-"  || $asientos!="-"  || $puertas!="-"  || $t_marcha!="-"){
                $accomodation_query = "SELECT * FROM cotxe WHERE";
                $AND=false;
                // Comprobación de marca
                if ($marca != "-") {
                        $accomodation_query .= " marca = '$marca'";
                        $AND=true;
                }
                
                // Comprobación de modelo
                if ($modelo != "-") {
                    if ($AND==true) {
                        $accomodation_query .= " AND model = '$modelo'";
                    } else {
                        $accomodation_query .= " model = '$modelo'";
                        $AND=true;
                    }
                }
                // Comprobación de asientos
                if ($asientos != "-") {
                    $array_asientos = explode("-", $asientos);
                    if ($AND==true) {
                        $accomodation_query .= " AND seients <= $array_asientos[0] AND seients >= $array_asientos[1]";
                    } else {
                        $accomodation_query .= " seients >= $array_asientos[0] AND seients <= $array_asientos[1]";
                        $AND=true;
                    }
                }
                 // Comprobación de puertas
                 if ($puertas != "-") {
                    if ($AND==true) {
                        $accomodation_query .= " AND portes = '$puertas'";
                    } else {
                        $accomodation_query .= " portes = '$puertas'";
                        $AND=true;
                    }
                }
                // Comprobación de t_marcha
                if ($t_marcha != "-") {
                    if ($AND==true) {
                        $accomodation_query .= "  AND tipusmarxa = '$t_marcha'";
                    } else {
                        $accomodation_query .= " tipusmarxa = '$t_marcha'";
                        $AND=true;
                    }
                }
                $accomodation_query .= ";";
            }else{
                ?><p style="text-align: center">Debes rellenar los filtros</p><?php
                $accomodation_query="select * from cotxe;";
            }         
    }else{
        $accomodation_query="select * from cotxe;";
    }
    $query_result = mysqli_query($connection, $accomodation_query);
    ?>
    <?php
    if(empty($query_result)){
        // empty para mirar si el array esta vacio
    ?>
    <div class="wrapper formularios registro buscar" style="margin-top: 30px;">
        <h2 class="titulo">Uy, no hay coches disponibles con los filtros que has puesto.</h2>
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
            <a href="coche_seleccionado.php?id=<?php echo $result_formated[0]; ?>">
            <table class="bordes" style="padding: 10px; margin-left: 10%;">
                <tbody>
                    <tr>
                        <td rowspan="2"><img class="bordes" src="img/CochesAlquiler/<?php echo $result_formated[0]; ?>.jpg" style="max-width: 200px; margin-right: 40px"></td> 
                        <?php
                        if(isset($_SESSION['usuario'])&& $_SESSION['puesto']=="cliente") {
                            $query="select ID, clients_UID from llista_desitjos where cotxe_ID = " . $result_formated[0] . "  AND clients_UID= (select UID from clients where login = '" . $_SESSION['usuario'] . "');";
                            $query_result2 = mysqli_query($connection, $query);                             
                            if(mysqli_num_rows($query_result2) == 0){
                                ?>
                                <td style="text-align: left;"><a href="coches.php?consulta=true&coche=<?php echo $result_formated[0]; ?>"><img class="bordes" src="img/no_guardado.png" style="max-width: 30px;"></a></td>
                                <?php
                            }else{        
                                ?>
                                <td style="text-align: left;"><a href="coches.php?consulta=false&coche=<?php echo $result_formated[0]; ?>"><img class="bordes" src="img/si_guardado.png" style="max-width: 30px;"></a></td>
                                <?php
                            }  
                        }  
                        ?>
                    </tr>
                    <tr>
                        <td><p><?php echo $result_formated[1]; ?><br><br>
                            Marca: <?php echo $result_formated[2]; ?><br>
                            Modelo: <?php echo $result_formated[3]; ?><br>
                            Asientos: <?php echo $result_formated[5]; ?><br>
                            Puertas: <?php echo $result_formated[6]; ?><br>
                            Tipo de marcha: <?php echo $result_formated[7]; ?><br></p>
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
            $insert = "INSERT INTO `llista_desitjos` (`cotxe_ID`, `clients_UID`) 
            VALUES (" . $_GET['coche'] . ", '" . $id_cliente . "')"; 
            mysqli_query($connection, $insert);
        }else{
            $mensaje_corazon = false;
            // eliminar
            $delete_query = "DELETE FROM `llista_desitjos` WHERE cotxe_ID = " .$_GET['coche'];
            mysqli_query($connection, $delete_query);
            // el valor del ID de deseos se autoincrementa sin parar pero no afecta al rendimiento, afectaria si esto se ajustará
        }
        }
    }
    ?>
    <script>
    <?php if (isset($_GET['consulta'])): ?>
        window.location.href = 'Coches.php?mensaje=<?php echo $mensaje_corazon ? "true" : "false"; ?>';
            //redirecciona para que se efectuen los cambios
    <?php endif; ?>
    </script>
    <?php include 'footer.php' ?>
    </body>
</html>